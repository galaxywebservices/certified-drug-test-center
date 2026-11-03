<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\PseoEligibleCity;
use App\Services\GeoLocationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ComputeEligiblePseoCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pseo:compute-eligible-cities {--force : Recompute all cities without using cached entries}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pre-calculate and populate the pseo_eligible_cities table with 35-mile radius guardrails';

    /**
     * Execute the console command.
     */
    public function handle(GeoLocationService $geo): int
    {
        ini_set('memory_limit', '1024M');
        DB::disableQueryLog();

        $this->info('Starting programmatic SEO eligible cities computation (35-mile radius)...');

        $total = City::count();
        $this->info("Evaluating {$total} total cities in database...");

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $cities = City::with('state')->orderBy('id')->lazy(500);

        $eligibleCount = 0;
        $ineligibleCount = 0;

        $batch = [];
        $now = now();

        foreach ($cities as $city) {
            $locations = $geo->getNearestLocationsForCity($city, 35.0, 10);
            $count = $locations->count();
            $nearest = $count > 0 ? (float) ($locations->first()->distance_miles ?? 0.5) : null;
            $isEligible = ($count >= 1);

            if ($isEligible) {
                $eligibleCount++;
            } else {
                $ineligibleCount++;
            }

            $batch[] = [
                'city_id' => $city->id,
                'state_id' => $city->state_id,
                'active_centers_count' => $count,
                'nearest_distance' => $nearest,
                'is_eligible' => $isEligible,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (count($batch) >= 250) {
                DB::table('pseo_eligible_cities')->upsert(
                    $batch,
                    ['city_id'],
                    ['state_id', 'active_centers_count', 'nearest_distance', 'is_eligible', 'updated_at']
                );
                $batch = [];
            }

            $bar->advance();
        }

        if (!empty($batch)) {
            DB::table('pseo_eligible_cities')->upsert(
                $batch,
                ['city_id'],
                ['state_id', 'active_centers_count', 'nearest_distance', 'is_eligible', 'updated_at']
            );
        }

        $bar->finish();
        $this->newLine(2);

        $this->table(
            ['Metric', 'Count', 'Percentage'],
            [
                ['Total Cities Evaluated', number_format($total), '100%'],
                ['Eligible (≥1 Center within 35 miles)', number_format($eligibleCount), round(($eligibleCount / max(1, $total)) * 100, 1) . '%'],
                ['Suppressed (0 Centers - Doorway Protection)', number_format($ineligibleCount), round(($ineligibleCount / max(1, $total)) * 100, 1) . '%'],
            ]
        );

        $this->info('Pre-calculation complete. pseo_eligible_cities table populated successfully.');

        return Command::SUCCESS;
    }
}
