<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutAutoPopulateTest extends TestCase
{
    public function test_checkout_auto_populates_query_parameters(): void
    {
        $response = $this->get('/checkout?' . http_build_query([
            'test_name' => '5 Panel Non-DOT Urine Test (Basic)',
            'product_id' => '5-panel-non-dot',
            'zip' => '32323',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'donor@example.com',
            'results_email' => 'results@example.com',
            'phone' => '(555) 000-0000',
            'dob' => '1990-05-15',
            'test_reason' => 'Pre-Employment',
            'donor_id_number' => '123456',
        ]));

        $response->assertStatus(200);

        // Assert input values are auto-populated
        $response->assertSee('value="John"', false);
        $response->assertSee('value="Doe"', false);
        $response->assertSee('value="donor@example.com"', false);
        $response->assertSee('value="results@example.com"', false);
        $response->assertSee('value="(555) 000-0000"', false);
        $response->assertSee('value="1990-05-15"', false);
        $response->assertSee('value="32323"', false);
        $response->assertSee('value="123456"', false);
        $response->assertSee('value="Pre-Employment" selected', false);
    }

    public function test_checkout_resolves_slug_without_numeric_typecast_collision(): void
    {
        $response = $this->get('/checkout?product_id=5-panel-non-dot');
        $response->assertStatus(200);

        // Ensure it resolved to 5 Panel NON-DOT, not Product #5 Return to Duty
        $response->assertSee('5 Panel NON-DOT');
    }
}

