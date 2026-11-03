<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Location;
use App\Models\Product;
use App\Models\PseoEligibleCity;
use App\Models\State;
use App\Services\GeoLocationService;
use App\Services\SlugTransliterator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PseoServiceController extends Controller
{
    /**
     * The 9 Core Programmatic Service Chains with medical specifications and mapping.
     */
    public const CHAINS = [
        '5-panel-drug-test' => [
            'id' => 1,
            'slug' => '5-panel-drug-test',
            'name' => '5-Panel Drug Test',
            'full_title' => '5-Panel Urine Drug Test',
            'short_name' => '5-Panel Test',
            'specimen' => 'Urine',
            'turnaround' => '24–48 Business Hours',
            'default_price' => 89.99,
            'product_slug' => '5-panel-nondot',
            'substances' => [
                'Marijuana (THC metabolites)',
                'Cocaine (Benzoylecgonine)',
                'Basic Opiates (Codeine, Morphine, 6-AM Heroin)',
                'Amphetamines (d-Amphetamine, Methamphetamine, MDMA/Ecstasy)',
                'Phencyclidine (PCP)',
            ],
            'meta_description_template' => 'Same-day 5-panel drug testing in :city, :state. Walk into local Quest Diagnostics and Labcorp certified collection facilities. Fast, SAMHSA-certified, MRO-reviewed results.',
            'headline_template' => '5-Panel Drug Testing Centers in :city, :state',
            'description' => 'The 5-panel urine drug test is the gold standard for employment, court compliance, and personal verification. Processed at SAMHSA-certified laboratories with GC/MS and LC/MS confirmation testing, supervised by a licensed Medical Review Officer (MRO).',
        ],
        '10-panel-drug-test' => [
            'id' => 2,
            'slug' => '10-panel-drug-test',
            'name' => '10-Panel Drug Test',
            'full_title' => '10-Panel Comprehensive Urine Drug Screen',
            'short_name' => '10-Panel Test',
            'specimen' => 'Urine',
            'turnaround' => '24–48 Business Hours',
            'default_price' => 109.99,
            'product_slug' => '10-panel',
            'substances' => [
                'Marijuana (THC)',
                'Cocaine (COC)',
                'Opiates (Codeine, Morphine, Heroin)',
                'Amphetamines & Methamphetamines',
                'Phencyclidine (PCP)',
                'Benzodiazepines (Xanax, Valium)',
                'Barbiturates',
                'Methadone',
                'Propoxyphene',
                'Methaqualone (Quaaludes)',
            ],
            'meta_description_template' => 'Accredited 10-panel drug test in :city, :state. Walk-in same-day urine collection at certified Quest & Labcorp sites. MRO-reviewed laboratory results in 24–48 hours.',
            'headline_template' => '10-Panel Drug Screening in :city, :state',
            'description' => 'Comprehensive 10-panel drug screening detecting standard recreational drugs plus prescription narcotics, sedatives, and opioids. Frequently mandated for healthcare personnel, law enforcement, corporate hiring, and legal proceedings.',
        ],
        '12-panel-drug-test' => [
            'id' => 3,
            'slug' => '12-panel-drug-test',
            'name' => '12-Panel Drug Test',
            'full_title' => '12-Panel Expanded Urine Drug Test',
            'short_name' => '12-Panel Test',
            'specimen' => 'Urine',
            'turnaround' => '24–48 Business Hours',
            'default_price' => 139.99,
            'product_slug' => '12-panel-comprehensive',
            'substances' => [
                'Marijuana (THC)',
                'Cocaine',
                'Basic Opiates',
                'Amphetamines',
                'Phencyclidine (PCP)',
                'Benzodiazepines',
                'Barbiturates',
                'Methadone',
                'Propoxyphene',
                'Oxycodone / Oxymorphone',
                'Buprenorphine (Suboxone)',
                'MDMA / Ecstasy',
            ],
            'meta_description_template' => 'Get an expanded 12-panel drug test in :city, :state. Walk in today at Quest Diagnostics & Labcorp collection centers. Includes Oxycodone, Suboxone & prescription narcotics.',
            'headline_template' => '12-Panel Comprehensive Drug Testing in :city, :state',
            'description' => 'The ultimate comprehensive screening panel. Evaluates illicit substances alongside semi-synthetic prescription opioids (Oxycodone, Oxymorphone, Hydrocodone) and Buprenorphine. Ideal for medical licensing, executive screening, and rigorous legal oversight.',
        ],
        'dot-drug-test' => [
            'id' => 4,
            'slug' => 'dot-drug-test',
            'name' => 'DOT Drug Test',
            'full_title' => 'DOT 5-Panel Federal Drug Screen',
            'short_name' => 'DOT Test',
            'specimen' => 'Urine (Federal Split Specimen)',
            'turnaround' => '24–48 Business Hours',
            'default_price' => 99.99,
            'product_slug' => '5-panel-dot',
            'substances' => [
                'Marijuana Metabolites (THC-COOH)',
                'Cocaine Metabolites',
                'Semi-Synthetic Opioids (Codeine, Morphine, 6-AM, Hydrocodone, Hydromorphone, Oxycodone, Oxymorphone)',
                'Amphetamines (Methamphetamine, MDMA, MDA)',
                'Phencyclidine (PCP)',
            ],
            'meta_description_template' => 'DOT drug testing in :city, :state for FMCSA, FAA, FRA, FTA, PHMSA & USCG. Federal CCF, split specimen testing & certified MRO review at local Quest & Labcorp sites.',
            'headline_template' => 'DOT Drug Testing & Compliance in :city, :state',
            'description' => '49 CFR Part 40 compliant federal drug screening for commercial motor carriers (FMCSA), maritime captains (USCG), aviation crew (FAA), and transit workers. Includes Federal Custody and Control Form (CCF) handling and instant Clearinghouse reporting.',
        ],
        'hair-follicle-drug-test' => [
            'id' => 5,
            'slug' => 'hair-follicle-drug-test',
            'name' => 'Hair Follicle Drug Test',
            'full_title' => 'Hair Follicle Drug Test (90-Day Detection)',
            'short_name' => 'Hair Follicle Test',
            'specimen' => 'Head or Body Hair Specimen',
            'turnaround' => '3–5 Business Days',
            'default_price' => 189.99,
            'product_slug' => '5-panel-hair-follicle',
            'substances' => [
                'Marijuana (THC metabolite)',
                'Cocaine (Cocaine & Benzoylecgonine)',
                'Opiates (Codeine, Morphine, 6-MAM Heroin)',
                'Amphetamines (Methamphetamine, MDMA/MDA)',
                'Phencyclidine (PCP)',
            ],
            'meta_description_template' => 'Accredited 90-day hair follicle drug testing in :city, :state. Long-term substance detection with tamper-resistant collection at certified local facilities.',
            'headline_template' => 'Hair Follicle Drug Testing in :city, :state',
            'description' => 'Unsurpassed 90-day detection window. Hair follicle testing cannot be cleansed, masked, or diluted by external detox shampoos or temporary abstinence. Mandated for child custody battles, court orders, and transportation executives.',
        ],
        'breath-alcohol-test' => [
            'id' => 6,
            'slug' => 'breath-alcohol-test',
            'name' => 'Breath Alcohol Test',
            'full_title' => 'Breath Alcohol Test (BAT) & Evidential Screening',
            'short_name' => 'Breath Alcohol',
            'specimen' => 'Evidential Breath Sample (EBT)',
            'turnaround' => 'Immediate / Instant Results',
            'default_price' => 89.99,
            'product_slug' => 'breath-alcohol',
            'substances' => [
                'Blood Alcohol Concentration (BAC)',
                'Ethanol Detection (0.02 and 0.04 confirmation thresholds)',
            ],
            'meta_description_template' => 'Certified breath alcohol testing (BAT) in :city, :state. Same-day walk-in Evidential Breath Testing (EBT) for DOT compliance, post-accident, or employer protocol.',
            'headline_template' => 'Breath Alcohol Testing in :city, :state',
            'description' => 'Evidential Breath Testing (EBT) conducted by certified Breath Alcohol Technicians (BAT). Provides immediate quantitative Blood Alcohol Concentration (BAC) results with printed tape verification for DOT Part 40 and workplace protocols.',
        ],
        'instant-drug-test' => [
            'id' => 7,
            'slug' => 'instant-drug-test',
            'name' => 'Instant Rapid Drug Test',
            'full_title' => 'Rapid Instant Drug Screen (Same-Day Negative Results)',
            'short_name' => 'Rapid Drug Test',
            'specimen' => 'Point-of-Care Urine',
            'turnaround' => 'Instant / Same-Day Results (15 Minutes)',
            'default_price' => 95.99,
            'product_slug' => '5-panel-rapid',
            'substances' => [
                'Marijuana (THC)',
                'Cocaine (COC)',
                'Opiates (OPI)',
                'Amphetamines (AMP)',
                'Phencyclidine (PCP)',
            ],
            'meta_description_template' => 'Rapid 15-minute instant drug test in :city, :state. Walk in today for immediate point-of-collection screening with official lab certification.',
            'headline_template' => 'Instant Rapid Drug Testing in :city, :state',
            'description' => 'Point-of-Care testing providing negative screening results within 15 minutes of specimen donation. Non-negative specimens reflex immediately to GC/MS laboratory confirmation for absolute legal certainty.',
        ],
        'court-ordered-drug-test' => [
            'id' => 8,
            'slug' => 'court-ordered-drug-test',
            'name' => 'Court-Ordered Drug Test',
            'full_title' => 'Court-Ordered & Legal Chain of Custody Drug Screen',
            'short_name' => 'Court-Ordered Test',
            'specimen' => 'Observed / Chain of Custody Urine or Hair',
            'turnaround' => '24–48 Business Hours',
            'default_price' => 109.99,
            'product_slug' => '10-panel',
            'substances' => [
                'Marijuana (THC)',
                'Cocaine',
                'Opiates & Heroin',
                'Amphetamines & Meth',
                'Benzodiazepines',
                'Barbiturates',
                'Alcohol Metabolites (EtG)',
            ],
            'meta_description_template' => 'Legally admissible court-ordered drug testing in :city, :state. Strict chain of custody, probation, custody hearings & certified MRO signed documentation.',
            'headline_template' => 'Court-Ordered Drug Testing in :city, :state',
            'description' => 'Strict forensic chain of custody testing engineered for municipal courts, family law hearings, probation mandates, and custody evaluations. Includes verifiable donor ID verification, tamper-evident seals, and judge-ready medical documentation.',
        ],
        'random-drug-testing' => [
            'id' => 9,
            'slug' => 'random-drug-testing',
            'name' => 'Random Drug Testing & Consortium',
            'full_title' => 'Workplace Random Drug Testing & DOT Consortium Management',
            'short_name' => 'Random Testing',
            'specimen' => 'Urine / Breath / Hair Selection',
            'turnaround' => '24–48 Business Hours',
            'default_price' => 99.99,
            'product_slug' => '1-year-enrollment',
            'substances' => [
                'Comprehensive 5-Panel or 10-Panel Panels',
                'Computerized Random Selection Pool',
                'FMCSA Clearinghouse Management',
            ],
            'meta_description_template' => 'Complete workplace and DOT random drug testing programs in :city, :state. Automated computer pools, consortium enrollment & employer compliance certificates.',
            'headline_template' => 'Random Drug Testing Programs in :city, :state',
            'description' => 'Automated, mathematically randomized employee pool selection for DOT fleets and private enterprise. Protects your business from discriminatory selection allegations while meeting strict federal annual selection percentage mandates.',
        ],
    ];

    public function __construct(
        protected GeoLocationService $geo
    ) {}

    /**
     * City Landing Page: /services/{service-slug}/{state-slug}/{city-slug}/
     */
    public function city(string $serviceSlug, string $stateSlug, string $citySlug)
    {
        // 1. Normalize slugs using transliterator
        $serviceSlug = SlugTransliterator::slugify($serviceSlug);
        $stateSlug = SlugTransliterator::slugify($stateSlug);
        $citySlug = SlugTransliterator::slugify($citySlug);

        // 2. Validate Service Chain
        $chain = self::CHAINS[$serviceSlug] ?? null;
        if (!$chain) {
            abort(404);
        }

        // 3. Resolve State
        $state = State::where('slug', $stateSlug)
            ->where('is_active', true)
            ->firstOrFail();

        // 4. Resolve City
        $city = City::where('state_id', $state->id)
            ->where('slug', $citySlug)
            ->where('is_active', true)
            ->first();

        if (!$city) {
            abort(404);
        }

        // 5. 35-Mile Guardrail: Check eligibility from table or dynamically
        $eligibilityRecord = PseoEligibleCity::where('city_id', $city->id)->first();
        if ($eligibilityRecord && !$eligibilityRecord->is_eligible) {
            // Doorway prevention: Hard 404 for municipalities lacking coverage
            abort(404);
        }

        // 6. Fetch Nearest Collection Centers
        $locations = $this->geo->getNearestLocationsForCity($city, 35.0, 10);
        if ($locations->isEmpty()) {
            abort(404);
        }

        // 7. Resolve Product for Direct Booking
        $product = Product::where('slug', $chain['product_slug'])
            ->where('is_active', true)
            ->first();

        $price = $product ? (float) $product->price : $chain['default_price'];

        // 8. Resolve Unique Localized City Content (from live GPT dataset)
        $pseoContent = $city->pseoContent;
        $uniqueLocalText = null;
        if ($pseoContent) {
            $rawText = match ($serviceSlug) {
                '5-panel-drug-test' => $pseoContent->gpt_5panel,
                '10-panel-drug-test' => $pseoContent->gpt_10panel,
                'dot-drug-test' => $pseoContent->gpt_dot,
                'hair-follicle-drug-test' => $pseoContent->gpt_hair,
                'breath-alcohol-test' => $pseoContent->gpt_alcohol,
                'random-drug-testing' => $pseoContent->gpt_consortium,
                default => $pseoContent->gpt_services,
            };

            if (!empty($rawText)) {
                $uniqueLocalText = str_replace(
                    ['<CITY>', '<STATE>', '1-1-800-985-4339', '18009854339'],
                    [$city->name, $state->name, '1-800-985-4339', '1-800-985-4339'],
                    $rawText
                );
            }
        }

        // 9. Generate Cross-Service Links for all other 8 chains in this exact city
        $otherServices = [];
        foreach (self::CHAINS as $key => $otherChain) {
            if ($key !== $serviceSlug) {
                $otherServices[] = [
                    'slug' => $key,
                    'name' => $otherChain['name'],
                    'short_name' => $otherChain['short_name'],
                    'price' => $otherChain['default_price'],
                    'url' => rtrim(url("/services/{$key}/{$state->slug}/{$city->slug}"), '/') . '/',
                ];
            }
        }

        // 10. SEO Meta & Absolute Canonical URL (with trailing slash)
        $cityName = $city->name;
        $stateName = $state->name;
        $stateAbbr = $state->abbr;

        $pageTitle = "{$chain['name']} in {$cityName}, {$stateAbbr} | Walk-in Local Centers";
        $metaDescription = str_replace(
            [':city', ':state'],
            [$cityName, "{$stateName} ({$stateAbbr})"],
            $chain['meta_description_template']
        );
        $canonicalUrl = rtrim(url("/services/{$serviceSlug}/{$state->slug}/{$city->slug}"), '/') . '/';

        // 11. Dynamic Breadcrumbs
        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Services', 'url' => rtrim(url("/services/{$serviceSlug}"), '/') . '/'],
            ['name' => $chain['name'], 'url' => rtrim(url("/services/{$serviceSlug}"), '/') . '/'],
            ['name' => $stateName, 'url' => rtrim(url("/services/{$serviceSlug}/{$state->slug}"), '/') . '/'],
            ['name' => $cityName, 'url' => $canonicalUrl],
        ];

        // 12. Schema.org JSON-LD Generation
        $schemaBreadcrumbs = $this->buildBreadcrumbSchema($breadcrumbs);
        $schemaMedicalBusiness = $this->buildMedicalBusinessSchema($chain, $city, $state, $locations->first(), $canonicalUrl, $price);

        return view('services.city', compact(
            'chain',
            'city',
            'state',
            'locations',
            'product',
            'price',
            'pseoContent',
            'uniqueLocalText',
            'otherServices',
            'pageTitle',
            'metaDescription',
            'canonicalUrl',
            'breadcrumbs',
            'schemaBreadcrumbs',
            'schemaMedicalBusiness'
        ));
    }

    /**
     * State Landing Page: /services/{service-slug}/{state-slug}/
     */
    public function state(string $serviceSlug, string $stateSlug)
    {
        $serviceSlug = SlugTransliterator::slugify($serviceSlug);
        $stateSlug = SlugTransliterator::slugify($stateSlug);

        $chain = self::CHAINS[$serviceSlug] ?? null;
        if (!$chain) {
            abort(404);
        }

        $state = State::where('slug', $stateSlug)
            ->where('is_active', true)
            ->firstOrFail();

        // Eligible cities in this state with active collection centers
        $eligibleCities = City::join('pseo_eligible_cities', 'cities.id', '=', 'pseo_eligible_cities.city_id')
            ->where('cities.state_id', $state->id)
            ->where('cities.is_active', true)
            ->where('pseo_eligible_cities.is_eligible', true)
            ->select('cities.*', 'pseo_eligible_cities.active_centers_count')
            ->orderBy('cities.name')
            ->get();

        // Sample centers in state
        $sampleLocations = Location::where('state', $state->abbr)
            ->where('is_active', true)
            ->limit(8)
            ->get();

        $pageTitle = "{$chain['name']} in {$state->name} ({$state->abbr}) | Certified Walk-in Labs";
        $metaDescription = "Find certified {$chain['name']} collection locations across {$state->name}. Walk in today at Quest Diagnostics & Labcorp partner facilities. Fast MRO-reviewed results.";
        $canonicalUrl = rtrim(url("/services/{$serviceSlug}/{$state->slug}"), '/') . '/';

        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Services', 'url' => rtrim(url("/services/{$serviceSlug}"), '/') . '/'],
            ['name' => $chain['name'], 'url' => rtrim(url("/services/{$serviceSlug}"), '/') . '/'],
            ['name' => $state->name, 'url' => $canonicalUrl],
        ];

        $schemaBreadcrumbs = $this->buildBreadcrumbSchema($breadcrumbs);

        return view('services.state', compact(
            'chain',
            'state',
            'eligibleCities',
            'sampleLocations',
            'pageTitle',
            'metaDescription',
            'canonicalUrl',
            'breadcrumbs',
            'schemaBreadcrumbs'
        ));
    }

    /**
     * Top-Level National Service Page: /services/{service-slug}/
     */
    public function service(string $serviceSlug)
    {
        $serviceSlug = SlugTransliterator::slugify($serviceSlug);

        $chain = self::CHAINS[$serviceSlug] ?? null;
        if (!$chain) {
            abort(404);
        }

        $states = State::where('is_active', true)
            ->withCount(['cities as eligible_cities_count' => function ($q) {
                $q->join('pseo_eligible_cities', 'cities.id', '=', 'pseo_eligible_cities.city_id')
                  ->where('pseo_eligible_cities.is_eligible', true);
            }])
            ->orderBy('name')
            ->get();

        $allChains = self::CHAINS;

        $pageTitle = "Nationwide {$chain['full_title']} | Same-Day Certified Walk-in Centers";
        $metaDescription = "Order a {$chain['name']} online and walk into any of 20,000+ Quest & Labcorp certified partner facilities across all 50 states. Confidential MRO results.";
        $canonicalUrl = rtrim(url("/services/{$serviceSlug}"), '/') . '/';

        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Services', 'url' => url('/')],
            ['name' => $chain['name'], 'url' => $canonicalUrl],
        ];

        $schemaBreadcrumbs = $this->buildBreadcrumbSchema($breadcrumbs);

        return view('services.service', compact(
            'chain',
            'states',
            'allChains',
            'pageTitle',
            'metaDescription',
            'canonicalUrl',
            'breadcrumbs',
            'schemaBreadcrumbs'
        ));
    }

    /**
     * Build BreadcrumbList Schema (JSON-LD)
     */
    protected function buildBreadcrumbSchema(array $breadcrumbs): array
    {
        $itemList = [];
        foreach ($breadcrumbs as $idx => $bc) {
            $itemList[] = [
                '@type' => 'ListItem',
                'position' => $idx + 1,
                'name' => $bc['name'],
                'item' => $bc['url'],
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $itemList,
        ];
    }

    /**
     * Build MedicalBusiness + OfferCatalog Schema (JSON-LD)
     */
    protected function buildMedicalBusinessSchema(array $chain, City $city, State $state, ?Location $location, string $canonicalUrl, float $price): array
    {
        $businessName = "Certified Drug Test Centers - {$city->name}, {$state->abbr}";
        $lat = (float) ($location?->lat ?? $city->lat ?? 28.5383);
        $lng = (float) ($location?->lng ?? $city->lng ?? -81.3792);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'MedicalBusiness',
            'name' => $businessName,
            'url' => $canonicalUrl,
            'telephone' => '+1-800-985-4339',
            'priceRange' => '$$',
            'medicalSpecialty' => 'SubstanceAbuseScreening',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $location?->address1 ?? 'Accredited Partner Facility',
                'addressLocality' => $city->name,
                'addressRegion' => $state->abbr,
                'postalCode' => $location?->zip ?? $city->zip_code ?? '00000',
                'addressCountry' => 'US',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => round($lat, 6),
                'longitude' => round($lng, 6),
            ],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => $chain['full_title'],
                'itemListElement' => [
                    [
                        '@type' => 'Offer',
                        'price' => number_format($price, 2, '.', ''),
                        'priceCurrency' => 'USD',
                        'availability' => 'https://schema.org/InStock',
                        'url' => $canonicalUrl,
                        'itemOffered' => [
                            '@type' => 'Service',
                            'name' => $chain['name'],
                            'description' => $chain['description'],
                            'provider' => [
                                '@type' => 'MedicalOrganization',
                                'name' => 'Certified Drug Test Centers',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
