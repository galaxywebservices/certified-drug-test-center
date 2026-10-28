<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayTraceService
{
    protected string $username;
    protected string $password;
    protected string $integratorId;
    protected bool $testMode;

    public function __construct()
    {
        $this->username = Setting::get('paytrace_username', env('PAYTRACE_USERNAME', 'demo123'));
        $this->password = Setting::get('paytrace_password', env('PAYTRACE_PASSWORD', 'password123'));
        $this->integratorId = Setting::get('paytrace_integrator_id', env('PAYTRACE_INTEGRATOR_ID', '123456'));
        $this->testMode = (bool) Setting::get('paytrace_test_mode', env('PAYTRACE_TEST_MODE', true));
    }

    /**
     * Process a credit card sale transaction through PayTrace
     */
    public function processSale(array $orderData, array $paymentData): array
    {
        $baseUrl = $this->testMode
            ? 'https://api.sandbox.paytrace.com/v1'
            : 'https://api.paytrace.com/v1';

        // Check if sandbox / test simulation mode is enabled
        if ($this->testMode && ($this->username === 'demo123' || str_contains($this->username, 'test'))) {
            // Simulated instant successful approval for local testing & demos
            $simulatedTxId = 'PT-' . strtoupper(substr(md5(uniqid()), 0, 10));
            $simulatedApproval = 'AP' . rand(100000, 999999);

            return [
                'success' => true,
                'transaction_id' => $simulatedTxId,
                'approval_code' => $simulatedApproval,
                'message' => 'Approved (Test Mode Sandbox)',
                'raw_response' => [
                    'status' => 'APPROVED',
                    'transaction_id' => $simulatedTxId,
                    'approval_code' => $simulatedApproval,
                ],
            ];
        }

        try {
            // Live PayTrace API authentication & sale request
            $tokenResponse = Http::post("{$baseUrl}/oauth/token", [
                'grant_type' => 'password',
                'username' => $this->username,
                'password' => $this->password,
            ]);

            if (!$tokenResponse->successful()) {
                Log::error('PayTrace Auth Failed', ['response' => $tokenResponse->body()]);
                return [
                    'success' => false,
                    'message' => 'Payment Gateway authentication failed. Please contact support.',
                ];
            }

            $token = $tokenResponse->json('access_token');

            $expParts = explode('/', $paymentData['exp'] ?? '');
            $expMonth = trim($expParts[0] ?? '01');
            $expYear = trim($expParts[1] ?? '26');
            if (strlen($expYear) == 2) {
                $expYear = '20' . $expYear;
            }

            $salePayload = [
                'amount' => number_format((float) $orderData['total'], 2, '.', ''),
                'credit_card' => [
                    'number' => preg_replace('/\D/', '', $paymentData['card_number']),
                    'expiration_month' => str_pad($expMonth, 2, '0', STR_PAD_LEFT),
                    'expiration_year' => $expYear,
                ],
                'billing_address' => [
                    'name' => $orderData['donor_name'] ?? 'Donor',
                    'postal_code' => $paymentData['billing_zip'] ?? '10001',
                ],
                'integrator_id' => $this->integratorId,
            ];

            $saleResponse = Http::withToken($token)->post("{$baseUrl}/transactions/sale", $salePayload);

            if ($saleResponse->successful() && $saleResponse->json('success') === true) {
                return [
                    'success' => true,
                    'transaction_id' => (string) $saleResponse->json('transaction_id'),
                    'approval_code' => (string) $saleResponse->json('approval_code'),
                    'message' => 'Transaction Approved',
                    'raw_response' => $saleResponse->json(),
                ];
            }

            $errorMessage = $saleResponse->json('status_message') ?? 'Card declined or invalid payment details.';
            return [
                'success' => false,
                'message' => $errorMessage,
                'raw_response' => $saleResponse->json(),
            ];

        } catch (\Exception $e) {
            Log::error('PayTrace Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Payment processing encountered a communication error: ' . $e->getMessage(),
            ];
        }
    }
}
