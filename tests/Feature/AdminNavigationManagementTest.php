<?php

namespace Tests\Feature;

use App\Models\NavigationItem;
use App\Models\Page;
use App\Models\User;
use Tests\TestCase;

class AdminNavigationManagementTest extends TestCase
{
    protected $testPageIds = [];
    protected $testNavIds = [];

    protected function tearDown(): void
    {
        if (!empty($this->testNavIds)) {
            NavigationItem::whereIn('id', $this->testNavIds)->delete();
        }
        if (!empty($this->testPageIds)) {
            Page::whereIn('id', $this->testPageIds)->delete();
        }
        NavigationItem::clearCache();
        parent::tearDown();
    }

    protected function getAdminUser(): User
    {
        return User::first() ?? User::factory()->create([
            'email' => 'admin@certifieddrugtestingcenters.com',
            'is_admin' => true,
        ]);
    }

    public function test_guest_cannot_access_navigation_admin(): void
    {
        $response = $this->get('/admin/navigation');
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_view_navigation_management_dashboard(): void
    {
        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->get('/admin/navigation');
        $response->assertStatus(200);
        $response->assertSee('Navigation Menu Structure');
        $response->assertSee('Quick-Add CMS Page');
        $response->assertSee('Add Custom URL or Link');
    }

    public function test_admin_can_create_top_level_navigation_item(): void
    {
        $admin = $this->getAdminUser();

        $response = $this->actingAs($admin)->post('/admin/navigation', [
            'title' => 'Test Main Menu',
            'url' => '/category/test',
            'target' => '_self',
            'order' => 99,
            'is_active' => 1,
        ]);

        $response->assertRedirect('/admin/navigation');
        $this->assertDatabaseHas('navigation_items', [
            'title' => 'Test Main Menu',
            'url' => '/category/test',
            'parent_id' => null,
        ]);
    }

    public function test_admin_can_create_submenu_item_under_parent(): void
    {
        $admin = $this->getAdminUser();

        $parent = NavigationItem::firstOrCreate([
            'title' => 'Urine Tests Parent',
            'parent_id' => null,
        ], [
            'url' => '/category/urine',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->post('/admin/navigation', [
            'title' => 'Special 7-Panel Urine Test',
            'url' => '/product/7-panel',
            'parent_id' => $parent->id,
            'target' => '_self',
            'order' => 2,
            'is_active' => 1,
        ]);

        $response->assertRedirect('/admin/navigation');
        $this->assertDatabaseHas('navigation_items', [
            'title' => 'Special 7-Panel Urine Test',
            'parent_id' => $parent->id,
        ]);
    }

    public function test_admin_can_update_navigation_item(): void
    {
        $admin = $this->getAdminUser();

        $item = NavigationItem::create([
            'title' => 'Old Menu Title',
            'url' => '/old-url',
            'order' => 1,
            'is_active' => true,
        ]);
        $this->testNavIds[] = $item->id;

        $response = $this->actingAs($admin)->put("/admin/navigation/{$item->id}", [
            'title' => 'New Updated Menu Title',
            'url' => '/new-url',
            'target' => '_blank',
            'order' => 5,
            'is_active' => 1,
        ]);

        $response->assertRedirect('/admin/navigation');
        $this->assertDatabaseHas('navigation_items', [
            'id' => $item->id,
            'title' => 'New Updated Menu Title',
            'url' => '/new-url',
            'target' => '_blank',
        ]);
    }

    public function test_admin_can_delete_navigation_item_and_children(): void
    {
        $admin = $this->getAdminUser();

        $parent = NavigationItem::create([
            'title' => 'Parent to Delete',
            'url' => '/parent-delete',
            'order' => 50,
        ]);

        $child = NavigationItem::create([
            'parent_id' => $parent->id,
            'title' => 'Child to Delete',
            'url' => '/child-delete',
            'order' => 1,
        ]);

        $response = $this->actingAs($admin)->delete("/admin/navigation/{$parent->id}");
        $response->assertRedirect('/admin/navigation');

        $this->assertDatabaseMissing('navigation_items', ['id' => $parent->id]);
        $this->assertDatabaseMissing('navigation_items', ['id' => $child->id]);
    }

    public function test_admin_can_reorder_navigation_items_via_ajax(): void
    {
        $admin = $this->getAdminUser();

        $item1 = NavigationItem::create(['title' => 'Item 1', 'url' => '/1', 'order' => 1]);
        $item2 = NavigationItem::create(['title' => 'Item 2', 'url' => '/2', 'order' => 2]);
        $this->testNavIds[] = $item1->id;
        $this->testNavIds[] = $item2->id;

        $response = $this->actingAs($admin)->postJson('/admin/navigation-reorder', [
            'items' => [
                ['id' => $item1->id, 'parent_id' => null, 'order' => 2],
                ['id' => $item2->id, 'parent_id' => null, 'order' => 1],
            ],
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertEquals(2, $item1->fresh()->order);
        $this->assertEquals(1, $item2->fresh()->order);
    }

    public function test_admin_can_toggle_navigation_item_active_status(): void
    {
        $admin = $this->getAdminUser();

        $item = NavigationItem::create(['title' => 'Item Active', 'url' => '/active', 'is_active' => true]);
        $this->testNavIds[] = $item->id;

        $response = $this->actingAs($admin)->postJson("/admin/navigation/{$item->id}/toggle");
        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'is_active' => false]);
        $this->assertFalse($item->fresh()->is_active);

        $response2 = $this->actingAs($admin)->postJson("/admin/navigation/{$item->id}/toggle");
        $response2->assertStatus(200);
        $response2->assertJson(['success' => true, 'is_active' => true]);
        $this->assertTrue($item->fresh()->is_active);
    }

    public function test_admin_can_quick_add_cms_page_to_navigation(): void
    {
        $admin = $this->getAdminUser();

        $uniq = uniqid();
        $page = Page::create([
            'title' => "Urine Drug Test {$uniq}",
            'slug' => "urine-test-{$uniq}",
            'template' => 'wide',
            'is_published' => true,
        ]);
        $this->testPageIds[] = $page->id;

        $parent = NavigationItem::where('title', 'Urine Tests')->first()
            ?? NavigationItem::create(['title' => 'Urine Tests', 'url' => '/category/urine', 'order' => 1]);

        $response = $this->actingAs($admin)->post('/admin/navigation/quick-add-page', [
            'page_id' => $page->id,
            'parent_id' => $parent->id,
            'custom_title' => "Urine Test {$uniq}",
        ]);

        $response->assertRedirect('/admin/navigation');

        $this->assertDatabaseHas('navigation_items', [
            'page_id' => $page->id,
            'parent_id' => $parent->id,
            'title' => "Urine Test {$uniq}",
            'url' => "/urine-test-{$uniq}",
        ]);

        $freshPage = $page->fresh();
        $this->assertTrue($freshPage->show_in_menu);
        $this->assertEquals($parent->id, $freshPage->menu_parent_id);
    }

    public function test_page_editor_syncs_with_navigation_items(): void
    {
        $admin = $this->getAdminUser();

        $parent = NavigationItem::where('title', 'Urine Tests')->first()
            ?? NavigationItem::create(['title' => 'Urine Tests', 'url' => '/category/urine', 'order' => 1]);

        $uniq = uniqid();
        $page = Page::create([
            'title' => "Mobile Collector {$uniq}",
            'slug' => "collector-{$uniq}",
            'template' => 'default',
            'is_published' => true,
            'show_in_menu' => false,
        ]);
        $this->testPageIds[] = $page->id;

        // Update page with show_in_menu = true
        $response = $this->actingAs($admin)->put("/admin/pages/{$page->id}", [
            'title' => "Mobile Collector {$uniq}",
            'slug' => "collector-{$uniq}",
            'template' => 'default',
            'is_published' => 1,
            'show_in_menu' => 1,
            'menu_parent_id' => $parent->id,
            'menu_order' => 3,
            'menu_name' => "Collector Course {$uniq}",
        ]);

        $response->assertRedirect('/admin/pages');

        $this->assertDatabaseHas('navigation_items', [
            'page_id' => $page->id,
            'parent_id' => $parent->id,
            'title' => "Collector Course {$uniq}",
            'order' => 3,
        ]);

        // Now update page with show_in_menu = false (should remove from navigation)
        $response2 = $this->actingAs($admin)->put("/admin/pages/{$page->id}", [
            'title' => "Mobile Collector {$uniq}",
            'slug' => "collector-{$uniq}",
            'template' => 'default',
            'is_published' => 1,
            'show_in_menu' => 0,
        ]);

        $response2->assertRedirect('/admin/pages');
        $this->assertDatabaseMissing('navigation_items', ['page_id' => $page->id]);
    }

    public function test_live_website_renders_dynamic_navigation_items(): void
    {
        NavigationItem::clearCache();

        $uniqueTitle = 'Dynamic Test Nav Item ' . time();
        NavigationItem::create([
            'title' => $uniqueTitle,
            'url' => '/test-unique-url',
            'order' => 999,
            'is_active' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee($uniqueTitle);
        $response->assertSee('/test-unique-url');
    }
}
