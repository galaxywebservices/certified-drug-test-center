<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\State;
use App\Models\City;

class ImportChainContentCommand extends Command
{
    protected $signature = 'app:import-chain-content';
    protected $description = 'Import 1,000 city unique chain contents from legacy database into cdtc.cities and backup to JSON for zero-dependency deployment';

    public function handle(): int
    {
        $this->info('Starting chain content migration from accrediteddrugte_s2.chains_unique...');

        $states = State::all()->keyBy(fn($s) => strtoupper(trim($s->abbr)));

        $rows = DB::select("SELECT chain_id, city_name, state_abbr, content FROM accrediteddrugte_s2.chains_unique WHERE chain_id = 'drug-testing-city-state'");

        $this->info("Found " . count($rows) . " city entries in chains_unique.");

        $matched = 0;
        $created = 0;
        $exportData = [];

        foreach ($rows as $row) {
            $abbr = strtoupper(trim($row->state_abbr));
            $cityName = trim($row->city_name);
            $slug = Str::slug($cityName);

            if (!isset($states[$abbr])) {
                continue;
            }

            $state = $states[$abbr];

            // Clean any legacy company name references in content if needed
            $content = str_replace(
                ['Accredited Drug Testing', 'accrediteddrugtesting.com', 'ADT'],
                ['Certified Drug Test Center', 'certifieddrugtestcenter.com', 'CDTC'],
                $row->content
            );

            $city = City::where('state_id', $state->id)
                ->where(function($q) use ($cityName, $slug) {
                    $q->where('name', $cityName)->orWhere('slug', $slug);
                })
                ->first();

            if ($city) {
                $city->update([
                    'content' => $content,
                ]);
                $matched++;
            } else {
                $city = City::create([
                    'state_id' => $state->id,
                    'name' => $cityName,
                    'slug' => $slug,
                    'is_active' => true,
                    'meta_title' => "{$cityName}, {$abbr} Drug Testing Centers | Walk-ins Welcome",
                    'meta_description' => "Find certified drug testing collection centers in {$cityName}, {$abbr}. Same-day walk-in testing at Quest & Labcorp certified sites.",
                    'content' => $content,
                ]);
                $created++;
            }

            $exportData[] = [
                'state_abbr' => $abbr,
                'city_name' => $cityName,
                'slug' => $slug,
                'content' => $content,
            ];
        }

        $this->info("Import finished: Updated {$matched} existing cities, Created {$created} missing cities.");

        // Save JSON file for zero-dependency deploy and seed
        $dataPath = database_path('seeders/data');
        if (!is_dir($dataPath)) {
            mkdir($dataPath, 0755, true);
        }

        file_put_contents($dataPath . '/chains_unique_cities.json', json_encode($exportData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $this->info("Exported JSON snapshot to database/seeders/data/chains_unique_cities.json (" . count($exportData) . " entries)");

        return Command::SUCCESS;
    }
}
