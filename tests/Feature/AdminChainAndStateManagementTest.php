<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Setting;
use App\Models\State;
use App\Models\User;
use Tests\TestCase;

class AdminChainAndStateManagementTest extends TestCase
{
    protected function tearDown(): void
    {
        Setting::where('key', 'LIKE', 'chain_national_%')->delete();
        parent::tearDown();
    }

    protected function getAdminUser(): User
    {
        return User::first() ?? User::factory()->create([
            'email' => 'admin@certifieddrugtestingcenters.com',
            'is_admin' => true,
        ]);
    }

    public function test_guest_cannot_access_national_chain_admin(): void
    {
        $response = $this->get('/admin/chain/national');
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_view_national_chain_editor(): void
    {
        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->get('/admin/chain/national');
        $response->assertStatus(200);
        $response->assertSee('National Chain Content & SEO Manager');
        $response->assertSee('name="hero_title"', false);
        $response->assertSee('Quick Answer & Key Facts');
        $response->assertSee('Employer & On-Site Mobile Testing Section');
    }

    public function test_admin_can_update_national_chain_content_and_see_live(): void
    {
        $admin = $this->getAdminUser();

        $updatedTitle = 'Custom National Headline ' . uniqid();
        $updatedEyebrow = 'Official Testing Network 2026';
        $updatedLead = 'Custom test narrative for national chain testing locations.';
        $updatedDirectoryTitle = 'Find drug and alcohol testing centers by State';

        $payload = [
            'meta_title' => 'Updated National SEO Title',
            'meta_description' => 'Updated National Meta Description for testing.',
            'meta_keywords' => 'keyword1, keyword2',
            'hero_eyebrow' => $updatedEyebrow,
            'hero_title' => $updatedTitle,
            'hero_lead' => $updatedLead,
            'hero_checks' => [
                'First custom checkmark',
                'Second custom checkmark',
            ],
            'quick_answer_title' => 'Custom Quick Answer Title',
            'quick_answer_text' => 'Custom quick answer text goes here.',
            'fact_sites' => '25,000+',
            'fact_sites_label' => 'verified centers',
            'fact_states' => '50',
            'fact_states_label' => 'states covered',
            'fact_results' => '24-48 hrs',
            'fact_results_label' => 'typical turnaround',
            'fact_price' => '$89.99',
            'fact_price_label' => 'starting rate',
            'directory_eyebrow' => 'Directory Eyebrow',
            'directory_title' => $updatedDirectoryTitle,
            'directory_lead' => 'Custom state directory lead.',
            'onsite_eyebrow' => 'For Business',
            'onsite_title' => 'On-Site Testing Programs',
            'onsite_lead' => 'Custom onsite lead narrative.',
            'onsite_checks' => [
                'On-site mobile collections for employees at job sites, warehouses and offices',
            ],
            'faqs' => [
                [
                    'question' => 'Is this a custom test question?',
                    'answer' => 'Yes, this is an automated test answer.',
                ],
            ],
        ];

        $response = $this->actingAs($admin)->put('/admin/chain/national', $payload);
        $response->assertRedirect('/admin/chain/national');
        $response->assertSessionHas('success');

        // Check front-end reflection on /certified-drug-test-centers
        $liveResponse = $this->get('/certified-drug-test-centers');
        $liveResponse->assertStatus(200);
        $liveResponse->assertSee($updatedTitle);
        $liveResponse->assertSee($updatedEyebrow);
        $liveResponse->assertSee($updatedLead);
        $liveResponse->assertSee('25,000+');
        $liveResponse->assertSee('verified centers');
        $liveResponse->assertSee('First custom checkmark');
        $liveResponse->assertSee('Is this a custom test question?');
        $liveResponse->assertSee('Yes, this is an automated test answer.');
    }

    public function test_guest_cannot_access_states_admin(): void
    {
        $response = $this->get('/admin/states');
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_view_states_index_and_counts(): void
    {
        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->get('/admin/states');
        $response->assertStatus(200);
        $response->assertSee('State Landing Pages & Compliance Manager');
        $response->assertSee('Florida');
        $response->assertSee('FL');
    }

    public function test_admin_can_update_state_page_and_verify_live_render(): void
    {
        $admin = $this->getAdminUser();
        $state = State::where('slug', 'florida')->firstOrFail();

        $customStatute = 'Fla. Stat. § 440.102-TEST';
        $customRights = 'Florida employers retain the right to conduct mandatory drug testing under a verified drug-free workplace policy.';
        $customFaqQ = 'Can an employer in Florida terminate for a positive drug test?';
        $customFaqA = 'Yes, subject to Florida statute compliance and MRO verification.';

        $payload = [
            'name' => 'Florida',
            'abbr' => 'FL',
            'is_active' => '1',
            'meta_title' => 'Florida Drug Testing Centers - (800) 985-4339',
            'meta_description' => 'Certified Drug Test Centers in Florida (FL). Order online or call (800) 985-4339 for an instant donor pass at local Quest & Labcorp walk-in clinics.',
            'content' => '<p>Custom Florida state regulatory guide text.</p>',
            'statute_code' => $customStatute,
            'medical_marijuana_status' => 'Legalized Medical',
            'recreational_marijuana_status' => 'Prohibited',
            'employer_rights_summary' => $customRights,
            'worker_comp_rules' => 'Employers can receive up to a 5% discount on workers comp premiums.',
            'faqs' => [
                [
                    'question' => $customFaqQ,
                    'answer' => $customFaqA,
                ],
            ],
        ];

        $response = $this->actingAs($admin)->put("/admin/states/{$state->id}", $payload);
        $response->assertRedirect('/admin/states');
        $response->assertSessionHas('success');

        // Check front-end reflection on /locations/florida
        $liveResponse = $this->get('/locations/florida');
        $liveResponse->assertStatus(200);
        $liveResponse->assertSee($customStatute);
        $liveResponse->assertSee('Legalized Medical');
        $liveResponse->assertSee($customRights);
        $liveResponse->assertSee($customFaqQ);
        $liveResponse->assertSee($customFaqA);
    }

    public function test_admin_can_update_city_seo_guide(): void
    {
        $admin = $this->getAdminUser();
        $city = City::with('state')->firstOrFail();

        $customMetaTitle = "Drug Testing in {$city->name}, {$city->state->abbr} | Certified Centers";
        $payload = [
            'name' => $city->name,
            'meta_title' => $customMetaTitle,
            'meta_description' => "Local certified drug test centers in {$city->name}.",
            'content' => "<p>Complete guide to drug testing in {$city->name}.</p>",
            'is_active' => '1',
        ];

        $response = $this->actingAs($admin)->put("/admin/cities/{$city->id}", $payload);
        $response->assertRedirect('/admin/cities');
        $response->assertSessionHas('success');

        $city->refresh();
        $this->assertEquals($customMetaTitle, $city->meta_title);
    }
}
