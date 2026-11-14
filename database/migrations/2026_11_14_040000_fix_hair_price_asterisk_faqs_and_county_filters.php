<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Align 5 Panel Hair Follicle Test price from $189.99 to canonical $169.99
        DB::table('products')
            ->where('slug', '5-panel-hair-follicle')
            ->update(['price' => 169.99]);

        // 2. Strip leading asterisk from "*10 Panel Rapid Results" and any other product names
        $starredProducts = DB::table('products')->where('name', 'LIKE', '*%')->get();
        foreach ($starredProducts as $p) {
            DB::table('products')
                ->where('id', $p->id)
                ->update(['name' => ltrim($p->name, '* ')]);
        }

        // 3. Clean up grammar, punctuation, and pluralization in state legal FAQs
        $states = DB::table('states')->whereNotNull('faqs_json')->get();
        foreach ($states as $state) {
            $faqs = json_decode($state->faqs_json, true);
            if (!is_array($faqs)) {
                continue;
            }

            $modified = false;
            foreach ($faqs as &$faq) {
                if (isset($faq['answer'])) {
                    $origAnswer = $faq['answer'];

                    // Fix double period after et seq..
                    $faq['answer'] = str_replace('et seq..', 'et seq.', $faq['answer']);

                    // Fix subject-verb agreement: statutes protects -> statutes protect
                    $faq['answer'] = str_replace('statutes protects', 'statutes protect', $faq['answer']);
                    $faq['answer'] = str_replace('statute protect ', 'statute protects ', $faq['answer']);

                    // Fix pluralization of Certified Drug Test Centers
                    $faq['answer'] = str_replace('Certified Drug Test Center provides', 'Certified Drug Test Centers provide', $faq['answer']);
                    $faq['answer'] = str_replace('Certified Drug Test Center offers', 'Certified Drug Test Centers offer', $faq['answer']);
                    $faq['answer'] = str_replace('Certified Drug Test Center is', 'Certified Drug Test Centers is', $faq['answer']);
                    $faq['answer'] = str_replace('Certified Drug Test Center has', 'Certified Drug Test Centers have', $faq['answer']);
                    $faq['answer'] = str_replace('Certified Drug Test Center', 'Certified Drug Test Centers', $faq['answer']);

                    // Fix any accidental double "Centerss"
                    $faq['answer'] = str_replace('Certified Drug Test Centerss', 'Certified Drug Test Centers', $faq['answer']);

                    if ($faq['answer'] !== $origAnswer) {
                        $modified = true;
                    }
                }

                if (isset($faq['question'])) {
                    $origQuestion = $faq['question'];
                    $faq['question'] = str_replace('Certified Drug Test Center', 'Certified Drug Test Centers', $faq['question']);
                    $faq['question'] = str_replace('Certified Drug Test Centerss', 'Certified Drug Test Centers', $faq['question']);
                    if ($faq['question'] !== $origQuestion) {
                        $modified = true;
                    }
                }
            }
            unset($faq);

            if ($modified) {
                DB::table('states')
                    ->where('id', $state->id)
                    ->update(['faqs_json' => json_encode($faqs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)]);
            }
        }

        // 4. Fix dead "#" anchor links and brand pluralization in city guides
        DB::table('cities')
            ->whereNotNull('content')
            ->where('content', 'LIKE', '%#%')
            ->chunkById(100, function ($cities) {
                foreach ($cities as $city) {
                    $updatedContent = str_replace(
                        [
                            '<a href="#">Open your account today</a>',
                            '<a href="#">',
                            'href="#"',
                            'Certified Drug Test Center',
                        ],
                        [
                            '<a href="/employers">Open your account today</a>',
                            '<a href="/employers">',
                            'href="/employers"',
                            'Certified Drug Test Centers',
                        ],
                        $city->content
                    );

                    $updatedContent = str_replace('Certified Drug Test Centerss', 'Certified Drug Test Centers', $updatedContent);

                    if ($updatedContent !== $city->content) {
                        DB::table('cities')
                            ->where('id', $city->id)
                            ->update(['content' => $updatedContent]);
                    }
                }
            });

        // 5. Deactivate non-municipal county entities with zero locations (Coconino, North Pinal, etc.)
        DB::table('cities')
            ->whereIn('slug', ['coconino', 'north-pinal'])
            ->update(['is_active' => false]);

        DB::table('pseo_eligible_cities')
            ->whereIn('city_id', function ($query) {
                $query->select('id')->from('cities')->whereIn('slug', ['coconino', 'north-pinal']);
            })
            ->update(['is_eligible' => false]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reversal if needed
    }
};
