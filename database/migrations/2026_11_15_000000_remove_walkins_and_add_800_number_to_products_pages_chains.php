<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Prevent memory exhaustion on memory-constrained CLI environments (e.g. cPanel default 128M)
        @ini_set('memory_limit', '512M');

        // 1. Update Products Table: Standardize Title with 800 number, remove asterisk, clean meta description
        DB::table('products')->select('id', 'name', 'meta_title', 'meta_description')->chunkById(50, function ($products) {
            foreach ($products as $p) {
                $cleanName = trim(ltrim($p->name, '* '));
                $newTitle = "{$cleanName} - (800) 985-4339";
                $newDesc = "Order {$cleanName} online or call (800) 985-4339 for an instant donor pass at over 20,000 certified collection sites nationwide. Fast, confidential, and legally defensible.";

                DB::table('products')->where('id', $p->id)->update([
                    'name' => $cleanName,
                    'meta_title' => $newTitle,
                    'meta_description' => $newDesc,
                    'updated_at' => now(),
                ]);
            }
        });

        // 2. Update Categories Table: Standardize Title with 800 number, clean meta description
        DB::table('categories')->select('id', 'name', 'display_name')->chunkById(25, function ($categories) {
            foreach ($categories as $c) {
                $displayName = !empty($c->display_name) ? $c->display_name : $c->name;
                DB::table('categories')->where('id', $c->id)->update([
                    'meta_title' => "{$displayName} - (800) 985-4339",
                    'meta_description' => "Explore certified {$displayName} options. Order online or call (800) 985-4339 for an instant donor pass at 20,000+ certified collection sites nationwide.",
                    'updated_at' => now(),
                ]);
            }
        });

        // 3. Update States Table via Direct SQL (Zero PHP Memory Overhead)
        DB::statement("
            UPDATE states
            SET 
                meta_title = CONCAT(name, ' Drug Testing Centers - (800) 985-4339'),
                meta_description = CONCAT('Certified Drug Test Centers in ', name, ' (', abbr, '). Order online or call (800) 985-4339 for an instant donor pass at local Quest & Labcorp certified clinics.'),
                updated_at = NOW()
        ");

        // 4. Update Cities Table via Direct SQL Join (Zero PHP Memory Overhead across all 977 cities)
        DB::statement("
            UPDATE cities c
            JOIN states s ON c.state_id = s.id
            SET 
                c.meta_title = CONCAT(c.name, ', ', s.abbr, ' Drug Testing Centers - (800) 985-4339'),
                c.meta_description = CONCAT('Certified Drug Test Centers in ', c.name, ', ', s.abbr, '. Order online or call (800) 985-4339 for an instant donor pass at local Quest & Labcorp certified clinics.'),
                c.updated_at = NOW()
        ");

        // 5. Update Pages Table: Split into small chunks and NEVER load heavy 'content' column into memory
        // 5a. Meta Title and Meta Description (only loads short string columns in 50-row chunks)
        DB::table('pages')->select('id', 'title', 'meta_title', 'meta_description')->chunkById(50, function ($pages) {
            foreach ($pages as $pg) {
                $currentTitle = $pg->meta_title ?: $pg->title;
                $newTitle = preg_replace('/\|\s*Walk-ins?\s*Welcome/i', '- (800) 985-4339', $currentTitle);
                $newTitle = preg_replace('/\|\s*Walk-in[s]?/i', '- (800) 985-4339', $newTitle);
                $newTitle = preg_replace('/\s*[-|]\s*Certified Drug Test Centers?$/i', ' - (800) 985-4339', $newTitle);
                if (!str_contains($newTitle, '800')) {
                    $newTitle = rtrim($newTitle) . ' - (800) 985-4339';
                }

                $desc = $pg->meta_description;
                if ($desc) {
                    $desc = preg_replace('/walk[- ]?in\'?s?\s*welcome/i', 'same-day testing, call (800) 985-4339', $desc);
                    $desc = preg_replace('/walk[- ]?in/i', 'same-day', $desc);
                }

                DB::table('pages')->where('id', $pg->id)->update([
                    'meta_title' => $newTitle,
                    'meta_description' => $desc,
                    'updated_at' => now(),
                ]);
            }
        });

        // 5b. Content cleanup ONLY for the few rows that actually contain 'walk' (chunks of 10 to protect memory)
        DB::table('pages')->where('content', 'LIKE', '%walk%')->select('id', 'content')->chunkById(10, function ($pages) {
            foreach ($pages as $pg) {
                $cnt = preg_replace('/walk[- ]?in\'?s?\s*welcome/i', 'call (800) 985-4339 for same-day donor pass', $pg->content);
                if ($cnt !== $pg->content) {
                    DB::table('pages')->where('id', $pg->id)->update([
                        'content' => $cnt,
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op rollback for content/meta updates
    }
};
