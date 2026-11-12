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

    public function test_order_modal_has_both_donor_email_and_confidential_results_email_fields(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Verify separate lines for donor email and confidential results email in the order modal
        $response->assertSee('Donor / Electronic Pass Email', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('Confidential Results Email', false);
        $response->assertSee('name="results_email"', false);
    }

    public function test_checkout_defaults_to_unselected_category_and_zero_price(): void
    {
        $response = $this->get('/checkout');
        $response->assertStatus(200);

        // Category dropdown defaults to "Select Type / Category of Test"
        $response->assertSee('Select Type / Category of Test', false);

        // Panel dropdown defaults to "-- Select Category First --"
        $response->assertSee('-- Select Category First --', false);

        // Price preview shows $0.00 until product is chosen
        $response->assertSee('$0.00', false);
        $response->assertSee('Please Select a Test Panel', false);
    }

    public function test_checkout_urine_category_excludes_background_checks_and_physicals(): void
    {
        $response = $this->get('/checkout?category=urine');
        $response->assertStatus(200);

        // When urine is selected, urine panel is present in the select options
        $response->assertSee('5 Panel NON-DOT', false);

        // Non-urine products must NOT be rendered in the select options
        $response->assertDontSee('<option value="25"', false); // Basic Level Background Check
        $response->assertDontSee('<option value="43"', false); // Non-DOT Physical
        $response->assertDontSee('<option value="53"', false); // Respirator Fit
        $response->assertDontSee('<option value="56"', false); // Vision Test Snellen
    }

    public function test_homepage_express_checkout_defaults_to_blank_category_and_zero_price(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Express Online Order category dropdown defaults to blank placeholder
        $response->assertSee('Select Type / Category of Test</option>', false);

        // Panel dropdown defaults to category first placeholder
        $response->assertSee('-- Select Category First --</option>', false);

        // Price display shows $0.00 and prompt
        $response->assertSee('Please Select a Test Panel', false);
        $response->assertSee('$0.00', false);
    }
}

