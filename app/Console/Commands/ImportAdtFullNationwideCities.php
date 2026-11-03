<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Location;
use App\Models\State;
use App\Services\SlugTransliterator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportAdtFullNationwideCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cdtc:import-full-cities {--fresh : Truncate and freshly re-import all cities}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import full 41,000+ nationwide cities and collection sites from ADT source database into CDTC';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info("Starting Full Nationwide Cities & Locations Import from adt_source...");

        try {
            DB::connection('adt_source')->getPdo();
        } catch (\Throwable $e) {
            $this->error("Cannot connect to adt_source: " . $e->getMessage());
            return Command::FAILURE;
        }

        // 1. Ensure all 51 States are populated and enriched with statutory laws & FAQs
        $this->syncStateCompliance();

        // 2. Import extra collection sites from labcorp_quest into locations table
        $this->syncLocations();

        // 3. Import all 37,363 cities from 1us_cities_done
        $this->importCitiesDone();

        // 4. Import additional unique towns from 1us_zipcodes_done (~5,700 additional towns)
        $this->importZipcodeTowns();

        $totalCities = City::count();
        $totalLocations = Location::count();

        $this->info("Import completed successfully!");
        $this->table(
            ['Entity', 'Count in CDTC'],
            [
                ['States', State::count()],
                ['Total Cities & Towns', number_format($totalCities)],
                ['Active Collection Sites', number_format($totalLocations)],
            ]
        );

        $this->newLine();
        $this->info("Now running pseo:compute-eligible-cities to re-evaluate 35-mile radius across all ~" . number_format($totalCities) . " cities...");
        $this->call('pseo:compute-eligible-cities');

        return Command::SUCCESS;
    }

    /**
     * Synchronize state compliance and statutory FAQs from ADT source.
     */
    protected function syncStateCompliance(): void
    {
        $this->line("-> Syncing State compliance laws and FAQs...");

        $laws = DB::table('accrediteddrugte_s2.state_compliance_laws')->get()->keyBy('state_abbr');
        $faqs = DB::table('accrediteddrugte_s2.state_faqs')
            ->orderBy('state_code')
            ->orderBy('display_order')
            ->get()
            ->groupBy('state_code');

        $states = State::all();
        foreach ($states as $st) {
            $abbr = strtoupper($st->abbr);
            $law = $laws->get($abbr);
            $stateFaqs = $faqs->get($abbr, collect())->map(function ($f) {
                return [
                    'question' => $f->question,
                    'answer' => $f->answer,
                ];
            })->toArray();

            $update = [];
            if ($law) {
                $update['statute_code'] = $law->statute_code;
                $update['medical_marijuana_status'] = $law->medical_marijuana_status;
                $update['recreational_marijuana_status'] = $law->recreational_marijuana_status;
                $update['employer_rights_summary'] = $law->employer_rights_summary;
                if (!empty($law->worker_comp_rules)) {
                    $update['worker_comp_rules'] = $law->worker_comp_rules;
                }
            }

            if (!empty($stateFaqs)) {
                $update['faqs_json'] = $stateFaqs;
            }

            if (!empty($update)) {
                $st->update($update);
            }
        }

        $this->info("   Synchronized 51 states with statutory compliance and legal FAQs.");
    }

    /**
     * Synchronize collection sites from labcorp_quest into locations table.
     */
    protected function syncLocations(): void
    {
        $this->line("-> Enriching locations from labcorp_quest...");

        // Insert collection sites from labcorp_quest that do not exist yet
        DB::statement("
            INSERT IGNORE INTO cdtc.locations (name, provider, address1, city, state, zip, phone, hours, lat, lng, is_active, created_at, updated_at)
            SELECT 
                lq.name,
                IF(LOWER(lq.name) LIKE '%quest%', 'quest', 'labcorp') as provider,
                lq.address as address1,
                lq.city,
                lq.state,
                lq.zipcode as zip,
                '(800)-985-4339' as phone,
                IFNULL(lq.hours, 'Mon-Fri 8:00 AM - 5:00 PM') as hours,
                lq.latitude as lat,
                lq.longitude as lng,
                1 as is_active,
                NOW() as created_at,
                NOW() as updated_at
            FROM accrediteddrugte_s2.labcorp_quest lq
            WHERE lq.latitude IS NOT NULL 
              AND lq.longitude IS NOT NULL
              AND NOT EXISTS (
                  SELECT 1 FROM cdtc.locations loc 
                  WHERE loc.state = lq.state 
                    AND loc.city = lq.city 
                    AND (loc.address1 = lq.address OR loc.zip = lq.zipcode)
              );
        ");

        $totalLocations = Location::where('is_active', true)->count();
        $this->info("   Active verified locations in database: " . number_format($totalLocations));
    }

    /**
     * Import all 37,000+ cities from 1us_cities_done.
     */
    protected function importCitiesDone(): void
    {
        $this->line("-> Importing ~37,000+ cities from 1us_cities_done with coordinates and census descriptions...");

        // Direct high-performance batch insert via SQL join
        DB::statement("
            INSERT INTO cdtc.cities (state_id, name, slug, zip_code, lat, lng, content, is_active, meta_title, meta_description, created_at, updated_at)
            SELECT 
                s.id as state_id,
                sub.city_name as name,
                sub.city_url as slug,
                sub.zip as zip_code,
                sub.lat,
                sub.lng,
                sub.content,
                1 as is_active,
                CONCAT(sub.city_name, ', ', s.abbr, ' Drug Testing Centers | Walk-ins Welcome') as meta_title,
                CONCAT('Find certified drug testing collection centers in ', sub.city_name, ', ', s.abbr, '. Same-day walk-in testing at Quest & Labcorp certified sites.') as meta_description,
                NOW() as created_at,
                NOW() as updated_at
            FROM (
                SELECT 
                    c.city_name,
                    c.state_abbr,
                    c.city_url,
                    IFNULL(c.paragraph_0, '') as content,
                    MIN(z.zip) as zip,
                    AVG(z.lat) as lat,
                    AVG(z.lon) as lng
                FROM accrediteddrugte_s2.1us_cities_done c
                LEFT JOIN accrediteddrugte_s2.1us_zipcodes_done z 
                    ON c.city_name = z.city AND c.state_abbr = z.state_abbrv
                GROUP BY c.id, c.city_name, c.state_abbr, c.city_url, c.paragraph_0
            ) sub
            INNER JOIN cdtc.states s ON s.abbr = sub.state_abbr
            WHERE NOT EXISTS (
                SELECT 1 FROM cdtc.cities existing 
                WHERE existing.state_id = s.id AND existing.slug = sub.city_url
            );
        ");

        $count = City::count();
        $this->info("   Cities after 1us_cities_done import: " . number_format($count));
    }

    /**
     * Import additional unique municipalities from 1us_zipcodes_done.
     */
    protected function importZipcodeTowns(): void
    {
        $this->line("-> Incorporating additional distinct towns from 1us_zipcodes_done...");

        DB::statement("
            INSERT INTO cdtc.cities (state_id, name, slug, zip_code, lat, lng, is_active, meta_title, meta_description, created_at, updated_at)
            SELECT 
                s.id as state_id,
                sub.city as name,
                LOWER(REPLACE(REPLACE(REPLACE(sub.city, ' ', '-'), '.', ''), '/', '-')) as slug,
                sub.zip as zip_code,
                sub.lat,
                sub.lon as lng,
                1 as is_active,
                CONCAT(sub.city, ', ', s.abbr, ' Drug Testing Centers | Walk-ins Welcome') as meta_title,
                CONCAT('Find certified drug testing collection centers in ', sub.city, ', ', s.abbr, '. Same-day walk-in testing at Quest & Labcorp certified sites.') as meta_description,
                NOW() as created_at,
                NOW() as updated_at
            FROM (
                SELECT 
                    z.city,
                    z.state_abbrv,
                    MIN(z.zip) as zip,
                    AVG(z.lat) as lat,
                    AVG(z.lon) as lon
                FROM accrediteddrugte_s2.1us_zipcodes_done z
                GROUP BY z.city, z.state_abbrv
            ) sub
            INNER JOIN cdtc.states s ON s.abbr = sub.state_abbrv
            WHERE NOT EXISTS (
                SELECT 1 FROM cdtc.cities existing 
                WHERE existing.state_id = s.id 
                  AND (existing.name = sub.city OR existing.slug = LOWER(REPLACE(REPLACE(REPLACE(sub.city, ' ', '-'), '.', ''), '/', '-')))
            );
        ");

        $count = City::count();
        $this->info("   Total cities after zipcode towns incorporation: " . number_format($count));
    }
}
