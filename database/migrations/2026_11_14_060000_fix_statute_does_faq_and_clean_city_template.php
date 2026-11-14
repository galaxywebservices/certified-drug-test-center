<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix FAQ grammar in states table (statutes does -> statute does)
        $states = DB::table('states')->get();
        foreach ($states as $state) {
            $faqs = json_decode($state->faqs_json, true);
            $dirty = false;

            if (is_array($faqs)) {
                foreach ($faqs as &$faq) {
                    if (isset($faq['answer']) && str_contains($faq['answer'], 'statutes does')) {
                        $faq['answer'] = str_replace('statutes does', 'statute does', $faq['answer']);
                        $dirty = true;
                    }
                }
                unset($faq);
            }

            if ($dirty) {
                DB::table('states')->where('id', $state->id)->update([
                    'faqs_json' => json_encode($faqs),
                ]);
            }
        }

        // Clear view cache
        try {
            Artisan::call('view:clear');
        } catch (\Throwable $e) {
            // Ignore if in container without console
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe irreversible grammar fix
    }
};
