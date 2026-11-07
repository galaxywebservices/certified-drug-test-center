<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class ChainController extends Controller
{
    /**
     * Nationalize Page for Certified Drug Test Centers (/certified-drug-test-centers)
     */
    public function certifiedDrugTestCenters(Request $request)
    {
        // 50 US States with accurate center counts
        $stateCounts = [
            'alabama' => '340+ centers',
            'alaska' => '85+ centers',
            'arizona' => '420+ centers',
            'arkansas' => '210+ centers',
            'california' => '1,950+ centers',
            'colorado' => '380+ centers',
            'connecticut' => '240+ centers',
            'delaware' => '95+ centers',
            'florida' => '1,420+ centers',
            'georgia' => '760+ centers',
            'hawaii' => '90+ centers',
            'idaho' => '140+ centers',
            'illinois' => '890+ centers',
            'indiana' => '480+ centers',
            'iowa' => '260+ centers',
            'kansas' => '220+ centers',
            'kentucky' => '310+ centers',
            'louisiana' => '390+ centers',
            'maine' => '110+ centers',
            'maryland' => '410+ centers',
            'massachusetts' => '490+ centers',
            'michigan' => '690+ centers',
            'minnesota' => '380+ centers',
            'mississippi' => '230+ centers',
            'missouri' => '440+ centers',
            'montana' => '110+ centers',
            'nebraska' => '160+ centers',
            'nevada' => '240+ centers',
            'new-hampshire' => '130+ centers',
            'new-jersey' => '670+ centers',
            'new-mexico' => '180+ centers',
            'new-york' => '1,380+ centers',
            'north-carolina' => '710+ centers',
            'north-dakota' => '95+ centers',
            'ohio' => '840+ centers',
            'oklahoma' => '320+ centers',
            'oregon' => '290+ centers',
            'pennsylvania' => '920+ centers',
            'rhode-island' => '85+ centers',
            'south-carolina' => '380+ centers',
            'south-dakota' => '90+ centers',
            'tennessee' => '540+ centers',
            'texas' => '1,890+ centers',
            'utah' => '220+ centers',
            'vermont' => '75+ centers',
            'virginia' => '590+ centers',
            'washington' => '520+ centers',
            'west-virginia' => '170+ centers',
            'wisconsin' => '430+ centers',
            'wyoming' => '80+ centers',
        ];

        $states = State::where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(function ($st) use ($stateCounts) {
                return [
                    'name' => $st->name,
                    'slug' => $st->slug,
                    'abbr' => $st->abbr,
                    'centers' => $stateCounts[$st->slug] ?? '150+ centers',
                    'url' => url('/locations/' . $st->slug),
                    'chain_url' => url('/certified-drug-test-centers/' . $st->slug),
                ];
            });

        $pageTitle = 'Certified Drug Test Centers Near You | 800-985-4339';
        $metaDescription = 'Certified Drug Test Centers are located in all cities and in most cases within minutes of your home or office. Order a drug or alcohol test online or call and receive an electronic donor pass via email or text immediately. Same-day testing available for employment, DOT, probation and personal purposes at more than 20,000 certified drug testing centers — including Quest Diagnostics, Labcorp and affiliated locations. Negative results are typically available within 24–48 hours.';
        $metaKeywords = 'Drug Test near me, DOT Drug Test near me, Alcohol test near me, Drug Testing, Drug testing center near me, employer drug testing programs, 5 panel urine test, 5 panel drug test, 10 panel drug test, DOT consortium Enrollment, where can i get a drug test, Hair drug test';
        $canonicalUrl = rtrim(url('/certified-drug-test-centers'), '/');

        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Certified Drug Test Centers', 'url' => $canonicalUrl],
        ];

        // Load structured data graph
        $schemaGraph = null;
        $jsonPath = resource_path('schemas/certified-drug-test-centers.json');
        if (file_exists($jsonPath)) {
            $raw = file_get_contents($jsonPath);
            $raw = str_replace(
                [
                    'https://certifieddrugtestingcenters.com/drug-testing-centers',
                    'https://certifieddrugtestingcenters.com/demo/certified-drug-test-centers',
                    'https://certifieddrugtestingcenters.com',
                ],
                [
                    $canonicalUrl,
                    $canonicalUrl,
                    url('/'),
                ],
                $raw
            );
            $schemaGraph = json_decode($raw, true);
        }

        return view('chains.certified-drug-test-centers', compact(
            'states',
            'pageTitle',
            'metaDescription',
            'metaKeywords',
            'canonicalUrl',
            'breadcrumbs',
            'schemaGraph'
        ));
    }
}
