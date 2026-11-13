<?php

namespace Tests\Feature;

use Tests\TestCase;

class SitemapArchitectureTest extends TestCase
{
    /**
     * Issue 1 & 6: /sitemap.xml is a sitemapindex pointing to core, products, and locations.
     */
    public function test_sitemap_index_structure_and_links(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $this->assertFalse($response->headers->has('X-Robots-Tag'), 'Sitemaps must NOT have X-Robots-Tag header');

        $content = $response->getContent();
        $this->assertStringContainsString('<sitemapindex', $content);
        $this->assertStringContainsString('/sitemap-core.xml', $content);
        $this->assertStringContainsString('/sitemap-products.xml', $content);
        $this->assertStringContainsString('/sitemap-locations.xml', $content);
    }

    /**
     * Issue 1: Flagship hub /certified-drug-test-centers is in sitemap-core.xml and /locations 301-redirects to it.
     */
    public function test_core_sitemap_includes_flagship_hub_and_locations_redirects(): void
    {
        $response = $this->get('/sitemap-core.xml');
        $response->assertStatus(200);

        $content = $response->getContent();
        $this->assertStringContainsString('/certified-drug-test-centers', $content);
        $this->assertStringContainsString('/employers', $content);
        $this->assertStringContainsString('/find-my-test', $content);
        $this->assertStringContainsString('/reviews', $content);
        $this->assertStringContainsString('/contact-us', $content);

        // /locations directory root should 301 redirect to flagship hub
        $locResponse = $this->get('/locations');
        $locResponse->assertStatus(301);
        $locResponse->assertRedirect('/certified-drug-test-centers');
    }

    /**
     * Issue 2: Duplicate state pages /{state}-drug-testing 301-redirect to /locations/{state}.
     */
    public function test_duplicate_state_pages_redirect_and_excluded_from_sitemaps(): void
    {
        $response = $this->get('/florida-drug-testing');
        $response->assertStatus(301);
        $response->assertRedirect('/locations/florida');

        $locSitemap = $this->get('/sitemap-locations.xml');
        $locSitemap->assertStatus(200);
        $locContent = $locSitemap->getContent();

        $this->assertStringContainsString('/locations/florida', $locContent);
        $this->assertStringNotContainsString('florida-drug-testing', $locContent);
    }

    /**
     * Issue 3: Duplicate and legacy product and category slugs are 301-redirected and excluded from sitemap.
     */
    public function test_product_and_category_duplicates_redirect_and_clean_sitemaps(): void
    {
        // Category redirects
        $this->get('/category/labblood-testing')->assertStatus(301)->assertRedirect('/category/lab-blood');

        // Product redirects
        $this->get('/product/legal-dna-paternity')->assertStatus(301)->assertRedirect('/product/legal-dna');
        $this->get('/product/5-panel-oral-fluid-2')->assertStatus(301)->assertRedirect('/product/5-panel-oral-fluid');
        $this->get('/product/respirator-fit')->assertStatus(301)->assertRedirect('/product/respirator-fit-test');
        $this->get('/product/1-year-consortium-membership-dot-drug-test')->assertStatus(301)->assertRedirect('/product/1-year-enrollment');
        $this->get('/product/background-check-49')->assertStatus(301)->assertRedirect('/product/entry-level-background-check');
        $this->get('/product/background-check-standard')->assertStatus(301)->assertRedirect('/product/premium-level-background-check');
        $this->get('/product/background-checkbasic-drug-test')->assertStatus(301)->assertRedirect('/product/background-check-basic-drug-test');
        $this->get('/product/name-of-test-herpes-hsv-types-1-2-blood')->assertStatus(301)->assertRedirect('/find-my-test');
        $this->get('/product/name-of-test-hiv-agab-with-reflex')->assertStatus(301)->assertRedirect('/find-my-test');

        // Products sitemap checks
        $prodSitemap = $this->get('/sitemap-products.xml');
        $prodSitemap->assertStatus(200);
        $prodContent = $prodSitemap->getContent();

        $this->assertStringContainsString('/product/legal-dna', $prodContent);
        $this->assertStringNotContainsString('legal-dna-paternity', $prodContent);
        $this->assertStringNotContainsString('name-of-test', $prodContent);
        $this->assertStringNotContainsString('5-panel-oral-fluid-2', $prodContent);
        $this->assertStringContainsString('/product/respirator-fit-test', $prodContent);
        $this->assertStringNotContainsString('/product/respirator-fit<', $prodContent);
    }

    /**
     * Issue 4: /checkout and /track-order excluded from sitemaps and carry noindex, follow.
     */
    public function test_checkout_and_track_order_excluded_and_noindexed(): void
    {
        $coreSitemap = $this->get('/sitemap-core.xml');
        $coreContent = $coreSitemap->getContent();
        $this->assertStringNotContainsString('/checkout', $coreContent);
        $this->assertStringNotContainsString('/track-order', $coreContent);

        $checkoutResponse = $this->get('/checkout');
        $checkoutResponse->assertStatus(200);
        $this->assertStringContainsString('<meta name="robots" content="noindex, follow">', $checkoutResponse->getContent());

        $trackResponse = $this->get('/track-order');
        $trackResponse->assertStatus(200);
        $this->assertStringContainsString('<meta name="robots" content="noindex, follow">', $trackResponse->getContent());
    }

    /**
     * Issue 5: Flat root city URLs 301-redirect to hierarchical /locations/{state}/{city}.
     */
    public function test_flat_root_city_urls_redirect_to_hierarchical_locations(): void
    {
        $response = $this->get('/drug-testing-new-york-ny');
        $response->assertStatus(301);
        $response->assertRedirect('/locations/new-york/new-york');

        $locSitemap = $this->get('/sitemap-locations.xml');
        $locContent = $locSitemap->getContent();
        $this->assertStringNotContainsString('/drug-testing-', $locContent);
        $this->assertStringContainsString('/locations/new-york/new-york', $locContent);
    }

    /**
     * Verify clean robots.txt directives and canonical sitemap.
     */
    public function test_robots_txt_content_and_clean_sitemap_directive(): void
    {
        $response = $this->get('/robots.txt');
        $response->assertStatus(200);

        $content = $response->getContent();
        $this->assertStringNotContainsString('127.0.0.1', $content);
        $this->assertStringNotContainsString('8001', $content);
        $this->assertStringContainsString('Sitemap: https://certifieddrugtestingcenters.com/sitemap.xml', $content);
        $this->assertStringContainsString('Disallow: /checkout', $content);
        $this->assertStringContainsString('Disallow: /track-order', $content);
        $this->assertStringContainsString('Disallow: /*?zip=', $content);
    }
}

