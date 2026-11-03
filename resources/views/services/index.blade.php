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
<section class="city-hero-bar" style="background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%); color: #fff; padding: 56px 0; border-bottom: 3px solid #C1121F;">
    <div class="max-w-7xl mx-auto px-4">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 bg-blue-900/60 border border-blue-400/30 text-blue-200 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Nationwide Testing Directory • 20,000+ Collection Sites
            </div>
            <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight mb-3">
                Nationwide Drug &amp; Alcohol Testing Services
            </h1>
            <p class="text-blue-100 text-base md:text-lg leading-relaxed mb-6">
                Certified Drug Test Centers provides fast, confidential same-day drug, alcohol, DOT, and specialized testing. Register online, receive an instant electronic donor pass, and walk into any verified Quest Diagnostics or Labcorp partner facility nationwide.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="#services-grid" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-6 py-3 rounded-xl transition shadow">
                    Browse All 9 Testing Chains
                </a>
                <a href="tel:18009854339" class="bg-white/10 hover:bg-white/20 text-white font-semibold text-sm px-6 py-3 rounded-xl transition border border-white/20">
                    Call 1-800-985-4339
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Main Services Catalog Grid -->
<div class="max-w-7xl mx-auto px-4 py-12" id="services-grid">
    <div class="mb-10 text-center max-w-2xl mx-auto">
        <span class="text-xs font-bold text-blue-700 tracking-wider uppercase">Full Testing Catalog</span>
        <h2 class="text-2xl md:text-3xl font-black text-slate-900 mt-1 mb-2">
            Select A Certified Drug Screening Service
        </h2>
        <p class="text-sm text-slate-600">
            All tests are processed at SAMHSA-certified laboratories and reviewed by independent Medical Review Officers (MRO) for legal validity.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($allChains as $slug => $chain)
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="bg-blue-50 text-blue-800 border border-blue-200 text-xs font-bold px-2.5 py-0.5 rounded-full">
                            {{ $chain['specimen'] }}
                        </span>
                        <div class="text-right">
                            <span class="text-xs text-slate-500 block">From</span>
                            <span class="text-xl font-black text-slate-900">${{ number_format($chain['default_price'], 2) }}</span>
                        </div>
                    </div>

                    <h3 class="text-lg font-bold text-slate-900 mb-2">
                        <a href="{{ rtrim(url('/services/' . $slug), '/') . '/' }}" class="hover:text-blue-700 transition">
                            {{ $chain['name'] }}
                        </a>
                    </h3>

                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        {{ $chain['description'] }}
                    </p>

                    <!-- Turnaround & Substances -->
                    <div class="space-y-2 mb-4 pt-3 border-t border-slate-100 text-xs text-slate-700">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Results In:</span>
                            <span class="font-bold text-emerald-700">{{ $chain['turnaround'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Laboratories:</span>
                            <span class="font-semibold text-slate-800">Quest / Labcorp</span>
                        </div>
                    </div>

                    <!-- Substances Screened Pills -->
                    <div class="mb-5">
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-2">Substances Screened:</span>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach(array_slice($chain['substances'], 0, 4) as $sub)
                                <span class="bg-slate-100 text-slate-700 text-[11px] px-2 py-0.5 rounded">
                                    {{ $sub }}
                                </span>
                            @endforeach
                            @if(count($chain['substances']) > 4)
                                <span class="bg-slate-100 text-slate-500 text-[11px] px-2 py-0.5 rounded font-medium">
                                    +{{ count($chain['substances']) - 4 }} more
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-2 pt-4 border-t border-slate-100">
                    <a href="{{ rtrim(url('/services/' . $slug), '/') . '/' }}" class="block w-full py-2.5 px-4 text-center rounded-xl font-bold text-white bg-blue-700 hover:bg-blue-800 transition text-xs shadow-sm">
                        Find Centers By State &amp; City &rarr;
                    </a>
                    <a href="{{ route('checkout.index', ['slug' => $chain['product_slug']]) }}" class="block w-full py-2 px-4 text-center rounded-xl font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition text-xs">
                        Direct Online Order
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Nationwide States Directory -->
    <div class="mt-16 pt-10 border-t border-slate-200">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl md:text-2xl font-black text-slate-900">
                    Browse Testing Centers By State
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    Select your state to view municipal collection facilities, operating hours, and state drug testing compliance statutes:
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2.5">
            @foreach($states as $st)
                <a href="{{ rtrim(url('/services/5-panel-drug-test/' . $st->slug), '/') . '/' }}" class="flex items-center justify-between p-2.5 rounded-lg border border-slate-200 hover:border-blue-400 hover:bg-blue-50/50 transition text-xs font-semibold text-slate-800 group">
                    <span class="group-hover:text-blue-700">{{ $st->name }}</span>
                    <span class="text-slate-400 text-[11px] font-mono group-hover:text-blue-700">{{ $st->abbr }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Structured Data: JSON-LD -->
<script type="application/ld+json">
{!! json_encode($schemaBreadcrumbs, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endsection
