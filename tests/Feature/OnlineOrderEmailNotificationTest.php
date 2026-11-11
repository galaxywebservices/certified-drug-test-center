<?php

namespace Tests\Feature;

use App\Mail\DonorPassMail;
use App\Mail\OnlineOrderNotificationMail;
use App\Models\Location;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OnlineOrderEmailNotificationTest extends TestCase
{
    public function test_online_order_sends_to_onlineorders_and_bccs_designated_emails(): void
    {
        Mail::fake();
        Setting::set('online_orders_email', 'onlineorders@accrediteddrugtesting.com', 'orders');
        Setting::set('online_orders_bcc', 'galaxywebservices@gmail.com, jacserafini@gmail.com', 'orders');

        $product = Product::first() ?? Product::create([
            'name' => '5 Panel Non-DOT Urine Test',
            'slug' => '5-panel-non-dot-test',
            'price' => 89.99,
            'is_active' => true,
        ]);

        $postData = [
            'product_id' => $product->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'results_email' => 'results@example.com',
            'phone' => '(555) 123-4567',
            'dob' => '1990-01-01',
            'zip' => '90210',
            'test_reason' => 'Pre-Employment',
            'donor_id_number' => '123456',
            'card_name' => 'John Doe',
            'card_number' => '4111111111111111',
            'exp' => '12/28',
            'cvv' => '123',
            'billing_zip' => '90210',
            'refund_policy_agreed' => '1',
        ];

        $response = $this->post(route('checkout.process'), $postData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        // 1. Assert DonorPassMail was sent to donor
        Mail::assertSent(DonorPassMail::class, function ($mail) {
            return $mail->hasTo('johndoe@example.com');
        });

        // 2. Assert OnlineOrderNotificationMail was sent to onlineorders@accrediteddrugtesting.com
        // and BCC to galaxywebservices@gmail.com and jacserafini@gmail.com
        Mail::assertSent(OnlineOrderNotificationMail::class, function ($mail) {
            $hasTo = $mail->hasTo('onlineorders@accrediteddrugtesting.com');
            $hasBcc1 = $mail->hasBcc('galaxywebservices@gmail.com');
            $hasBcc2 = $mail->hasBcc('jacserafini@gmail.com');

            return $hasTo && $hasBcc1 && $hasBcc2;
        });
    }

    public function test_online_order_email_template_renders_properly(): void
    {
        $uniqueOrderNumber = 'CDTC-TEST-' . strtoupper(substr(md5(uniqid()), 0, 8));
        $order = Order::create([
            'order_number' => $uniqueOrderNumber,
            'donor_first_name' => 'Jane',
            'donor_last_name' => 'Smith',
            'donor_email' => 'jane@example.com',
            'results_email' => 'hr@company.com',
            'donor_phone' => '(555) 987-6543',
            'donor_dob' => '1988-11-20',
            'test_reason' => 'Random',
            'dot_agency' => 'FMCSA',
            'cdl_number' => 'CDL999888',
            'cdl_state' => 'CA',
            'donor_id_number' => '999888777',
            'subtotal' => 99.99,
            'total' => 99.99,
            'payment_status' => 'paid',
            'paytrace_transaction_id' => 'PT-999888777',
            'paytrace_approval_code' => 'AP123456',
            'donor_pass_token' => 'test-token-' . uniqid(),
            'status' => 'registered',
            'refund_policy_agreed' => true,
        ]);

        $mailable = new OnlineOrderNotificationMail($order);
        $rendered = $mailable->render();

        $this->assertStringContainsString($uniqueOrderNumber, $rendered);
        $this->assertStringContainsString('Jane Smith', $rendered);
        $this->assertStringContainsString('jane@example.com', $rendered);
        $this->assertStringContainsString('hr@company.com', $rendered);
        $this->assertStringContainsString('FMCSA', $rendered);
        $this->assertStringContainsString('CDL999888', $rendered);
        $this->assertStringContainsString('$99.99', $rendered);
        $this->assertStringContainsString('onlineorders@accrediteddrugtesting.com', $rendered);
    }

    public function test_admin_can_update_online_order_email_settings(): void
    {
        $admin = User::first() ?? User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), [
            'site_name' => 'Certified Drug Test Center',
            'site_phone' => '(800)-985-4339',
            'site_email' => 'support@certifieddrugtestingcenters.com',
            'site_tagline' => 'Accredited Drug Testing',
            'online_orders_email' => 'orders-desk@accrediteddrugtesting.com',
            'online_orders_bcc' => 'galaxywebservices@gmail.com, jacserafini@gmail.com, monitor@example.com',
            'paytrace_username' => 'demo123',
            'paytrace_integrator_id' => '123456',
            'paytrace_test_mode' => '1',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.settings.index'));

        $this->assertEquals('orders-desk@accrediteddrugtesting.com', Setting::get('online_orders_email'));
        $this->assertEquals('galaxywebservices@gmail.com, jacserafini@gmail.com, monitor@example.com', Setting::get('online_orders_bcc'));
    }
}
