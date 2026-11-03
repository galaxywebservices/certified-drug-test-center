@extends('layouts.main')

@section('content')
<!-- Dynamic Breadcrumbs -->
<div class="bg-slate-100 border-b border-slate-200 py-3 text-xs md:text-sm text-slate-600">
    <div class="max-w-7xl mx-auto px-4 flex items-center flex-wrap gap-2">
        @foreach($breadcrumbs as $idx => $bc)
            @if(!$loop->last)
                <a href="{{ $bc['url'] }}" class="text-blue-700 hover:text-blue-900 hover:underline">{{ $bc['name'] }}</a>
                <span class="text-slate-400">/</span>
            @else
                <span class="text-slate-900 font-semibold">{{ $bc['name'] }}</span>
            @endif
        @endforeach
    </div>
</div>

<!-- Hero Section -->
<section class="city-hero-bar" style="background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%); color: #fff; padding: 48px 0; border-bottom: 3px solid #C1121F;">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 bg-blue-900/60 border border-blue-400/30 text-blue-200 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    SAMHSA-Certified • Same-Day Walk-Ins
                </div>
                <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight mb-3">
                    {{ $chain['name'] }} in {{ $city->name }}, {{ $state->abbr }}
                </h1>
                <p class="text-blue-100 text-base md:text-lg max-w-3xl leading-relaxed">
                    {{ $chain['description'] }} Walk into local Quest Diagnostics & Labcorp collection facilities today in {{ $city->name }}. No doctor referral or appointment required.
                </p>
            </div>

            <!-- Fast Action Card -->
            <div class="bg-white text-slate-900 rounded-2xl p-6 shadow-2xl border border-slate-100 flex-shrink-0 md:w-80 text-center">
                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Online Donor Pass</div>
                <div class="text-3xl font-black text-blue-900 mb-1">${{ number_format($price, 2) }}</div>
                <div class="text-xs text-emerald-600 font-semibold flex items-center justify-center gap-1 mb-4">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Electronic Pass Sent Instantly
                </div>
                <a href="{{ route('checkout.index', ['slug' => $product?->slug ?? $chain['product_slug']]) }}" class="block w-full py-3.5 px-6 rounded-xl font-bold text-white bg-blue-700 hover:bg-blue-800 transition shadow-lg shadow-blue-700/20 text-sm">
                    Order Test & Get Pass
                </a>
                <div class="text-xs text-slate-400 mt-2">Confidential & 100% Secure</div>
            </div>
        </div>
    </div>
</section>

<!-- Main Grid Layout -->
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <!-- Main Column (Left 2 cols) -->
        <div class="lg:col-span-2 space-y-8">

            <!-- Nearest Collection Facilities Section -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-900">
                            Nearest Collection Centers in {{ $city->name }}, {{ $state->abbr }}
                        </h2>
                        <p class="text-sm text-slate-500 mt-0.5">
                            Showing verified collection partner facilities within 35 miles of {{ $city->name }}.
                        </p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full text-xs font-semibold">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        {{ $locations->count() }} Centers Available
                    </span>
                </div>

                <div class="space-y-4">
                    @foreach($locations as $location)
                        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="text-lg font-bold text-slate-900">{{ $location->name }}</h3>
                                        <span class="bg-blue-50 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-blue-200">
                                            {{ ucfirst($location->provider ?: 'Quest / Labcorp') }} Partner
                                        </span>
                                    </div>
                                    <div class="text-sm font-semibold text-emerald-700 mt-0.5 flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $location->distance_label }}
                                    </div>
                                </div>

                                <div class="flex-shrink-0">
                                    <a href="{{ route('checkout.index', ['slug' => $product?->slug ?? $chain['product_slug']]) }}" class="inline-flex items-center gap-1.5 bg-blue-700 hover:bg-blue-800 text-white font-semibold text-xs px-4 py-2.5 rounded-lg shadow-sm transition">
                                        <span>Select Center</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-3 text-sm text-slate-600">
                                <div>
                                    <div class="font-medium text-slate-800 mb-1 flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        Address
                                    </div>
                                    <p class="text-slate-700">{{ $location->address1 }}</p>
                                    <p class="text-slate-500">{{ $location->city }}, {{ $location->state }} {{ $location->zip }}</p>

                                    <!-- Navigation Links -->
                                    <div class="flex items-center gap-3 mt-2 text-xs font-medium">
                                        @php
                                            $destQuery = urlencode("{$location->address1}, {$location->city}, {$location->state} {$location->zip}");
                                            if (!empty($location->lat) && !empty($location->lng)) {
                                                $destQuery = "{$location->lat},{$location->lng}";
                                            }
                                        @endphp
                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $destQuery }}" target="_blank" rel="noopener" class="text-blue-700 hover:underline">Google Maps</a>
                                        <span class="text-slate-300">•</span>
                                        <a href="https://maps.apple.com/?daddr={{ $destQuery }}" target="_blank" rel="noopener" class="text-blue-700 hover:underline">Apple Maps</a>
                                        <span class="text-slate-300">•</span>
                                        <a href="https://waze.com/ul?ll={{ $destQuery }}&navigate=yes" target="_blank" rel="noopener" class="text-blue-700 hover:underline">Waze</a>
                                    </div>
                                </div>

                                <div>
                                    <div class="font-medium text-slate-800 mb-1 flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Operating Hours & Walk-In
                                    </div>
                                    <div class="text-xs text-slate-600 space-y-0.5">
                                        @foreach($location->formatted_hours_lines as $hLine)
                                            <div>{{ $hLine }}</div>
                                        @endforeach
                                    </div>
                                    <div class="mt-2 inline-flex items-center gap-1 text-xs font-semibold text-emerald-800 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded">
                                        ✓ Walk-Ins Welcome Today
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Dynamic 3-Step Walk-In Guide -->
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-6">
                    <h2 class="text-xl font-bold text-slate-900">How to Take Your {{ $chain['name'] }} in {{ $city->name }}</h2>
                    <span class="bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1 rounded-full border border-blue-200">
                        Electronic Pass Protocol
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 relative">
                        <div class="w-9 h-9 bg-red-100 text-red-700 font-black rounded-lg flex items-center justify-center text-lg mb-3">
                            1
                        </div>
                        <h3 class="font-bold text-slate-900 text-base mb-1.5">Register Online</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Order your test securely online or call 1-800-985-4339. Your electronic donor pass barcode is generated immediately and sent to your email and smartphone.
                        </p>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 relative">
                        <div class="w-9 h-9 bg-blue-100 text-blue-700 font-black rounded-lg flex items-center justify-center text-lg mb-3">
                            2
                        </div>
                        <h3 class="font-bold text-slate-900 text-base mb-1.5">Walk Into Nearest Lab</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Bring your phone barcode and a government photo ID to any certified Quest or Labcorp site in {{ $city->name }}. No appointment needed; walk right in.
                        </p>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 relative">
                        <div class="w-9 h-9 bg-emerald-100 text-emerald-700 font-black rounded-lg flex items-center justify-center text-lg mb-3">
                            3
                        </div>
                        <h3 class="font-bold text-slate-900 text-base mb-1.5">Fast MRO Results</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Your specimen is analyzed at a SAMHSA-certified lab and verified by a licensed Medical Review Officer. Certified results are delivered securely in 24–48 hours.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Substances Detected Breakdown -->
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                <h2 class="text-xl font-bold text-slate-900 mb-2">Substances Screened in {{ $chain['name'] }}</h2>
                <p class="text-sm text-slate-500 mb-4">
                    Standard testing cutoff levels established under federal SAMHSA and CLIA guidelines:
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($chain['substances'] as $substance)
                        <div class="flex items-center gap-2.5 bg-slate-50 border border-slate-200 px-3.5 py-2.5 rounded-lg text-sm text-slate-800">
                            <span class="w-2 h-2 rounded-full bg-blue-600 flex-shrink-0"></span>
                            <span>{{ $substance }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- State Legal & Compliance Framework -->
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <h2 class="text-xl font-bold text-slate-900">
                        {{ $state->name }} Drug Testing Laws & Statutory Compliance
                    </h2>
                    @if($state->statute_code)
                        <span class="bg-slate-100 text-slate-800 font-mono text-xs font-bold px-2.5 py-1 rounded border border-slate-200">
                            {{ $state->statute_code }}
                        </span>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5 text-sm">
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-lg">
                        <div class="text-xs text-slate-500 font-semibold uppercase mb-1">Medical Marijuana</div>
                        <div class="font-bold text-slate-900">{{ $state->medical_marijuana_status ?: 'Regulated by State' }}</div>
                    </div>
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-lg">
                        <div class="text-xs text-slate-500 font-semibold uppercase mb-1">Recreational Cannabis</div>
                        <div class="font-bold text-slate-900">{{ $state->recreational_marijuana_status ?: 'State Statutes Apply' }}</div>
                    </div>
                    <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-lg">
                        <div class="text-xs text-slate-500 font-semibold uppercase mb-1">Confirmation Testing</div>
                        <div class="font-bold text-slate-900">Mandatory GC/MS or LC/MS</div>
                    </div>
                </div>

                @if($state->employer_rights_summary)
                    <div class="mb-4">
                        <h3 class="text-sm font-bold text-slate-800 mb-1">Employer Rights & Drug-Free Workplace Policies</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $state->employer_rights_summary }}</p>
                    </div>
                @endif

                @if($state->worker_comp_rules)
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 mb-1">Workers' Compensation Discounts</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $state->worker_comp_rules }}</p>
                    </div>
                @endif
            </div>

            <!-- State Specific FAQs (if available) -->
            @if(!empty($state->faqs_json) && count($state->faqs_json) > 0)
                <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-slate-900 mb-4">
                        Frequently Asked Questions in {{ $city->name }}, {{ $state->abbr }}
                    </h2>
                    <div class="space-y-4">
                        @foreach(array_slice($state->faqs_json, 0, 4) as $faq)
                            <div class="border-b border-slate-100 pb-3 last:border-b-0">
                                <h3 class="text-sm font-bold text-slate-900 mb-1">{{ $faq['question'] ?? '' }}</h3>
                                <p class="text-xs text-slate-600 leading-relaxed">{{ $faq['answer'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <!-- Sidebar Column (Right 1 col) -->
        <div class="space-y-6">

            <!-- Fast Booking Summary Card -->
            <div class="bg-white border-2 border-blue-700/20 rounded-2xl p-6 shadow-md">
                <div class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-1">Immediate Booking</div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $chain['name'] }}</h3>
                <div class="flex items-baseline gap-2 mb-4">
                    <span class="text-3xl font-black text-slate-900">${{ number_format($price, 2) }}</span>
                    <span class="text-xs text-slate-500">Includes Lab Fee & MRO</span>
                </div>

                <ul class="text-xs text-slate-600 space-y-2 mb-5">
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-600 font-bold">✓</span> No doctor's order required
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-600 font-bold">✓</span> Electronic pass valid for 21 days
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-600 font-bold">✓</span> Accepted at all {{ $city->name }} partner labs
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-600 font-bold">✓</span> Turnaround: {{ $chain['turnaround'] }}
                    </li>
                </ul>

                <a href="{{ route('checkout.index', ['slug' => $product?->slug ?? $chain['product_slug']]) }}" class="block w-full py-3 px-4 text-center rounded-xl font-bold text-white bg-blue-700 hover:bg-blue-800 transition shadow-md text-sm mb-3">
                    Order Online & Walk In
                </a>

                <a href="tel:18009854339" class="block w-full py-3 px-4 text-center rounded-xl font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition text-sm">
                    Call 1-800-985-4339
                </a>
            </div>

            <!-- Cross-Service City Switcher (Links to all other 8 chains in this exact city) -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-base font-extrabold text-slate-900 mb-3">
                    Other Drug Tests in {{ $city->name }}
                </h3>
                <p class="text-xs text-slate-500 mb-4">
                    Need a different screening panel? All tests can be conducted at the same {{ $city->name }} partner facilities:
                </p>

                <div class="space-y-2">
                    @foreach($otherServices as $other)
                        <a href="{{ $other['url'] }}" class="flex items-center justify-between p-2.5 rounded-lg border border-slate-200 hover:border-blue-400 hover:bg-blue-50/50 transition text-xs font-semibold text-slate-800 group">
                            <span class="group-hover:text-blue-700">{{ $other['name'] }} in {{ $city->name }}</span>
                            <span class="text-slate-400 group-hover:text-blue-700">→</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Accreditation & Security Badges -->
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 text-center text-xs text-slate-500">
                <div class="font-bold text-slate-700 mb-2">Laboratory Accreditations</div>
                <div class="flex items-center justify-center gap-3 flex-wrap font-semibold text-slate-600">
                    <span class="bg-white border border-slate-200 px-2 py-1 rounded">SAMHSA Certified</span>
                    <span class="bg-white border border-slate-200 px-2 py-1 rounded">CAP Accredited</span>
                    <span class="bg-white border border-slate-200 px-2 py-1 rounded">CLIA Licensed</span>
                </div>
                <p class="mt-3 text-[11px] text-slate-400">
                    All test results reviewed by a certified Medical Review Officer (MRO) for accuracy and legal validity.
                </p>
            </div>

        </div>
    </div>
</div>

<!-- Structured Data: JSON-LD -->
<script type="application/ld+json">
{!! json_encode($schemaBreadcrumbs, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

<script type="application/ld+json">
{!! json_encode($schemaMedicalBusiness, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endsection
