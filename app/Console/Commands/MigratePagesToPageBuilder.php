<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Page;

class MigratePagesToPageBuilder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pagebuilder:migrate-pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate CDTC CMS pages into PHPageBuilder tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pages = Page::all();
        $this->info("Syncing {$pages->count()} pages to PageBuilder tables...");

        $synced = 0;
        foreach ($pages as $page) {
            $pbRoute = '/' . ltrim($page->slug, '/');
            $existing = DB::table('pagebuilder__page_translations')->where('route', $pbRoute)->first();
            if ($existing) {
                continue;
            }

            $pbPageId = DB::table('pagebuilder__pages')->insertGetId([
                'name' => $page->title,
                'layout' => 'master',
                'data' => json_encode([
                    'html' => [$page->content ?: ''],
                    'css' => '',
                    'components' => [],
                    'assets' => [],
                    'styles' => [],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('pagebuilder__page_translations')->insert([
                'page_id' => $pbPageId,
                'locale' => 'en',
                'title' => \Illuminate\Support\Str::limit($page->title, 250, ''),
                'route' => $pbRoute,
                'meta_title' => \Illuminate\Support\Str::limit($page->meta_title ?: $page->title, 250, ''),
                'meta_description' => $page->meta_description ?: '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $synced++;
        }

        $this->info("Complete! Initialized {$synced} pages in PageBuilder.");
    }
}
