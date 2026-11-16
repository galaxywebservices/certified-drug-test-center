<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        @ini_set('memory_limit', '512M');
        DB::disableQueryLog();

        // 1. Fix FAQ #1 Grammar for Oregon in states table
        $orState = DB::table('states')->where('abbr', 'OR')->first();
        if ($orState && !empty($orState->faqs_json)) {
            $faqs = json_decode($orState->faqs_json, true);
            if (is_array($faqs)) {
                $modified = false;
                foreach ($faqs as &$f) {
                    if (isset($f['answer']) && str_contains($f['answer'], 'operate under a Oregon')) {
                        $f['answer'] = str_replace(
                            'operate under a Oregon Revised Statutes',
                            'operate under the Oregon Revised Statutes',
                            $f['answer']
                        );
                        $f['answer'] = str_replace(
                            'operate under a Oregon',
                            'operate under the Oregon',
                            $f['answer']
                        );
                        $modified = true;
                    }
                }
                if ($modified) {
                    DB::table('states')->where('id', $orState->id)->update([
                        'faqs_json' => json_encode($faqs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                    ]);
                }
            }
        }

        // 2. Sanitize any mismatched city names inside pseo_city_contents
        if (Schema::hasTable('pseo_city_contents')) {
            $statesRegex = 'AL|AK|AZ|AR|CA|CO|CT|DE|FL|GA|HI|ID|IL|IN|IA|KS|KY|LA|ME|MD|MA|MI|MN|MS|MO|MT|NE|NV|NH|NJ|NM|NY|NC|ND|OH|OK|OR|PA|RI|SC|SD|TN|TX|UT|VT|VA|WA|WV|WI|WY';
            $pattern = "/\\b(In\\s+|in\\s+|Across\\s+|across\\s+|Throughout\\s+|throughout\\s+|Around\\s+|around\\s+|Near\\s+|near\\s+|For\\s+|for\\s+)?([A-Z][a-zA-Z\\.\\x27-]+(?:\\s+[A-Z][a-zA-Z\\.\\x27-]+){0,2}),\\s*({$statesRegex})\\b/u";

            DB::table('pseo_city_contents as p')
                ->join('cities as c', 'c.id', '=', 'p.city_id')
                ->join('states as s', 's.id', '=', 'c.state_id')
                ->select(
                    'p.id',
                    'c.name as city_name',
                    's.abbr as state_abbr',
                    'p.gpt_5panel',
                    'p.gpt_10panel',
                    'p.gpt_dot',
                    'p.gpt_hair',
                    'p.gpt_alcohol',
                    'p.gpt_services',
                    'p.gpt_consortium'
                )
                ->chunkById(250, function ($rows) use ($pattern) {
                    foreach ($rows as $row) {
                        $cityName = $row->city_name;
                        $stateAbbr = $row->state_abbr;
                        $updates = [];

                        $fields = ['gpt_5panel', 'gpt_10panel', 'gpt_dot', 'gpt_hair', 'gpt_alcohol', 'gpt_services', 'gpt_consortium'];
                        foreach ($fields as $field) {
                            $val = $row->{$field};
                            if (!empty($val) && !str_contains($val, $cityName)) {
                                $updates[$field] = preg_replace_callback(
                                    $pattern,
                                    function ($m) use ($cityName, $stateAbbr) {
                                        $prefix = $m[1] ?? '';
                                        return $prefix . $cityName . ', ' . $stateAbbr;
                                    },
                                    $val
                                );
                            }
                        }

                        if (!empty($updates)) {
                            DB::table('pseo_city_contents')->where('id', $row->id)->update($updates);
                        }
                    }
                }, 'p.id', 'id');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Non-destructive data cleanup
    }
};
