<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\PseoEligibleCity;
use App\Models\State;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Tests\TestCase;

class CanonicalRedirectAndSitemapTest extends TestCase
{
    /**
     * Helper to make a raw request with a trailing slash intact
     * (bypassing Laravel Test Response prepareUrlForRequest trim).
     */
    protected function requestWithRawUri(string $uri, string $host = 'certifieddrugtestingcenters.com')
    {
        $symfonyRequest = SymfonyRequest::create(
            "https://{$host}{$uri}",
            'GET',
            [],
            [],
            [],
            [
                'HTTP_HOST' => $host,
                'REQUEST_URI' => $uri,
            ]
        );
        $request = Request::createFromBase($symfonyRequest);
        $response = app()->handle($request);
        return $this->createTestResponse($response, $request);
    }

    /**
     * Trailing slash URLs must 301 redirect to non-trailing slash canonical.
     */
    public function test_trailing_slash_urls_redirect_to_non_slash_canonical_301(): void
    {
        $response = $this->requestWithRawUri('/services/10-panel-drug-test/pennsylvania/philadelphia/');
        $response->assertStatus(301);
        $response->assertRedirect('https://certifieddrugtestingcenters.com/services/10-panel-drug-test/pennsylvania/philadelphia');

        $response2 = $this->requestWithRawUri('/locations/florida/');
        $response2->assertStatus(301);
        $response2->assertRedirect('https://certifieddrugtestingcenters.com/locations/florida');
    }

    /**
     * Requests coming from www. host must 301 redirect to non-www canonical.
     */
    public function test_www_host_redirects_to_non_www_canonical_301(): void
    {
        $response = $this->get('https://www.certifieddrugtestingcenters.com/services/10-panel-drug-test/pennsylvania/philadelphia');
        $response->assertStatus(301);
        $response->assertRedirect('https://certifieddrugtestingcenters.com/services/10-panel-drug-test/pennsylvania/philadelphia');
    }

    /**
     * Requests with both www. and trailing slash must redirect in a single 301 hop.
     */
    public function test_combined_www_and_trailing_slash_single_hop_301(): void
    {
        $response = $this->requestWithRawUri('/services/10-panel-drug-test/pennsylvania/philadelphia/', 'www.certifieddrugtestingcenters.com');
        $response->assertStatus(301);
        $response->assertRedirect('https://certifieddrugtestingcenters.com/services/10-panel-drug-test/pennsylvania/philadelphia');
    }

    /**
     * Legacy sitemap-chain*.xml and sitemap-index.xml must 301 redirect to /sitemap.xml.
     */
    public function test_legacy_sitemap_chain_and_sitemap_index_redirect_to_sitemap_xml(): void
    {
        $responseChain = $this->get('/sitemap-chain1.xml');
        $responseChain->assertStatus(301);
        $responseChain->assertRedirect('/sitemap.xml');

        $responseChain9 = $this->get('/sitemap-chain9.xml');
        $responseChain9->assertStatus(301);
        $responseChain9->assertRedirect('/sitemap.xml');

        $responseIndex = $this->get('/sitemap-index.xml');
        $responseIndex->assertStatus(301);
        $responseIndex->assertRedirect('/sitemap.xml');
    }

    /**
     * Main XML sitemaps must NOT expose /services/ programmatic matrix URLs.
     */
    public function test_sitemaps_exclude_programmatic_service_matrix_urls(): void
    {
        $sitemaps = [
            '/sitemap.xml',
            '/sitemap-core.xml',
            '/sitemap-products.xml',
            '/sitemap-locations.xml',
        ];

        foreach ($sitemaps as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);
            $this->assertStringNotContainsString('/services/', $response->getContent(), "Sitemap {$url} must not include /services/ programmatic URLs.");
        }
    }

    /**
     * City service page has clinical cutoff protocols, specimen requirements, and no 'Walk-ins Welcome'.
     */
    public function test_city_service_page_contains_clinical_testing_protocols_and_cutoffs(): void
    {
        $state = State::where('slug', 'florida')->first();
        if (!$state) {
            $this->markTestSkipped('Florida state not seeded');
        }

        $city = City::where('state_id', $state->id)
            ->whereIn('id', PseoEligibleCity::where('is_eligible', true)->pluck('city_id'))
            ->first();

        if (!$city) {
            $this->markTestSkipped('Eligible Florida city not found');
        }

        $response = $this->get("/services/5-panel-drug-test/{$state->slug}/{$city->slug}");
        $response->assertStatus(200);

        $content = $response->getContent();

        // Clinical protocol card presence
        $this->assertStringContainsString('Clinical Testing Protocols &amp; Regulatory Cut-Off Levels', $content);
        $this->assertStringContainsString('Marijuana (THC metabolites)', $content);
        $this->assertStringContainsString('Screen: 50 ng/mL', $content);
        $this->assertStringContainsString('Confirmation (GC/MS): 15 ng/mL', $content);
        $this->assertStringContainsString('(800) 985-4339', $content);

        // Ensure "Walk-ins Welcome" was eradicated from page title
        $this->assertStringNotContainsString('Walk-ins Welcome', $content);
    }

    /**
     * Service state template does not output trailing slashes in city links.
     */
    public function test_service_templates_do_not_output_trailing_slashes_in_links(): void
    {
        $state = State::where('slug', 'pennsylvania')->first() ?? State::first();
        if (!$state) {
            $this->markTestSkipped('No states seeded');
        }

        $response = $this->get("/services/10-panel-drug-test/{$state->slug}");
        $response->assertStatus(200);

        $content = $response->getContent();

        // Ensure internal links to city pages do NOT end with trailing slashes
        $this->assertMatchesRegularExpression('#href="https?://[^"]*/services/[a-z0-9-]+/[a-z0-9-]+/[a-z0-9-]+(?<!/)"#', $content);
        $this->assertDoesNotMatchRegularExpression('#href="https?://[^"]*/services/[a-z0-9-]+/[a-z0-9-]+/[a-z0-9-]+/"#', $content);
    }

    /**
     * Verify all 4 XML sitemaps return direct HTTP 200 OK (no redirect) with correct XML content-type.
     */
    public function test_xml_sitemaps_return_direct_200_ok_with_correct_xml_content_type(): void
    {
        $sitemaps = [
            '/sitemap.xml',
            '/sitemap-core.xml',
            '/sitemap-products.xml',
            '/sitemap-locations.xml',
        ];

        foreach ($sitemaps as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);
            $contentType = $response->headers->get('Content-Type');
            $this->assertTrue(
                str_starts_with($contentType, 'application/xml') || str_starts_with($contentType, 'text/xml'),
                "Sitemap {$url} must return XML content type, got: {$contentType}"
            );
        }
    }

    /**
     * Verify /services/5-panel-drug-test/oregon/bend editorial copy dynamically injects Bend, OR and eliminates Manchester, CT.
     */
    public function test_city_service_template_does_not_contain_manchester_ct_on_bend_or(): void
    {
        $city = City::where('slug', 'bend')->first();
        if ($city) {
            // Seed a pseo_city_contents row with foreign city "Manchester, CT" to simulate legacy production state
            \App\Models\PseoCityContent::updateOrCreate(
                ['city_id' => $city->id],
                [
                    'gpt_5panel' => '<p>A 5-panel drug test in Manchester, CT is popular for workplaces. In Manchester, CT, these categories include substances.</p>',
                ]
            );
        }

        $response = $this->get('/services/5-panel-drug-test/oregon/bend');
        $response->assertStatus(200);

        $content = $response->getContent();

        // Must output active matching city and state
        $this->assertStringContainsString('Local Drug Testing Overview for Bend, OR', $content);
        $this->assertStringContainsString('Bend, OR', $content);

        // Must NEVER contain hardcoded foreign city
        $this->assertStringNotContainsString('Manchester, CT', $content);
        $this->assertStringContainsString('A 5-panel drug test in Bend, OR is popular for workplaces.', $content);
    }

    /**
     * Verify duplicate JSON-LD script blocks are removed from the bottom of <main> on city and state templates.
     */
    public function test_city_service_template_removes_duplicate_jsonld_blocks_at_bottom_of_main(): void
    {
        $response = $this->get('/services/5-panel-drug-test/oregon/bend');
        $response->assertStatus(200);

        $content = $response->getContent();

        // Exactly 1 JSON-LD block in <head> (@graph) and zero standalone script blocks inside <body>
        $jsonLdCount = substr_count($content, '<script type="application/ld+json">');
        $this->assertSame(1, $jsonLdCount, "There must be exactly 1 unified @graph JSON-LD block on the page, found: {$jsonLdCount}");
    }

    /**
     * Verify FAQ #1 grammar in Oregon and singular/plural count on hero badge & directory pill.
     */
    public function test_faq_grammar_and_singular_plural_center_counts(): void
    {
        // 1. Oregon FAQ #1 grammar in JSON-LD and state view
        $orResponse = $this->get('/locations/oregon');
        $orResponse->assertStatus(200);
        $orContent = $orResponse->getContent();
        $this->assertStringContainsString('operate under the Oregon Revised Statutes', $orContent);
        $this->assertStringNotContainsString('operate under a Oregon', $orContent);

        // 2. City service template count pluralization
        $cityResponse = $this->get('/services/5-panel-drug-test/oregon/bend');
        $cityResponse->assertStatus(200);
        $cityContent = $cityResponse->getContent();

        // Hero badge and directory pill plural checks
        $this->assertMatchesRegularExpression('/\d+\s+Collection Centers?\s+in Radius/', $cityContent);
        $this->assertMatchesRegularExpression('/\d+\s+Centers?\s+Available/', $cityContent);
        // Ensure no "1 Collection Centers" or "1 Centers Available" exists
        $this->assertDoesNotMatchRegularExpression('/(?<!\d)1\s+Collection Centers\s+in Radius/', $cityContent);
        $this->assertDoesNotMatchRegularExpression('/(?<!\d)1\s+Centers Available/', $cityContent);
    }
}

