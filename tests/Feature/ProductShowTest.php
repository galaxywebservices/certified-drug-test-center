<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;

class ProductShowTest extends TestCase
{
    public function test_product_page_renders_html_details_without_escaping(): void
    {
        $response = $this->get('/product/10-panel');
        $response->assertStatus(200);

        // Should not see escaped HTML entities for p or ul tags in body
        $response->assertDontSee('&lt;p style=', false);
        $response->assertDontSee('&lt;ul style=', false);
        $response->assertDontSee('&lt;li', false);

        // Should see unescaped HTML structure
        $response->assertSee('<h2 class="prod-section-title">Detailed Scientific Description</h2>', false);
        $response->assertSee('<li style="box-sizing: inherit;">Amphetamines</li>', false);
    }

    public function test_product_card_badge_does_not_show_literal_b_tags(): void
    {
        $response = $this->get('/product/10-panel');
        $response->assertStatus(200);

        // Should not see literal <b> or &lt;b&gt; tags
        $response->assertDontSee('&lt;b&gt;Online Discount Applied&lt;/b&gt;', false);
        $response->assertDontSee('<b>Online Discount Applied</b>', false);

        // Should see clean text in badge
        $response->assertSee('Online Discount Applied');
    }
}

