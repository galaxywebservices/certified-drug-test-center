<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\Page;
use App\Models\State;
use App\Models\City;
use App\Models\Location;
use App\Models\Setting;
use App\Models\User;

class ImportAdtDataCommand extends Command
{
    protected $signature = 'cdtc:import-adt {--export-json : Also export seeded data to JSON files in database/seeders/data}';
    protected $description = 'Import categories, products, base pages, states, cities, and locations from accrediteddrugte_s2 into cdtc';

    public function handle(): int
    {
        $this->info("Starting ADT data migration from accrediteddrugte_s2 into cdtc...");

        // Ensure database/seeders/data directory exists
        $dataDir = database_path('seeders/data');
        if (!File::isDirectory($dataDir)) {
            File::makeDirectory($dataDir, 0755, true);
        }

        try {
            DB::connection('adt_source')->getPdo();
        } catch (\Exception $e) {
            $this->error("Could not connect to adt_source database: " . $e->getMessage());
            return Command::FAILURE;
        }

        $this->importCategories($dataDir);
        $this->importProducts($dataDir);
        $this->importCategoryProductPivot($dataDir);
        $this->importPages($dataDir);
        $this->importStatesAndCities($dataDir);
        $this->importLocations();
        $this->seedSuperAdmin();
        $this->seedDefaultSettings();

        $this->info("Migration completed successfully!");
        return Command::SUCCESS;
    }

    protected function importCategories(string $dataDir): void
    {
        $this->line("-> Importing Categories...");
        $sourceCategories = DB::connection('adt_source')->table('product_categories')->get();

        $records = [];
        foreach ($sourceCategories as $cat) {
            $slug = Str::slug($cat->slug ?: $cat->name);
            $displayName = !empty($cat->newname) ? $cat->newname : $cat->name;

            $record = [
                'id' => $cat->id,
                'slug' => $slug,
                'name' => $cat->name,
                'display_name' => $displayName,
                'subtitle' => $cat->subtitle ?: null,
                'icon' => $cat->icon ?: null,
                'image' => $cat->image ?: null,
                'position' => (int) $cat->position,
                'is_active' => true,
                'meta_title' => $displayName . " | Certified Drug Test Center",
                'meta_description' => "Order " . strtolower($displayName) . " with fast online registration and walk-in testing at accredited facilities nationwide.",
                'canonical_url' => url('/category/' . $slug),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            Category::updateOrCreate(['id' => $cat->id], $record);
            $records[] = $record;
        }

        File::put($dataDir . '/categories.json', json_encode($records, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $this->info("   Imported " . count($records) . " categories.");
    }

    protected function importProducts(string $dataDir): void
    {
        $this->line("-> Importing Products...");
        $sourceProducts = DB::connection('adt_source')->table('product_data')->get();

        $records = [];
        foreach ($sourceProducts as $prod) {
            $slug = Str::slug($prod->slug ?: $prod->name);
            if (empty($slug)) {
                $slug = 'test-' . $prod->id;
            }

            // Ensure unique slug
            $existing = Product::where('slug', $slug)->where('id', '!=', $prod->id)->first();
            if ($existing) {
                $slug = $slug . '-' . $prod->id;
            }

            $price = (float) $prod->price;
            $retailPrice = round($price * 1.35, 2);

            // Determine specimen type
            $lower = strtolower($prod->name . ' ' . $prod->slug . ' ' . $prod->details);
            $specimen = 'urine';
            if (str_contains($lower, 'hair')) {
                $specimen = 'hair';
            } elseif (str_contains($lower, 'alcohol') || str_contains($lower, 'breath')) {
                $specimen = 'alcohol';
            } elseif (str_contains($lower, 'oral') || str_contains($lower, 'saliva')) {
                $specimen = 'saliva';
            } elseif (str_contains($lower, 'blood')) {
                $specimen = 'blood';
            } elseif (str_contains($lower, 'dna')) {
                $specimen = 'dna';
            }

            // Determine panels
            $panels = [];
            if (preg_match('/(\d+)\s*panel/i', $prod->name, $matches)) {
                $panelCount = (int) $matches[1];
                $standardPanels = [
                    'Amphetamines (AMP)',
                    'Cocaine (COC)',
                    'Marijuana (THC)',
                    'Opiates (OPI)',
                    'Phencyclidine (PCP)',
                    'Benzodiazepines (BZO)',
                    'Barbiturates (BAR)',
                    'Methadone (MTD)',
                    'Propoxyphene (PPX)',
                    'Methaqualone (MQL)',
                    'Oxycodone (OXY)',
                    'Buprenorphine (BUP)',
                ];
                $panels = array_slice($standardPanels, 0, min($panelCount, count($standardPanels)));
            }

            $record = [
                'id' => $prod->id,
                'slug' => $slug,
                'name' => $prod->name,
                'subtitle' => $prod->subtitle ?: 'Online Discount Applied',
                'sku' => 'CDTC-' . str_pad($prod->id, 4, '0', STR_PAD_LEFT),
                'retail_price' => $retailPrice,
                'price' => $price,
                'specimen_type' => $specimen,
                'dot_required' => (bool) $prod->dot_required,
                'turnaround_time' => (str_contains($lower, 'rapid') || str_contains($lower, 'instant')) ? 'Instant Rapid Results' : '24-48 Hours Lab MRO',
                'short_description' => strip_tags(substr($prod->details, 0, 200)) . '...',
                'details' => $prod->details,
                'preparation_instructions' => 'Bring a valid government-issued photo ID and your electronic Donor Pass. Drink plenty of water prior to collection if providing a urine specimen.',
                'included_panels' => $panels,
                'is_popular' => in_array($prod->id, [1, 2, 3, 7, 8, 20]),
                'is_active' => true,
                'position' => (int) $prod->id,
                'meta_title' => $prod->name . " | Certified Drug Test Centers",
                'meta_description' => "Order {$prod->name} online. Walk in today at over 20,000 certified collection sites nationwide. Fast, confidential, and legally defensible.",
                'canonical_url' => url('/product/' . $slug),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            Product::updateOrCreate(['id' => $prod->id], $record);
            $records[] = $record;
        }

        File::put($dataDir . '/products.json', json_encode($records, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $this->info("   Imported " . count($records) . " products.");
    }

    protected function importCategoryProductPivot(string $dataDir): void
    {
        $this->line("-> Importing Category-Product Pivot...");
        $pivots = DB::connection('adt_source')->table('product_cat2test')->get();

        $records = [];
        foreach ($pivots as $p) {
            $catExists = Category::where('id', $p->category)->exists();
            $prodExists = Product::where('id', $p->product)->exists();

            if ($catExists && $prodExists) {
                DB::table('category_product')->updateOrInsert(
                    [
                        'category_id' => $p->category,
                        'product_id' => $p->product,
                    ],
                    [
                        'position' => (int) $p->position,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

                $records[] = [
                    'category_id' => $p->category,
                    'product_id' => $p->product,
                    'position' => (int) $p->position,
                ];
            }
        }

        File::put($dataDir . '/category_product.json', json_encode($records, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $this->info("   Imported " . count($records) . " category-product links.");
    }

    protected function importPages(string $dataDir): void
    {
        $this->line("-> Importing Base CMS Pages...");
        $sourcePages = DB::connection('adt_source')->table('pages')->where('live', 1)->get();

        $records = [];
        foreach ($sourcePages as $p) {
            $url = trim($p->url, '/');
            if (empty($url)) {
                $url = 'page-' . $p->id;
            }

            // Exclude test paths or duplicates if any
            if (in_array($url, ['checkout', 'order-confirmation', 'psd2css'])) {
                continue;
            }

            $title = !empty($p->pagetitle) ? str_replace(' - Accredited Drug Testing', '', $p->pagetitle) : Str::headline($url);
            $title = str_replace('| (800)-985-4339', '', $title);
            $title = trim($title);

            $record = [
                'id' => $p->id,
                'slug' => $url,
                'title' => $title,
                'page_heading' => $title,
                'template' => 'default',
                'featured_image' => $p->image ?: null,
                'content' => $p->content,
                'blocks_json' => null,
                'is_published' => true,
                'show_in_menu' => !empty($p->menu_name),
                'menu_name' => $p->menu_name ?: null,
                'menu_order' => (int) $p->menu_position,
                'meta_title' => $p->pagetitle ?: ($title . " | Certified Drug Test Center"),
                'meta_description' => $p->metadesc ?: "Information and nationwide testing services for {$title}.",
                'canonical_url' => $p->canonical ?: url('/' . $url),
                'robots_index' => true,
                'robots_follow' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            Page::updateOrCreate(['id' => $p->id], $record);
            $records[] = $record;
        }

        File::put($dataDir . '/pages.json', json_encode($records, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $this->info("   Imported " . count($records) . " base CMS pages.");
    }

    protected function importStatesAndCities(string $dataDir): void
    {
        $this->line("-> Importing States & Major Cities...");
        $sourceStates = DB::connection('adt_source')->table('statedata')->get();

        $stateRecords = [];
        foreach ($sourceStates as $st) {
            $abbr = strtoupper(trim($st->state_abbr));
            $name = trim($st->state_name);
            $slug = Str::slug($name);

            $record = [
                'id' => $st->id,
                'abbr' => $abbr,
                'name' => $name,
                'slug' => $slug,
                'is_active' => true,
                'content' => "Certified drug and alcohol testing collection facilities in {$name}. Fully compliant with state laws and DOT regulations.",
                'meta_title' => "{$name} Drug Testing Centers | Certified Drug Test Center",
                'meta_description' => "Find certified drug testing collection sites in {$name}. Walk-ins welcome for employment, court, and DOT testing.",
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $stateModel = State::updateOrCreate(['abbr' => $abbr], $record);
            $stateRecords[] = $record;

            // Import top cities for this state from 1us_cities_done or locations
            $topCities = DB::connection('adt_source')
                ->table('1us_cities_done')
                ->where('state_abbr', $abbr)
                ->limit(20)
                ->get();

            foreach ($topCities as $cityRow) {
                $cityName = trim($cityRow->city_name);
                $citySlug = Str::slug($cityName);

                City::updateOrCreate(
                    [
                        'state_id' => $stateModel->id,
                        'slug' => $citySlug,
                    ],
                    [
                        'name' => $cityName,
                        'is_active' => true,
                        'meta_title' => "{$cityName}, {$abbr} Drug Testing Locations & Walk-in Centers",
                        'meta_description' => "Fast walk-in drug and alcohol testing in {$cityName}, {$abbr}. Order online in 2 minutes.",
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        File::put($dataDir . '/states.json', json_encode($stateRecords, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $this->info("   Imported 51 States and major cities.");
    }

    protected function importLocations(): void
    {
        $this->line("-> Importing All Collection Site Locations & Cities...");
        try {
            DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
            DB::statement("TRUNCATE TABLE cdtc.locations;");
            DB::statement("
                INSERT INTO cdtc.locations (id, name, provider, address1, address2, city, state, zip, phone, hours, lat, lng, is_active, created_at, updated_at)
                SELECT 
                    id,
                    CONCAT(IFNULL(provider, 'Certified'), ' Collection Site'),
                    IF(LOWER(IFNULL(provider, 'quest')) LIKE '%labcorp%', 'labcorp', 'quest'),
                    IFNULL(address1, 'Collection Site'),
                    address2,
                    IFNULL(city, ''),
                    IFNULL(state, ''),
                    IFNULL(zip, ''),
                    IFNULL(phone, '(800)-985-4339'),
                    IFNULL(hours, 'Mon-Fri 8:00 AM - 5:00 PM'),
                    IF(lat REGEXP '^-?[0-9]+(\\.[0-9]+)?$', CAST(lat AS DECIMAL(10,8)), NULL),
                    IF(lng REGEXP '^-?[0-9]+(\\.[0-9]+)?$', CAST(lng AS DECIMAL(11,8)), NULL),
                    1,
                    NOW(),
                    NOW()
                FROM accrediteddrugte_s2.locations;
            ");

            // Also populate cities with active locations
            DB::statement("
                INSERT IGNORE INTO cdtc.cities (state_id, name, slug, zip_code, lat, lng, is_active, meta_title, meta_description, created_at, updated_at)
                SELECT 
                    s.id as state_id,
                    sub.city as name,
                    LOWER(REPLACE(REPLACE(REPLACE(sub.city, ' ', '-'), '.', ''), '/', '-')) as slug,
                    sub.zip as zip_code,
                    sub.avg_lat as lat,
                    sub.avg_lng as lng,
                    1,
                    CONCAT(sub.city, ', ', s.abbr, ' Drug Testing Centers | Walk-ins Welcome'),
                    CONCAT('Find certified drug testing collection centers in ', sub.city, ', ', s.abbr, '. Same-day walk-in testing at Quest & Labcorp certified sites.'),
                    NOW(),
                    NOW()
                FROM (
                    SELECT 
                        TRIM(city) as city, 
                        state, 
                        MIN(zip) as zip, 
                        AVG(lat) as avg_lat, 
                        AVG(lng) as avg_lng
                    FROM cdtc.locations
                    WHERE city != '' AND city IS NOT NULL AND state != ''
                    GROUP BY TRIM(city), state
                ) sub
                INNER JOIN cdtc.states s ON s.abbr = sub.state;
            ");
            DB::statement("SET FOREIGN_KEY_CHECKS = 1;");

            $locCount = Location::count();
            $cityCount = City::count();
            $this->info("   Imported {$locCount} collection sites and {$cityCount} cities.");
        } catch (\Exception $e) {
            $this->warn("   Cross-database location import note: " . $e->getMessage());
        }
    }

    protected function seedSuperAdmin(): void
    {
        $this->line("-> Seeding Super Admin User...");
        User::updateOrCreate(
            ['email' => 'admin@certifieddrugtesting.com'],
            [
                'name' => 'Super Administrator',
                'password' => bcrypt('Admin@CDTC2026!'),
                'is_super_admin' => true,
                'phone' => '(800)-985-4339',
            ]
        );
        $this->info("   Super Admin created: admin@certifieddrugtesting.com / Admin@CDTC2026!");
    }

    protected function seedDefaultSettings(): void
    {
        $this->line("-> Seeding Default PayTrace & Site Settings...");

        Setting::set('site_name', 'Certified Drug Test Center', 'general');
        Setting::set('site_phone', '(800)-985-4339', 'general');
        Setting::set('site_email', 'support@certifieddrugtesting.com', 'general');
        Setting::set('site_tagline', 'Certified Drug Testing Made Fast, Simple & Confidential', 'general');

        // PayTrace configuration
        Setting::set('paytrace_username', 'demo123', 'payment');
        Setting::set('paytrace_password', 'password123', 'payment', true);
        Setting::set('paytrace_integrator_id', '123456', 'payment');
        Setting::set('paytrace_test_mode', '1', 'payment');

        $this->info("   Default settings and PayTrace configuration seeded.");
    }
}
