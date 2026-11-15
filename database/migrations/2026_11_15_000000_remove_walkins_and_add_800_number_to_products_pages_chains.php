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
        // 1. Update Products Table: Standardize Title with 800 number, remove asterisk, remove walk-in from meta description
        $products = DB::table('products')->get();
        foreach ($products as $p) {
            $cleanName = trim(ltrim($p->name, '* '));
            $updates = [];

            if ($p->name !== $cleanName) {
                $updates['name'] = $cleanName;
            }

            $newTitle = "{$cleanName} - (800) 985-4339";
            if ($p->meta_title !== $newTitle) {
                $updates['meta_title'] = $newTitle;
            }

            $newDesc = "Order {$cleanName} online or call (800) 985-4339 for an instant donor pass at over 20,000 certified collection sites nationwide. Fast, confidential, and legally defensible.";
            if ($p->meta_description !== $newDesc) {
                $updates['meta_description'] = $newDesc;
            }

            if (!empty($updates)) {
                $updates['updated_at'] = now();
                DB::table('products')->where('id', $p->id)->update($updates);
            }
        }

        // 2. Update Categories Table: Standardize Title with 800 number, clean meta description
        $categories = DB::table('categories')->get();
        foreach ($categories as $c) {
            $displayName = $c->display_name ?: $c->name;
            $updates = [
                'meta_title' => "{$displayName} - (800) 985-4339",
                'meta_description' => "Explore certified {$displayName} options. Order online or call (800) 985-4339 for an instant donor pass at 20,000+ certified collection sites nationwide.",
                'updated_at' => now(),
            ];
            DB::table('categories')->where('id', $c->id)->update($updates);
        }

        // 3. Update States Table: Ensure title ends with 800 number and meta description uses 'certified clinics' instead of 'walk-in clinics'
        $states = DB::table('states')->get();
        foreach ($states as $s) {
            $newTitle = "{$s->name} Drug Testing Centers - (800) 985-4339";
            $newDesc = "Certified Drug Test Centers in {$s->name} ({$s->abbr}). Order online or call (800) 985-4339 for an instant donor pass at local Quest & Labcorp certified clinics.";
            DB::table('states')->where('id', $s->id)->update([
                'meta_title' => $newTitle,
                'meta_description' => $newDesc,
                'updated_at' => now(),
            ]);
        }

        // 4. Update Cities Table: Remove any Walk-ins Welcome, ensure 800 number format, update description to certified clinics
        $cities = DB::table('cities')->join('states', 'cities.state_id', '=', 'states.id')
            ->select('cities.id', 'cities.name as city_name', 'states.abbr as state_abbr', 'cities.meta_title', 'cities.meta_description')
            ->get();

        foreach ($cities as $c) {
            $correctTitle = "{$c->city_name}, {$c->state_abbr} Drug Testing Centers - (800) 985-4339";
            $correctDesc = "Certified Drug Test Centers in {$c->city_name}, {$c->state_abbr}. Order online or call (800) 985-4339 for an instant donor pass at local Quest & Labcorp certified clinics.";

            $updates = [];
            if ($c->meta_title !== $correctTitle) {
                $updates['meta_title'] = $correctTitle;
            }
            if ($c->meta_description !== $correctDesc) {
                $updates['meta_description'] = $correctDesc;
            }

            if (!empty($updates)) {
                $updates['updated_at'] = now();
                DB::table('cities')->where('id', $c->id)->update($updates);
            }
        }

        // 5. Update Pages Table: Remove walk-in phrasing, insert 800 number in meta titles & descriptions
        $pages = DB::table('pages')->get();
        foreach ($pages as $pg) {
            $updates = [];

            // Clean meta_title
            $currentTitle = $pg->meta_title ?: $pg->title;
            $newTitle = preg_replace('/\|\s*Walk-ins?\s*Welcome/i', '- (800) 985-4339', $currentTitle);
            $newTitle = preg_replace('/\|\s*Walk-in[s]?/i', '- (800) 985-4339', $newTitle);
            $newTitle = preg_replace('/\s*[-|]\s*Certified Drug Test Centers?$/i', ' - (800) 985-4339', $newTitle);
            if (!str_contains($newTitle, '800')) {
                $newTitle = rtrim($newTitle) . ' - (800) 985-4339';
            }
            if ($pg->meta_title !== $newTitle) {
                $updates['meta_title'] = $newTitle;
            }

            // Clean meta_description
            if ($pg->meta_description) {
                $desc = $pg->meta_description;
                $desc = preg_replace('/walk[- ]?in\'?s?\s*welcome/i', 'same-day testing, call (800) 985-4339', $desc);
                $desc = preg_replace('/walk[- ]?in/i', 'same-day', $desc);
                if ($desc !== $pg->meta_description) {
                    $updates['meta_description'] = $desc;
                }
            }

            // Clean content
            if ($pg->content) {
                $cnt = $pg->content;
                $cnt = preg_replace('/walk[- ]?in\'?s?\s*welcome/i', 'call (800) 985-4339 for same-day donor pass', $cnt);
                if ($cnt !== $pg->content) {
                    $updates['content'] = $cnt;
                }
            }

            if (!empty($updates)) {
                $updates['updated_at'] = now();
                DB::table('pages')->where('id', $pg->id)->update($updates);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op rollback for content/meta updates
    }
};

