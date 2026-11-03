<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\PseoCityContent;
use App\Models\State;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncPseoGptContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pseo:sync-gpt-content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync and brand-sanitize GPT content from citydata_gpt_lite into pseo_city_contents table';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(0);
        DB::disableQueryLog();

        $this->info("Starting GPT content synchronization from citydata_gpt_lite...");

        $total = DB::table('accrediteddrugte_s2.citydata_gpt_lite')->count();
        $this->info("Found {$total} rows in citydata_gpt_lite to process.");

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $chunkSize = 250;
        $processed = 0;

        DB::table('accrediteddrugte_s2.citydata_gpt_lite as g')
            ->join('accrediteddrugte_s2.citydata as cd', 'cd.id', '=', 'g.citydata_id')
            ->join('cdtc.states as s', 's.abbr', '=', 'cd.state_abbr')
            ->join('cdtc.cities as c', function ($join) {
                $join->on('c.state_id', '=', 's.id')
                     ->on('c.name', '=', 'cd.city_name');
            })
            ->select(
                'g.id as gpt_id',
                'c.id as city_id',
                'cd.county',
                'cd.population_real',
                'g.gpt_5panel_top_content',
                'g.gpt_10panel_top_content',
                'g.gpt_dot_top_content',
                'g.gpt_hair_top_content',
                'g.gpt_alcohol_top_content',
                'g.gpt_services_top_content',
                'g.gpt_consortium_top_content',
                'g.gpt_physical_top_content'
            )
            ->chunkById($chunkSize, function ($rows) use ($bar, &$processed) {
                $batch = [];
                $now = now();

                foreach ($rows as $row) {
                    $batch[] = [
                        'city_id' => $row->city_id,
                        'county' => $row->county,
                        'population' => !empty($row->population_real) ? (int) $row->population_real : null,
                        'gpt_5panel' => $this->sanitizeBrand($row->gpt_5panel_top_content),
                        'gpt_10panel' => $this->sanitizeBrand($row->gpt_10panel_top_content),
                        'gpt_dot' => $this->sanitizeBrand($row->gpt_dot_top_content),
                        'gpt_hair' => $this->sanitizeBrand($row->gpt_hair_top_content),
                        'gpt_alcohol' => $this->sanitizeBrand($row->gpt_alcohol_top_content),
                        'gpt_services' => $this->sanitizeBrand($row->gpt_services_top_content),
                        'gpt_consortium' => $this->sanitizeBrand($row->gpt_consortium_top_content),
                        'gpt_physical' => $this->sanitizeBrand($row->gpt_physical_top_content),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                DB::table('pseo_city_contents')->upsert(
                    $batch,
                    ['city_id'],
                    [
                        'county',
                        'population',
                        'gpt_5panel',
                        'gpt_10panel',
                        'gpt_dot',
                        'gpt_hair',
                        'gpt_alcohol',
                        'gpt_services',
                        'gpt_consortium',
                        'gpt_physical',
                        'updated_at',
                    ]
                );

                $count = count($rows);
                $processed += $count;
                $bar->advance($count);
            }, 'g.id', 'gpt_id');

        $bar->finish();
        $this->newLine(2);

        $inserted = PseoCityContent::count();
        $this->info("Successfully populated pseo_city_contents with {$inserted} unique city content records!");

        return Command::SUCCESS;
    }

    /**
     * Cleanse old brand references and phone numbers.
     */
    protected function sanitizeBrand(?string $text): ?string
    {
        if (empty($text)) {
            return null;
        }

        $replacements = [
            'Accredited Drug Testing Inc' => 'Certified Drug Test Centers',
            'Accredited Drug Testing' => 'Certified Drug Test Centers',
            'accredited drug testing' => 'certified drug testing',
            'ADT' => 'CDTC',
            '800-221-4291' => '1-800-985-4339',
            '(800) 221-4291' => '1-800-985-4339',
            '800-985-4339' => '1-800-985-4339',
            '(800)-985-4339' => '1-800-985-4339',
            'accrediteddrugtesting.com' => 'certifieddrugtestingcenters.com',
            'www.accrediteddrugtesting.com' => 'certifieddrugtestingcenters.com',
        ];

        return str_ireplace(array_keys($replacements), array_values($replacements), $text);
    }
}
