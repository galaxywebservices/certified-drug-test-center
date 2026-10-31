<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        \Illuminate\Support\Facades\DB::disableQueryLog();

        $file = database_path('seeders/data/pages.json');
        if (!File::exists($file)) {
            return;
        }

        $pages = json_decode(File::get($file), true);
        if (!is_array($pages)) {
            return;
        }

        foreach (array_chunk($pages, 50) as $chunk) {
            foreach ($chunk as $p) {
                Page::updateOrCreate(['slug' => $p['slug']], $p);
            }
        }
    }
}
