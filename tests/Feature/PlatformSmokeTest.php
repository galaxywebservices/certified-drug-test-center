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
        $response->assertSee('(800)-985-4339');
    }

    public function test_contact_form_submission_stores_lead()
    {
        $payload = [
            'name' => 'Automated Test User',
            'email' => 'test@example.com',
            'phone' => '800-985-4339',
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
                'donor_phone' => '800-985-4339',
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

    public function test_employers_page_loads_and_redirects_aliases()
    {
        $response = $this->get('/employers');
        $response->assertStatus(200);
        $response->assertSee('Corporate Drug Testing', false);
        $response->assertSee('Corporate Rate & Savings Calculator', false);

        $this->get('/corporate-accounts')->assertRedirect('/employers');
        $this->get('/business-solutions')->assertRedirect('/employers');
        $this->get('/corporate')->assertRedirect('/employers');
    }

    public function test_corporate_account_intake_validation_and_submission()
    {
        // Validation check
        $this->post('/employers', [])
            ->assertSessionHasErrors(['company_name', 'contact_name', 'email', 'phone']);

        // Successful submission with candidates roster
        $response = $this->post('/employers', [
            'company_name' => 'Swift Freight Logistics',
            'industry' => 'Transportation & Logistics',
            'contact_name' => 'Michael Scott',
            'job_title' => 'Director of Safety',
            'email' => 'mscott@swiftfreight.com',
            'phone' => '800-555-0199',
            'monthly_volume' => '21-50 tests/mo',
            'billing_preference' => 'Net-30 Monthly Invoicing',
            'dot_regulated' => 'yes',
            'programs' => ['Pre-Employment Screening', 'DOT Random Consortium'],
            'notes' => 'Need immediate setup for 2 new commercial drivers.',
            'candidates' => [
                [
                    'name' => 'Jim Halpert',
                    'email' => 'jim@swiftfreight.com',
                    'phone' => '555-111-2222',
                    'test_panel' => '5-Panel DOT',
                    'zip' => '30301',
                ],
            ],
        ]);

        $response->assertRedirect('/employers');
        $response->assertSessionHas('corporate_success', true);
        $response->assertSessionHas('company_name', 'Swift Freight Logistics');

        // Verify Lead in database
        $this->assertDatabaseHas('leads', [
            'company' => 'Swift Freight Logistics',
            'name' => 'Michael Scott',
            'email' => 'mscott@swiftfreight.com',
            'service_type' => 'corporate-account',
        ]);
    }

    public function test_find_my_test_recommender_page_loads_and_redirects_aliases()
    {
        $response = $this->get('/find-my-test');
        $response->assertStatus(200);
        $response->assertSee('Guided Drug Test Recommendation Wizard', false);
        $response->assertSee('Question 1 of 3');

        $this->get('/test-selector')->assertRedirect('/find-my-test');
        $this->get('/test-recommender')->assertRedirect('/find-my-test');
        $this->get('/which-test')->assertRedirect('/find-my-test');
    }

    public function test_verified_reviews_page_loads_and_filters()
    {
        $response = $this->get('/reviews');
        $response->assertStatus(200);
        $response->assertSee('Verified Customer &amp; Employer Reviews', false);
        $response->assertSee('4.9');
        $response->assertSee('Pinnacle Logistics Corp');

        $dotFilter = $this->get('/reviews?category=dot');
        $dotFilter->assertStatus(200);
        $dotFilter->assertSee('Lone Star Freight LLC');

        $this->get('/testimonials')->assertRedirect('/reviews');
        $this->get('/customer-reviews')->assertRedirect('/reviews');
    }

    public function test_product_page_displays_test_finder_and_clean_meta_title()
    {
        $response = $this->get('/product/5-panel-nondot');
        $response->assertStatus(200);
        $response->assertSee('Launch Guided Test Finder', false);
        $response->assertSee('Certified Drug Test Centers', false);
        $response->assertDontSee('Accredited Drug Testing');
    }

    public function test_facility_profile_loads_successfully_with_gps_directions_and_hours()
    {
        $response = $this->get('/location/1');
        $response->assertStatus(200);
        $response->assertSee('Certified Collection Site');
        $response->assertSee('Google Maps');
        $response->assertSee('Apple Maps');
        $response->assertSee('Waze');
        $response->assertSee('Urine Drug Screening');
        $response->assertSee('Order Test &amp; Walk-In Here', false);
        $response->assertSee('"@type": "MedicalBusiness"', false);

        // Verify alias route /locations/site/1
        $aliasResponse = $this->get('/locations/site/1');
        $aliasResponse->assertStatus(200);
    }

    public function test_api_locations_search_returns_profile_and_directions_urls()
    {
        $response = $this->getJson('/api/locations/search?zip=32801');
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $data = $response->json();
        $this->assertNotEmpty($data['locations']);
        $first = $data['locations'][0];
        $this->assertArrayHasKey('profile_url', $first);
        $this->assertArrayHasKey('directions_url', $first);
        $this->assertArrayHasKey('checkout_url', $first);
        $this->assertStringContainsString('/location/', $first['profile_url']);
    }

    public function test_checkout_preselects_assigned_facility_when_location_id_provided()
    {
        $response = $this->get('/checkout?location_id=1');
        $response->assertStatus(200);
        $response->assertSee('Selected Testing Facility');
        $response->assertSee('name="location_id" value="1"', false);
    }

    public function test_admin_order_shows_and_updates_ccf_and_mro_tracking()
    {
        $admin = \App\Models\User::where('is_super_admin', true)->first();
        $order = \App\Models\Order::first();

        if ($admin && $order) {
            $response = $this->actingAs($admin)->get("/admin/orders/{$order->id}");
            $response->assertStatus(200);
            $response->assertSee('Laboratory Specimen Tracking &amp; MRO Review', false);
            $response->assertSee('Custody &amp; Control Form (CCF) #', false);

            $updateResponse = $this->actingAs($admin)->post("/admin/orders/{$order->id}/status", [
                'status' => 'completed',
                'payment_status' => 'paid',
                'result_outcome' => 'negative',
                'ccf_number' => 'CCF-994821',
                'mro_notes' => 'Donor specimen verified negative by MRO physician.',
                'notes' => 'Test admin status update.',
            ]);

            $updateResponse->assertRedirect("/admin/orders/{$order->id}");
            $this->assertDatabaseHas('orders', [
                'id' => $order->id,
                'status' => 'completed',
                'result_outcome' => 'negative',
                'ccf_number' => 'CCF-994821',
            ]);
        }
    }

    public function test_donor_mro_certificate_loads_with_panel_breakdown_and_signatures()
    {
        $order = \App\Models\Order::first();
        if ($order) {
            $response = $this->get("/orders/certificate/{$order->donor_pass_token}");
            $response->assertStatus(200);
            $response->assertSee('Certified Drug Test Centers');
            $response->assertSee('National Medical Review Office');
            $response->assertSee('10D0953841'); // CLIA number
            $response->assertSee('Substance / Drug Class Analyzed');
            $response->assertSee('Dr. Robert S. Vance, M.D.');
            $response->assertSee('AAMRO / MROCC');
            $response->assertSee('Print / Save Official PDF');
        }
    }

    public function test_admin_mro_certificate_access_control()
    {
        $order = \App\Models\Order::first();
        if ($order) {
            // Guest should be redirected to login
            $guestResponse = $this->get("/admin/orders/{$order->id}/certificate");
            $guestResponse->assertRedirect('/admin/login');

            // Authenticated Super Admin should see the certificate
            $admin = \App\Models\User::where('is_super_admin', true)->first();
            if ($admin) {
                $adminResponse = $this->actingAs($admin)->get("/admin/orders/{$order->id}/certificate");
                $adminResponse->assertStatus(200);
                $adminResponse->assertSee('Official MRO Laboratory Report');
                $adminResponse->assertSee($order->order_number);
            }
        }
    }

    public function test_employer_portal_login_page_loads_and_redirects_aliases(): void
    {
        $response = $this->get('/employers/portal');
        $response->assertStatus(200);
        $response->assertSee('Corporate Employer');
        $response->assertSee('Authorized Account Sign In');
        $response->assertSee('Instant 1-Click Demo Login');

        $this->get('/employer-portal')->assertRedirect('/employers/portal');
        $this->get('/portal')->assertRedirect('/employers/portal');
        $this->get('/corporate/portal')->assertRedirect('/employers/portal');
    }

    public function test_employer_portal_demo_login_authenticates_and_shows_dashboard(): void
    {
        $response = $this->post('/employers/portal/demo');
        $response->assertRedirect('/employers/portal');

        $dashboardResponse = $this->get('/employers/portal');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Apex Logistics &amp; Fleet Services Inc.', false);
        $dashboardResponse->assertSee('CDTC-CORP-DEMO');
        $dashboardResponse->assertSee('Active Candidate Testing Pipeline');
        $dashboardResponse->assertSee('Dispatch New Candidate Pass');
        $dashboardResponse->assertSee('Export Compliance CSV');
    }

    public function test_employer_portal_dispatches_new_candidate_pass(): void
    {
        // First ensure demo account is logged in
        $this->post('/employers/portal/demo');

        $product = \App\Models\Product::where('is_active', true)->first();
        $location = \App\Models\Location::where('is_active', true)->first();

        $dispatchData = [
            'first_name' => 'Harrison',
            'last_name' => 'Wells',
            'email' => 'hwells@apexlogistics-demo.com',
            'phone' => '(407) 555-9876',
            'candidate_department' => 'Heavy Fleet Logistics',
            'candidate_job_title' => 'Hazmat Transport Driver',
            'test_reason' => 'Pre-Employment',
            'product_id' => $product ? $product->id : 1,
            'location_id' => $location ? $location->id : 1,
            'notes' => 'Priority dispatch for new terminal hire',
        ];

        $response = $this->post('/employers/portal/dispatch', $dispatchData);
        $response->assertRedirect('/employers/portal');
        $response->assertSessionHas('portal_success');

        $this->assertDatabaseHas('orders', [
            'donor_first_name' => 'Harrison',
            'donor_last_name' => 'Wells',
            'donor_email' => 'hwells@apexlogistics-demo.com',
            'candidate_department' => 'Heavy Fleet Logistics',
            'status' => 'registered',
        ]);
    }

    public function test_employer_portal_compliance_csv_export(): void
    {
        $this->post('/employers/portal/demo');

        $response = $this->get('/employers/portal/export');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        
        $content = $response->streamedContent();
        $this->assertStringContainsString('Account Code', $content);
        $this->assertStringContainsString('CCF Accession #', $content);
        $this->assertStringContainsString('Apex Logistics', $content);
    }

    public function test_employer_portal_random_compliance_draw(): void
    {
        $this->post('/employers/portal/demo');

        $response = $this->post('/employers/portal/random-draw', ['draw_rate' => 25]);
        $response->assertRedirect('/employers/portal');
        $response->assertSessionHas('portal_notice');
    }

    public function test_security_headers_and_health_check_endpoint(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');

        $healthResponse = $this->get('/up');
        $healthResponse->assertStatus(200);
    }

    public function test_admin_login_page_renders_logo_and_forgot_password_link(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
        $response->assertSee('images/logo.png');
        $response->assertSee('Forgot password?');
        $response->assertSee(route('admin.password.request'));
    }

    public function test_admin_forgot_password_and_reset_workflow(): void
    {
        $admin = \App\Models\User::updateOrCreate(
            ['email' => 'test-forgot-pw@certifieddrugtesting.com'],
            [
                'name' => 'Test Reset Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'is_super_admin' => true,
            ]
        );

        // 1. Visit forgot password page
        $this->get(route('admin.password.request'))
            ->assertStatus(200)
            ->assertSee('Reset Administrator Password')
            ->assertSee('images/logo.png');

        // 2. Request reset link
        $postResponse = $this->post(route('admin.password.email'), [
            'email' => $admin->email,
        ]);
        $postResponse->assertSessionHas('status');

        $record = \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $admin->email)
            ->first();
        $this->assertNotNull($record);

        // 3. View reset form with token
        $this->get(route('admin.password.reset', ['token' => $record->token, 'email' => $admin->email]))
            ->assertStatus(200)
            ->assertSee('Set New Password');

        // 4. Update password
        $resetResponse = $this->post(route('admin.password.update'), [
            'token' => $record->token,
            'email' => $admin->email,
            'password' => 'NewSecurePassword!2026',
            'password_confirmation' => 'NewSecurePassword!2026',
        ]);
        $resetResponse->assertRedirect(route('admin.login'));
        $resetResponse->assertSessionHas('status');

        $admin->refresh();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('NewSecurePassword!2026', $admin->password));
    }

    public function test_admin_profile_and_password_update_flow(): void
    {
        $admin = \App\Models\User::updateOrCreate(
            ['email' => 'test-profile-pw@certifieddrugtesting.com'],
            [
                'name' => 'Test Super Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('currentpassword123'),
                'is_super_admin' => true,
            ]
        );

        // 1. Access profile page
        $profileResponse = $this->actingAs($admin)->get(route('admin.profile'));
        $profileResponse->assertStatus(200);
        $profileResponse->assertSee('Admin Profile & Security');
        $profileResponse->assertSee('Administrator Account Details');
        $profileResponse->assertSee('Change Account Password');

        // 2. Update profile information
        $updateResponse = $this->actingAs($admin)->put(route('admin.profile.update'), [
            'name' => 'Lead Super Admin',
            'email' => $admin->email,
            'phone' => '(800)-985-4339',
        ]);
        $updateResponse->assertRedirect(route('admin.profile'));
        $updateResponse->assertSessionHas('success');

        $admin->refresh();
        $this->assertEquals('Lead Super Admin', $admin->name);

        // 3. Update password with incorrect current password (fails)
        $failResponse = $this->actingAs($admin)->put(route('admin.profile.password'), [
            'current_password' => 'wrongpassword',
            'password' => 'UpdatedSecret999!',
            'password_confirmation' => 'UpdatedSecret999!',
        ]);
        $failResponse->assertSessionHasErrors(['current_password']);

        // 4. Update password with correct current password (succeeds)
        $passSuccess = $this->actingAs($admin)->put(route('admin.profile.password'), [
            'current_password' => 'currentpassword123',
            'password' => 'UpdatedSecret999!',
            'password_confirmation' => 'UpdatedSecret999!',
        ]);
        $passSuccess->assertRedirect(route('admin.profile'));
        $passSuccess->assertSessionHas('success');

        $admin->refresh();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('UpdatedSecret999!', $admin->password));
    }

    public function test_admin_products_renders_action_buttons_and_pagination(): void
    {
        $admin = \App\Models\User::where('is_super_admin', true)->first();
        if (!$admin) {
            $admin = \App\Models\User::create([
                'name' => 'Test Super Admin',
                'email' => 'superadmin2@test.com',
                'password' => \Illuminate\Support\Facades\Hash::make('secret'),
                'is_super_admin' => true,
            ]);
        }

        $response = $this->actingAs($admin)->get('/admin/products');
        $response->assertStatus(200);
        $response->assertSee('action-btn-group');
        $response->assertSee('action-btn-view');
        $response->assertSee('action-btn-edit');
        $response->assertSee('action-btn-delete');
        $response->assertSee('admin-pagination-nav');
        $response->assertSee('admin-pagination-list');
        $response->assertSee('page-link');
        $response->assertSee('sidebar-logo-card');
        $response->assertSee('sidebar-footer');
        $response->assertSee('sidebar-btn-logout');
    }
}



