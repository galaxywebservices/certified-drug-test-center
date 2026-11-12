<?php

namespace Tests\Unit;

use App\Models\Setting;
use App\Services\PayTraceService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PayTraceServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Setting::whereIn('key', ['paytrace_username', 'paytrace_password', 'paytrace_test_mode'])->delete();
        parent::tearDown();
    }

    public function test_payload_has_correct_parameter_names_for_paytrace_v1()
    {
        // Disable simulation test mode to exercise the real payload construction
        Setting::set('paytrace_username', 'live_merchant_user');
        Setting::set('paytrace_password', 'secret_password');
        Setting::set('paytrace_test_mode', '0');

        Http::fake([
            'https://api.paytrace.com/oauth/token' => Http::response([
                'access_token' => 'fake_bearer_token_123',
                'token_type' => 'Bearer',
                'expires_in' => 3600,
            ], 200),
            'https://api.paytrace.com/v1/transactions/sale/keyed' => function ($request) {
                $payload = $request->data();

                // 1. Verify credit_card does NOT contain csc
                $this->assertArrayNotHasKey('csc', $payload['credit_card'] ?? []);

                // 2. Verify root payload has csc
                $this->assertEquals('999', $payload['csc']);

                // 3. Verify billing_address contains zip, NOT postal_code
                $this->assertEquals('32801', $payload['billing_address']['zip']);
                $this->assertArrayNotHasKey('postal_code', $payload['billing_address']);

                // 4. Verify amount format
                $this->assertEquals('89.99', $payload['amount']);

                return Http::response([
                    'success' => true,
                    'transaction_id' => '12345678',
                    'approval_code' => 'APP999',
                    'status_message' => 'Your transaction was approved.',
                ], 200);
            },
        ]);

        $service = new PayTraceService();
        $result = $service->processSale(
            ['donor_name' => 'John Doe', 'total' => 89.99],
            [
                'card_number' => '4012881888818888',
                'exp' => '12/28',
                'cvv' => '999',
                'billing_zip' => '32801',
            ]
        );

        $this->assertTrue($result['success']);
        $this->assertEquals('12345678', $result['transaction_id']);
        $this->assertEquals('APP999', $result['approval_code']);
    }

    public function test_detailed_error_messages_are_extracted_from_paytrace_decline()
    {
        Setting::set('paytrace_username', 'live_merchant_user');
        Setting::set('paytrace_password', 'secret_password');
        Setting::set('paytrace_test_mode', '0');

        Http::fake([
            'https://api.paytrace.com/oauth/token' => Http::response([
                'access_token' => 'fake_bearer_token_123',
            ], 200),
            'https://api.paytrace.com/v1/transactions/sale/keyed' => Http::response([
                'success' => false,
                'response_code' => 1,
                'status_message' => 'One or more errors has occurred.',
                'errors' => [
                    '103' => ['The card has expired.'],
                ],
            ], 400),
        ]);

        $service = new PayTraceService();
        $result = $service->processSale(
            ['donor_name' => 'John Doe', 'total' => 89.99],
            [
                'card_number' => '4012881888818888',
                'exp' => '12/24',
                'cvv' => '999',
                'billing_zip' => '32801',
            ]
        );

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('The card has expired.', $result['message']);
    }
}
