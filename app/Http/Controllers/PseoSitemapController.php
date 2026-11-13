<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\PseoEligibleCity;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PseoSitemapController extends Controller
{
    /**
     * Map numeric chain IDs (1-9) to service slug.
     */
    protected const CHAIN_MAP = [
        1 => '5-panel-drug-test',
        2 => '10-panel-drug-test',
        3 => 'dot-drug-test',
        4 => 'hair-follicle-drug-test',
        5 => 'breath-alcohol-test',
        6 => '12-panel-drug-test',
        7 => 'instant-drug-test',
        8 => 'court-ordered-drug-test',
        9 => 'random-drug-testing',
    ];

    /**
     * Generate individual chain sitemap: /sitemap-chain{id}.xml
     * Strictly bounded to <= 50,000 URLs and only eligible cities with >=1 clinic within 35 miles.
     */
    public function chain(int $id): Response
    {
        $serviceSlug = self::CHAIN_MAP[$id] ?? null;
        if (!$serviceSlug) {
            abort(404);
        }

        $now = now()->toAtomString();

        // 1. Service Root Node
        $urls = [
            [
                'loc' => rtrim(url("/services/{$serviceSlug}"), '/'),
                'lastmod' => $now,
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ],
        ];

        // 2. State Hub Nodes (51 States)
        $states = State::where('is_active', true)->orderBy('name')->get();
        foreach ($states as $state) {
            $urls[] = [
                'loc' => rtrim(url("/services/{$serviceSlug}/{$state->slug}"), '/'),
                'lastmod' => $now,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // 3. Eligible City Nodes (Only municipalities with >=1 clinic within 35 miles)
        $cities = City::join('pseo_eligible_cities', 'cities.id', '=', 'pseo_eligible_cities.city_id')
            ->join('states', 'cities.state_id', '=', 'states.id')
            ->where('cities.is_active', true)
            ->where('states.is_active', true)
            ->where('pseo_eligible_cities.is_eligible', true)
            ->select('cities.slug as city_slug', 'states.slug as state_slug', 'cities.updated_at')
            ->orderBy('states.name')
            ->orderBy('cities.name')
            ->get();

        foreach ($cities as $city) {
            $urls[] = [
                'loc' => rtrim(url("/services/{$serviceSlug}/{$city->state_slug}/{$city->city_slug}"), '/'),
                'lastmod' => $city->updated_at ? $city->updated_at->toAtomString() : $now,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // Render compliant XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($u['loc'], ENT_XML1, 'UTF-8') . "</loc>\n";
            $xml .= "    <lastmod>{$u['lastmod']}</lastmod>\n";
            $xml .= "    <changefreq>{$u['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$u['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    /**
     * Master Sitemap Index: /sitemap-index.xml
     * Lists all 9 segmented chain sitemaps.
     */
    public function index(): Response
    {
        $now = now()->toAtomString();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        for ($i = 1; $i <= 9; $i++) {
            $chainXmlUrl = url("/sitemap-chain{$i}.xml");
            $xml .= "  <sitemap>\n";
            $xml .= "    <loc>" . htmlspecialchars($chainXmlUrl, ENT_XML1, 'UTF-8') . "</loc>\n";
            $xml .= "    <lastmod>{$now}</lastmod>\n";
            $xml .= "  </sitemap>\n";
        }

        $xml .= '</sitemapindex>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
