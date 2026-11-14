<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeoMetaAndMobileLockinTest extends TestCase
{
    public function test_national_chain_page_has_exact_title_description_and_keywords(): void
    {
        $response = $this->get('/certified-drug-test-centers');
        $response->assertStatus(200);

        // Exact title with 800 number and no "walk-ins welcome"
        $response->assertSee('<title>Certified Drug Test Centers - (800) 985-4339</title>', false);
        $this->assertStringNotContainsString('Walk-ins Welcome', $response->getContent());

        // Exact meta description requested by client
        $response->assertSee('Certified Drug Test Centers are located in all cities and in most cases within minutes of your home or office.', false);
        $response->assertSee('Negative results are typically available within 24–48 hours.', false);

        // Exact keywords
        $response->assertSee('name="keywords" content="Drug Test near me, DOT Drug Test near me, Alcohol test near me, Drug Testing, Drug testing center near me, employer drug testing programs, 5 panel urine test, 5 panel drug test, 10 panel drug test, DOT consortium Enrollment, where can i get a drug test, Hair drug test"', false);

        // No Sanford address in footer
        $response->assertDontSee('201 N. Park Ave.');
        $response->assertDontSee('Sanford, FL 32771');
        $response->assertSee('National Scheduling Center');
        $response->assertSee('Toll-Free: (800) 985-4339');
    }

    public function test_state_page_has_exact_title_keywords_and_no_sanford_footer(): void
    {
        $response = $this->get('/locations/florida');
        $response->assertStatus(200);

        $response->assertSee('<title>Florida Drug Testing Centers - (800) 985-4339</title>', false);
        $this->assertStringNotContainsString('Walk-ins Welcome', $response->getContent());
        $response->assertSee('name="keywords" content="Drug Test near me, DOT Drug Test near me, Alcohol test near me, Drug Testing, Drug testing center near me, employer drug testing programs, 5 panel urine test, 5 panel drug test, 10 panel drug test, DOT consortium Enrollment, where can i get a drug test, Hair drug test"', false);

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

    public function test_city_page_has_exact_title_keywords_and_clean_h1(): void
    {
        $response = $this->get('/locations/florida/miami');
        $response->assertStatus(200);

        // Title has 800 number and no walk-ins welcome
        $response->assertSee('<title>Miami, FL Drug Testing Centers - (800) 985-4339</title>', false);
        $this->assertStringNotContainsString('Walk-ins Welcome', $response->getContent());

        // Keywords present in page source
        $response->assertSee('name="keywords" content="Drug Test near me, DOT Drug Test near me, Alcohol test near me, Drug Testing, Drug testing center near me, employer drug testing programs, 5 panel urine test, 5 panel drug test, 10 panel drug test, DOT consortium Enrollment, where can i get a drug test, Hair drug test"', false);

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
