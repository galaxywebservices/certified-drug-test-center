<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPageBuilderTest extends TestCase
{
    public function test_super_admin_can_access_page_editor_with_pagebuilder_integration()
    {
        $admin = User::where('is_super_admin', true)->first();
        if (!$admin) {
            $admin = User::factory()->create(['is_super_admin' => true]);
        }

        $page = Page::first();
        if (!$page) {
            $page = Page::create([
                'title' => 'Test Page',
                'slug' => 'test-page',
                'content' => '<p>Initial content</p>'
            ]);
        }

        $response = $this->actingAs($admin)->get(route('admin.pages.edit', $page));
        $response->assertStatus(200);
        $response->assertSee('Launch Visual PageBuilder');
        $response->assertSee('id="pbIframe"', false);
    }

    public function test_super_admin_can_access_pagebuilder_editor()
    {
        $admin = User::where('is_super_admin', true)->first();
        if (!$admin) {
            $admin = User::factory()->create(['is_super_admin' => true]);
        }

        ob_start();
        $response = $this->actingAs($admin)->get('/admin/pagebuilder?action=edit&page=86');
        ob_end_clean();

        $response->assertStatus(200);
    }
}
