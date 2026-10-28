<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Lead;

class PlatformSmokeTest extends TestCase
{
    public function test_homepage_loads_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Certified Drug Test Centers');
    }

    public function test_product_detail_loads_successfully()
    {
        $response = $this->get('/product/5-panel-nondot');
        $response->assertStatus(200);
        $response->assertSee('5 Panel NON-DOT');
    }

    public function test_category_hub_loads_successfully()
    {
        $response = $this->get('/category/urine');
        $response->assertStatus(200);
        $response->assertSee('Urine');
    }

    public function test_pseo_locations_directory_loads()
    {
        $response = $this->get('/locations');
        $response->assertStatus(200);
        $response->assertSee('Collection Locations');
    }

    public function test_pseo_city_guide_loads_with_locations()
    {
        $response = $this->get('/locations/arizona/gilbert');
        $response->assertStatus(200);
        $response->assertSee('Gilbert');
    }

    public function test_background_checks_page_loads_without_legacy_code()
    {
        $response = $this->get('/background-checks');
        $response->assertStatus(200);
        $response->assertSee('Background Check Services for Employers');
        $response->assertDontSee('\"Background');
    }

    public function test_contact_page_loads_and_redirects_alias()
    {
        $redirect = $this->get('/contact');
        $redirect->assertRedirect('/contact-us');

        $response = $this->get('/contact-us');
        $response->assertStatus(200);
        $response->assertSee('Send Us an Inquiry');
        $response->assertSee('(800) 221-4291');
    }

    public function test_contact_form_submission_stores_lead()
    {
        $payload = [
            'name' => 'Automated Test User',
            'email' => 'test@example.com',
            'phone' => '800-221-4291',
            'company' => 'QA Testing Corp',
            'service_type' => 'drug-testing',
            'message' => 'Automated verification test of lead intake submission.',
        ];

        $response = $this->post('/contact-us', $payload);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('leads', [
            'email' => 'test@example.com',
            'company' => 'QA Testing Corp',
        ]);
    }

    public function test_checkout_page_loads()
    {
        $response = $this->get('/checkout');
        $response->assertStatus(200);
        $response->assertSee('Secure Checkout');
    }

    public function test_seo_sitemap_returns_valid_xml()
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');
    }

    public function test_aeo_and_geo_files_return_200()
    {
        $this->get('/robots.txt')->assertStatus(200);
        $this->get('/llms.txt')->assertStatus(200);
        $this->get('/llms-full.txt')->assertStatus(200);
    }

    public function test_super_admin_login_page_loads()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
        $response->assertSee('Super Admin');
    }

    public function test_product_search_api_returns_results()
    {
        $response = $this->getJson('/api/products/search?q=10');
        $response->assertStatus(200);
        $response->assertJsonStructure(['results']);

        $fentanylSearch = $this->getJson('/api/products/search?q=fentanyl');
        $fentanylSearch->assertStatus(200);
        $fentanylSearch->assertJsonStructure(['results']);
    }

    public function test_locations_search_api_returns_locations()
    {
        $response = $this->getJson('/api/locations/search?zip=85296');
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(['success', 'locations']);
    }

    public function test_category_page_displays_substance_detection_matrix()
    {
        $response = $this->get('/category/urine');
        $response->assertStatus(200);
        $response->assertSee('Substance Detection Comparison Matrix');
        $response->assertSee('Amphetamines & Methamphetamine', false);
        $response->assertSee('12-Panel Maximum');
    }

    public function test_order_tracking_page_loads_and_redirects_aliases()
    {
        $this->get('/donor-pass')->assertRedirect('/track-order');
        $this->get('/order-status')->assertRedirect('/track-order');

        $response = $this->get('/track-order');
        $response->assertStatus(200);
        $response->assertSee('Track Order');
        $response->assertSee('Lookup Test Registration');
    }

    public function test_order_tracking_lookup_validation_and_lookup()
    {
        $this->post('/track-order', [])
            ->assertSessionHasErrors(['order_number', 'email']);

        $order = \App\Models\Order::firstOrCreate(
            ['order_number' => 'CDTC-TEST1234'],
            [
                'donor_first_name' => 'John',
                'donor_last_name' => 'Doe',
                'donor_email' => 'donor@example.com',
                'donor_phone' => '800-221-4291',
                'test_reason' => 'Pre-employment',
                'subtotal' => 89.99,
                'total' => 89.99,
                'payment_status' => 'paid',
                'donor_pass_token' => 'test-token-tracking-12345',
                'status' => 'registered',
            ]
        );

        $lookup = $this->post('/track-order', [
            'order_number' => 'CDTC-TEST1234',
            'email' => 'donor@example.com',
        ]);
        $lookup->assertStatus(200);
        $lookup->assertSee('CDTC-TEST1234');
        $lookup->assertSee('John Doe');
        $lookup->assertSee('Official Electronic Donor Pass');
    }

    public function test_product_page_displays_clinical_testing_protocols()
    {
        $response = $this->get('/product/5-panel-nondot');
        $response->assertStatus(200);
        $response->assertSee('Clinical Testing Protocols', false);
        $response->assertSee('SAMHSA-Certified Laboratories');
    }
}


