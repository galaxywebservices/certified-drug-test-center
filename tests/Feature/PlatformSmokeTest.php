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
}
