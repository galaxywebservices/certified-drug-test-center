<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPageHtmlInputTest extends TestCase
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

    public function test_can_create_page_with_direct_html_content_and_description(): void
    {
        $admin = $this->getAdminUser();

        $htmlContent = '<h2>Heading</h2><p>Paragraph with <a href="https://example.com">link</a> and <iframe src="https://example.com/embed"></iframe></p>';
        $htmlDesc = '<p>Meta description with <strong>bold</strong> text</p>';

        $response = $this->actingAs($admin)->post('/admin/pages', [
            'title' => 'HTML Test Page Direct',
            'slug' => '',
            'template' => 'default',
            'content' => $htmlContent,
            'meta_description' => $htmlDesc,
            'is_published' => 1,
        ]);

        $response->assertRedirect('/admin/pages');
        $response->assertSessionHas('success');

        $page = Page::where('title', 'HTML Test Page Direct')->first();
        $this->assertNotNull($page);
        $this->assertEquals($htmlContent, $page->content);
        $this->assertEquals($htmlDesc, $page->meta_description);

        // Clean up
        \Illuminate\Support\Facades\DB::table('pagebuilder__page_translations')->where('route', '/' . $page->slug)->delete();
        $page->delete();
    }

    public function test_can_create_page_with_base64_encoded_html_fields(): void
    {
        $admin = $this->getAdminUser();

        $rawContent = '<div><h3>Section</h3><iframe src="https://youtube.com/embed/xyz"></iframe><style>.custom{color:red;}</style></div>';
        $rawDesc = '<p>Snippet with <a href="/test">link</a></p>';

        $response = $this->actingAs($admin)->post('/admin/pages', [
            'title' => 'HTML Test Page B64',
            'slug' => '',
            'template' => 'default',
            'content_b64' => base64_encode($rawContent),
            'meta_description_b64' => base64_encode($rawDesc),
            'is_published' => 1,
        ]);

        $response->assertRedirect('/admin/pages');
        $response->assertSessionHas('success');

        $page = Page::where('title', 'HTML Test Page B64')->first();
        $this->assertNotNull($page);
        $this->assertEquals($rawContent, $page->content);
        $this->assertEquals($rawDesc, $page->meta_description);

        // Clean up
        \Illuminate\Support\Facades\DB::table('pagebuilder__page_translations')->where('route', '/' . $page->slug)->delete();
        $page->delete();
    }

    public function test_can_update_page_with_base64_encoded_html_fields(): void
    {
        $admin = $this->getAdminUser();

        $page = Page::create([
            'title' => 'HTML Update Page',
            'slug' => 'html-update-page-' . time(),
            'template' => 'default',
            'content' => 'Old content',
            'meta_description' => 'Old description',
            'is_published' => 1,
        ]);

        $updatedContent = '<article><h1>New article</h1><img src="/img/lab.jpg" alt="Lab"></article>';
        $updatedDesc = 'New description with <em>emphasis</em>';

        $response = $this->actingAs($admin)->put('/admin/pages/' . $page->id, [
            'title' => 'HTML Update Page',
            'slug' => $page->slug,
            'template' => 'default',
            'content_b64' => base64_encode($updatedContent),
            'meta_description_b64' => base64_encode($updatedDesc),
            'is_published' => 1,
        ]);

        $response->assertRedirect('/admin/pages');
        $response->assertSessionHas('success');

        $page->refresh();
        $this->assertEquals($updatedContent, $page->content);
        $this->assertEquals($updatedDesc, $page->meta_description);

        // Clean up
        \Illuminate\Support\Facades\DB::table('pagebuilder__page_translations')->where('route', '/' . $page->slug)->delete();
        $page->delete();
    }
}
