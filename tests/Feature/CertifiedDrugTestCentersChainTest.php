<?php

namespace Tests\Feature;

use App\Models\State;
use Tests\TestCase;

class CertifiedDrugTestCentersChainTest extends TestCase
{
    public function test_national_chain_page_loads_with_200(): void
    {
        $response = $this->get('/certified-drug-test-centers');
        $response->assertStatus(200);
        $response->assertSee('Certified Drug Test Centers Near You');
        $response->assertSee('Find a drug testing center near you');
        $response->assertSee('Quick answer: how to get a drug or alcohol test near you today');
        $response->assertSee('How to schedule a drug test in 4 easy steps');
        $response->assertSee('How much does a drug test cost?');
        $response->assertSee('Which drug test do I need?');
        $response->assertSee("What's the difference between a 5, 10 and 12 panel drug test?", false);
        $response->assertSee('How long do drugs stay in your system?');
        $response->assertSee('DOT drug and alcohol testing nationwide');
        $response->assertSee('Employer drug testing programs & on-site mobile testing');
        $response->assertSee('Find drug testing centers by state');
        $response->assertSee('Accredited labs, certified collectors, verified results');
        $response->assertSee('Drug testing terms explained');
        $response->assertSee('Drug testing frequently asked questions');
        $response->assertSee('References & regulatory sources');
        $response->assertSee('Get tested today at a certified center near you');
    }

    public function test_sample_alias_redirects_to_canonical_chain_slug(): void
    {
        $response = $this->get('/certified-drug-test-centers-sample');
        $response->assertRedirect('/certified-drug-test-centers');
    }

    public function test_services_prefix_redirects_to_canonical_chain_slug(): void
    {
        $response = $this->get('/services/certified-drug-test-centers');
        $response->assertRedirect('/certified-drug-test-centers');
    }

    public function test_state_route_for_chain_loads_with_200(): void
    {
        $response = $this->get('/certified-drug-test-centers/california');
        $response->assertStatus(200);
        $response->assertSee('California');
    }

    public function test_city_route_for_chain_loads_with_200(): void
    {
        $response = $this->get('/certified-drug-test-centers/florida/orlando');
        $response->assertStatus(200);
        $response->assertSee('Orlando');
    }

    public function test_chain_city_slug_alias_resolves_with_200(): void
    {
        $response = $this->get('/certified-drug-test-centers-orlando-fl');
        $response->assertStatus(200);
        $response->assertSee('Orlando');
    }

    public function test_zip_search_from_finder_redirects_to_target_location(): void
    {
        $response = $this->get('/locations?zip=32771');
        $response->assertStatus(302);
        $this->assertStringContainsString('/locations/florida/', $response->headers->get('Location'));
    }
}
