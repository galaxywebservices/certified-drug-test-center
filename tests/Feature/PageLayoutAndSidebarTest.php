<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class PageLayoutAndSidebarTest extends TestCase
{
    protected function getAdminUser(): User
    {
        return User::firstOrCreate(
            ['email' => 'admin@certifieddrugtestingcenters.com'],
            [
                'name' => 'Super Administrator',
                'password' => bcrypt('password'),
                'is_super_admin' => true,
            ]
        );
    }

    public function test_default_template_renders_sidebar_with_popular_tests(): void
    {
        $page = Page::create([
            'title' => 'Standard Corporate Page',
            'slug' => 'standard-page-test-' . time(),
            'template' => 'default',
            'content' => '<p>Standard page body content.</p>',
            'is_published' => true,
        ]);

        $response = $this->get('/' . $page->slug);
        $response->assertStatus(200);
        $response->assertSee('cms-layout-grid', false);
        $response->assertSee('Popular Tests Available Today');

        $page->delete();
    }

    public function test_wide_template_hides_sidebar_and_popular_tests(): void
    {
        $page = Page::create([
            'title' => 'Full Width Clean Page',
            'slug' => 'full-width-page-test-' . time(),
            'template' => 'wide',
            'content' => '<p>Full width article body.</p>',
            'show_sidebar' => false,
            'is_published' => true,
        ]);

        $response = $this->get('/' . $page->slug);
        $response->assertStatus(200);
        $response->assertDontSee('<div class="cms-layout-grid">', false);
        $response->assertDontSee('Popular Tests Available Today');
        $response->assertSee('cms-layout-full', false);

        $page->delete();
    }

    public function test_landing_page_renders_fluid_without_sidebar_or_default_hero(): void
    {
        $page = Page::create([
            'title' => 'Landing Page Test',
            'slug' => 'landing-page-test-' . time(),
            'template' => 'landing',
            'content' => '<div class="cdtc"><div class="wrap"><h1>Custom Hero Title</h1></div></div>',
            'show_sidebar' => false,
            'show_hero' => false,
            'full_width' => true,
            'is_published' => true,
        ]);

        $response = $this->get('/' . $page->slug);
        $response->assertStatus(200);
        $response->assertDontSee('Popular Tests Available Today');
        $response->assertDontSee('<div class="cms-hero-bar">', false);
        $response->assertSee('cms-page-fluid', false);
        $response->assertSee('Custom Hero Title');

        $page->delete();
    }

    public function test_admin_can_toggle_sidebar_off_via_edit(): void
    {
        $admin = $this->getAdminUser();

        $page = Page::create([
            'title' => 'Toggle Sidebar Page',
            'slug' => 'toggle-sidebar-page-' . time(),
            'template' => 'default',
            'content' => '<p>Content</p>',
            'show_sidebar' => true,
            'is_published' => true,
        ]);

        // Submit update with show_sidebar unchecked (omitted from payload with show_sidebar_submitted=1)
        $response = $this->actingAs($admin)->put('/admin/pages/' . $page->id, [
            'title' => 'Toggle Sidebar Page',
            'slug' => $page->slug,
            'template' => 'default',
            'content' => '<p>Content</p>',
            'show_sidebar_submitted' => 1,
            // show_sidebar not sent -> should be saved as false
            'is_published' => 1,
        ]);

        $response->assertRedirect('/admin/pages');
        $page->refresh();
        $this->assertFalse((bool) $page->show_sidebar);

        // When viewing, sidebar should now be gone
        $viewResponse = $this->get('/' . $page->slug);
        $viewResponse->assertDontSee('Popular Tests Available Today');

        $page->delete();
    }
}
