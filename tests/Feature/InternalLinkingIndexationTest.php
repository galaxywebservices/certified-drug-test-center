<?php

namespace Tests\Feature;

use App\Models\State;
use App\Models\City;
use Tests\TestCase;

class InternalLinkingIndexationTest extends TestCase
{
    public function test_homepage_contains_50_state_directory_and_footer_links(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Verify body state directory
        $response->assertSee('/locations/california', false);
        $response->assertSee('/locations/florida', false);
        $response->assertSee('/locations/texas', false);

        // Verify footer 50-state directory block
        $response->assertSee('Find A Drug Testing Center By State (All 50 States)');
        $response->assertSee('California Drug Testing');
        $response->assertSee('Florida Drug Testing');
        $response->assertSee('Texas Drug Testing');

        // Verify top navigation locations dropdown
        $response->assertSee('★ Certified Drug Test Centers (All 50 States)');
    }

    public function test_state_hub_page_has_breadcrumb_schema_and_standardized_city_anchor_text(): void
    {
        $response = $this->get('/locations/florida');
        $response->assertStatus(200);

        // Visual breadcrumb trail
        $response->assertSee('Home');
        $response->assertSee('Locations');
        $response->assertSee('Florida');

        // BreadcrumbList JSON-LD Schema
        $response->assertSee('"@type": "BreadcrumbList"', false);
        $response->assertSee('Florida Drug Testing', false);

        // Cities directory with standardized anchor text
        $response->assertSee('Orlando Drug Testing');
        $response->assertSee('/locations/florida/orlando', false);
    }

    public function test_city_page_has_breadcrumb_schema_and_automated_sibling_links(): void
    {
        $response = $this->get('/locations/florida/orlando');
        $response->assertStatus(200);

        // Visual breadcrumbs
        $response->assertSee('Home');
        $response->assertSee('Locations');
        $response->assertSee('Florida');
        $response->assertSee('Orlando');

        // BreadcrumbList JSON-LD Schema
        $response->assertSee('"@type": "BreadcrumbList"', false);
        $response->assertSee('Orlando Drug Testing', false);

        // Automated Sibling Links block
        $response->assertSee('Nearby Drug Testing Centers in Florida');
        $response->assertSee('Explore same-day certified drug and alcohol testing collection facilities in neighboring Florida communities');
        $response->assertSee('Drug Testing</span>', false);
    }

    public function test_chain_state_and_city_pages_use_chain_breadcrumbs_and_sibling_links(): void
    {
        // Chain State Page
        $stateResponse = $this->get('/certified-drug-test-centers/florida');
        $stateResponse->assertStatus(200);
        $stateResponse->assertSee('Certified Drug Test Centers');
        $stateResponse->assertSee('/certified-drug-test-centers/florida/orlando', false);
        $stateResponse->assertSee('"@type": "BreadcrumbList"', false);

        // Chain City Page
        $cityResponse = $this->get('/certified-drug-test-centers/florida/orlando');
        $cityResponse->assertStatus(200);
        $cityResponse->assertSee('Certified Drug Test Centers');
        $cityResponse->assertSee('Nearby Drug Testing Centers in Florida');
        $cityResponse->assertSee('/certified-drug-test-centers/florida/', false);
        $cityResponse->assertSee('"@type": "BreadcrumbList"', false);
    }
}

