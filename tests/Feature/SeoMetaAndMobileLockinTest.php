<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeoMetaAndMobileLockinTest extends TestCase
{
    public function test_national_chain_page_has_exact_title_description_and_clean_head(): void
    {
        $response = $this->get('/certified-drug-test-centers');
        $response->assertStatus(200);

        // Exact title with 800 number and no "walk-ins welcome"
        $response->assertSee('<title>Certified Drug Test Centers - (800) 985-4339</title>', false);
        $this->assertStringNotContainsString('Walk-ins Welcome', $response->getContent());

        // Exact meta description requested by client
        $response->assertSee('Certified Drug Test Centers are located in all cities and in most cases within minutes of your home or office.', false);
        $response->assertSee('Negative results are typically available within 24–48 hours.', false);

        // Viewport is clean without maximum-scale=5.0
        $response->assertSee('<meta name="viewport" content="width=device-width, initial-scale=1.0">', false);
        $this->assertStringNotContainsString('maximum-scale=5.0', $response->getContent());

        // Deprecated meta keywords removed
        $this->assertStringNotContainsString('name="keywords"', $response->getContent());

        // No Sanford address in footer
        $response->assertDontSee('201 N. Park Ave.');
        $response->assertDontSee('Sanford, FL 32771');
        $response->assertSee('National Scheduling Center');
        $response->assertSee('Toll-Free: (800) 985-4339');
    }

    public function test_state_page_has_exact_title_trimmed_description_and_no_sanford_footer(): void
    {
        $response = $this->get('/locations/florida');
        $response->assertStatus(200);

        $response->assertSee('<title>Florida Drug Testing Centers - (800) 985-4339</title>', false);
        $this->assertStringNotContainsString('Walk-ins Welcome', $response->getContent());

        // Trimmed meta description ~150 chars
        $response->assertSee('name="description" content="Certified Drug Test Centers in Florida (FL). Order online or call (800) 985-4339 for an instant donor pass at local Quest &amp; Labcorp walk-in clinics."', false);

        // Deprecated meta keywords removed
        $this->assertStringNotContainsString('name="keywords"', $response->getContent());

        $response->assertDontSee('201 N. Park Ave.');
        $response->assertDontSee('Sanford, FL 32771');
    }

    public function test_state_page_faqs_grammar_sidebar_price_and_single_jsonld_block(): void
    {
        $response = $this->get('/locations/arizona');
        $response->assertStatus(200);

        $content = $response->getContent();

        // Exactly one consolidated JSON-LD script block in <head>
        $this->assertSame(1, substr_count($content, 'type="application/ld+json"'));
        $this->assertStringContainsString('"@type": "FAQPage"', $content);
        $this->assertStringContainsString('"@type": "BreadcrumbList"', $content);
        $this->assertStringContainsString('"@type": "ItemList"', $content);

        // Grammar & punctuation fixes in Arizona state FAQs
        $this->assertStringNotContainsString('et seq..', $content);
        $this->assertStringNotContainsString('statutes protects', $content);
        $this->assertStringContainsString('statutes protect', $content);
        $this->assertStringContainsString('Certified Drug Test Centers provide access to', $content);

        // Sidebar 5 Panel Hair Follicle test price aligned to $169.99
        $response->assertSee('5 Panel Hair Follicle Test');
        $response->assertSee('$169.99');
        $this->assertStringNotContainsString('$189.99', $content);

        // Filter out county names from major cities
        $this->assertStringNotContainsString('Coconino Drug Testing', $content);
        $this->assertStringNotContainsString('North Pinal Drug Testing', $content);

        // Breadcrumb position 2 links to /certified-drug-test-centers
        $this->assertStringContainsString('/certified-drug-test-centers', $content);
    }

    public function test_city_page_has_exact_title_trimmed_description_and_clean_h1(): void
    {
        $response = $this->get('/locations/florida/miami');
        $response->assertStatus(200);

        // Title has 800 number and no walk-ins welcome
        $response->assertSee('<title>Miami, FL Drug Testing Centers - (800) 985-4339</title>', false);
        $this->assertStringNotContainsString('Walk-ins Welcome', $response->getContent());

        // Trimmed meta description ~150 chars
        $response->assertSee('name="description" content="Certified Drug Test Centers in Miami, FL. Order online or call (800) 985-4339 for an instant donor pass at local Quest &amp; Labcorp walk-in clinics."', false);

        // Deprecated meta keywords removed
        $this->assertStringNotContainsString('name="keywords"', $response->getContent());

        // H1 header has clean title without & Walk-In Labs
        $response->assertSee('Miami, FL Drug Testing Centers');
        $response->assertDontSee('Miami, FL Drug Testing Centers &amp; Walk-In Labs', false);

        // Footer has no Sanford address
        $response->assertDontSee('201 N. Park Ave.');
        $response->assertDontSee('Sanford, FL 32771');

        // Mobile lock-in CSS present
        $response->assertSee('overflow-x: clip !important;', false);
    }

    public function test_city_page_phoenix_has_clean_hours_geo_no_dead_links_and_sidebar_price(): void
    {
        $response = $this->get('/locations/arizona/phoenix');
        $response->assertStatus(200);

        $content = $response->getContent();

        // Exactly one consolidated JSON-LD script block in <head>
        $this->assertSame(1, substr_count($content, 'type="application/ld+json"'));
        $this->assertStringContainsString('"@type": "GeoCoordinates"', $content);
        $this->assertStringContainsString('"latitude":', $content);
        $this->assertStringContainsString('"longitude":', $content);

        // Clean up raw pipe characters in visible operating hours
        $this->assertStringNotContainsString('pm|Sa', $content);
        $this->assertStringContainsString('• Sa', $content);

        // No leading asterisk in product names
        $this->assertStringNotContainsString('*10 Panel Rapid Results', $content);
        $this->assertStringContainsString('10 Panel Rapid Results', $content);

        // Sidebar 5 Panel Hair Follicle price aligned to $169.99
        $response->assertSee('$169.99');
        $this->assertStringNotContainsString('$189.99', $content);

        // No broken "#" placeholder link in employer section
        $this->assertStringNotContainsString('href="#"', $content);
        $this->assertStringContainsString('href="/employers"', $content);

        // Brand pluralization
        $this->assertStringContainsString('Certified Drug Test Centers', $content);
        $this->assertStringNotContainsString('Certified Drug Test Centerss', $content);

        // Dynamic local clinic metrics present
        $this->assertStringContainsString('Collection Sites', $content);
        $this->assertStringContainsString('Earliest Opening', $content);
        $this->assertStringContainsString('Covered ZIP Codes', $content);

        // Sibling cities sorted by distance (Scottsdale, Glendale, Tempe, etc.) and no counties
        $this->assertStringContainsString('Scottsdale Drug Testing', $content);
        $this->assertStringNotContainsString('Coconino Drug Testing', $content);
        $this->assertStringNotContainsString('North Pinal Drug Testing', $content);
    }

    public function test_alaska_state_and_city_pages_comprehensive_seo_audit(): void
    {
        // 1. Test Alaska State Page (/locations/alaska)
        $response = $this->get('/locations/alaska');
        $response->assertStatus(200);

        $content = $response->getContent();

        // Single consolidated JSON-LD script block
        $this->assertSame(1, substr_count($content, 'type="application/ld+json"'));

        // Viewport and meta cleanup
        $response->assertSee('<meta name="viewport" content="width=device-width, initial-scale=1.0">', false);
        $this->assertStringNotContainsString('maximum-scale=5.0', $content);
        $this->assertStringNotContainsString('name="keywords"', $content);

        // Trimmed meta description (~147 chars)
        $response->assertSee('name="description" content="Certified Drug Test Centers in Alaska (AK). Order online or call (800) 985-4339 for an instant donor pass at local Quest &amp; Labcorp walk-in clinics."', false);

        // Grammar bugs fixed in FAQs
        $this->assertStringNotContainsString('a employer rights under', $content);
        $this->assertStringContainsString('employer rights under AS 23.10.600', $content);
        $this->assertStringNotContainsString('statutes allows', $content);
        $this->assertStringContainsString('statutes allow', $content);

        // openingHours omitted from JSON-LD ItemList schema to avoid contradicting visible hours
        $this->assertStringNotContainsString('"openingHours"', $content);

        // Lat/lng rounded to 6 decimal places (no 50-digit float artifacts)
        $this->assertMatchesRegularExpression('/"latitude":\s*61\.\d{1,6}/', $content);
        $this->assertMatchesRegularExpression('/"longitude":\s*-149\.\d{1,6}/', $content);
        $this->assertDoesNotMatchRegularExpression('/\d+\.\d{10,}/', $content);

        // Major Cities in Alaska grid contains Anchorage, Fairbanks, Wasilla, Juneau
        $this->assertStringContainsString('/locations/alaska/anchorage', $content);
        $this->assertStringContainsString('/locations/alaska/fairbanks', $content);
        $this->assertStringContainsString('/locations/alaska/wasilla', $content);
        $this->assertStringContainsString('/locations/alaska/juneau', $content);

        // Breadcrumb position 2 links to /certified-drug-test-centers
        $this->assertStringContainsString('/certified-drug-test-centers', $content);

        // 2. Test City Leaf Page (/locations/alaska/fairbanks) Parity
        $cityResponse = $this->get('/locations/alaska/fairbanks');
        $cityResponse->assertStatus(200);

        $cityContent = $cityResponse->getContent();

        // Exactly one consolidated JSON-LD graph
        $this->assertSame(1, substr_count($cityContent, 'type="application/ld+json"'));

        // Title has 800 number and clean branding
        $cityResponse->assertSee('<title>Fairbanks, AK Drug Testing Centers - (800) 985-4339</title>', false);
        $this->assertStringNotContainsString('Walk-ins Welcome', $cityContent);

        // Trimmed meta description ~150 chars
        $cityResponse->assertSee('name="description" content="Certified Drug Test Centers in Fairbanks, AK. Order online or call (800) 985-4339 for an instant donor pass at local Quest &amp; Labcorp walk-in clinics."', false);

        // Hair follicle price aligned to $169.99
        $cityResponse->assertSee('$169.99');
        $this->assertStringNotContainsString('$189.99', $cityContent);

        // Breadcrumb position 2 links to /certified-drug-test-centers
        $this->assertStringContainsString('/certified-drug-test-centers', $cityContent);

        // Local facilities in Fairbanks listed
        $this->assertStringContainsString('Quest Diagnostics', $cityContent);
    }

    public function test_alabama_state_and_madison_city_template_polish_audit(): void
    {
        // 1. Test Alabama State Hub (/locations/alabama)
        $stateResponse = $this->get('/locations/alabama');
        $stateResponse->assertStatus(200);

        $stateContent = $stateResponse->getContent();

        // FAQ #3 grammar: state statute does (not statutes does)
        $this->assertStringNotContainsString('statutes does', $stateContent);
        $this->assertStringContainsString('state statute does not require', $stateContent);

        // Raw hours formatting: no "Sat:,Su" artifact, correctly rendered as "Sat, Su"
        $this->assertStringNotContainsString('Sat:,Su', $stateContent);
        $this->assertStringContainsString('Sat, Su', $stateContent);

        // State page has visible FAQ accordion, so FAQPage is present in schema
        $this->assertStringContainsString('"@type": "FAQPage"', $stateContent);

        // 2. Test Madison City Leaf Template (/locations/alabama/madison)
        $cityResponse = $this->get('/locations/alabama/madison');
        $cityResponse->assertStatus(200);

        $cityContent = $cityResponse->getContent();

        // No invisible FAQPage schema on city page (Google rich-result spam prevention)
        $this->assertStringNotContainsString('"@type": "FAQPage"', $cityContent);

        // Metrics bar singular pluralization: "1 Collection Site" (not "1 Collection Sites")
        $this->assertStringContainsString('1 Collection Site', $cityContent);
        $this->assertStringNotContainsString('1 Collection Sites', $cityContent);

        // Employer call to action has canonical anchor link and no unlinked "Click Here"
        $this->assertStringContainsString('Open your employer drug testing account today', $cityContent);
        $this->assertStringContainsString('href="' . url('/employers') . '"', $cityContent);
        $this->assertStringNotContainsString('Click Here to establish', $cityContent);
        $this->assertStringNotContainsString('Click Here to set up', $cityContent);

        // Schema GeoCoordinates clean output without floating-point artifacts
        $this->assertDoesNotMatchRegularExpression('/\d+\.\d{10,}/', $cityContent);
    }

    public function test_individual_facility_page_is_noindex_follow(): void
    {
        $facility = \App\Models\Location::where('is_active', true)->firstOrFail();
        $response = $this->get("/location/{$facility->id}");
        $response->assertStatus(200);
        $response->assertSee('content="noindex, follow"', false);
    }

    public function test_checkout_has_mobile_lockin_styles_and_noindex(): void
    {
        $response = $this->get('/checkout');
        $response->assertStatus(200);

        // Disallowed / noindex for checkout
        $response->assertSee('content="noindex, follow"', false);

        // Mobile lock-in select styling
        $response->assertSee('.checkout-select {', false);
        $response->assertSee('text-overflow: ellipsis;', false);
        $response->assertSee('.selected-product-box {', false);
    }
}
