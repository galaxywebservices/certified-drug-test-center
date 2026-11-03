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

<!-- State Hero Bar -->
<section class="city-hero-bar" style="background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%); color: #fff; padding: 48px 0; border-bottom: 3px solid #C1121F;">
    <div class="max-w-7xl mx-auto px-4">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 bg-blue-900/60 border border-blue-400/30 text-blue-200 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                {{ $state->name }} ({{ $state->abbr }}) Directory • {{ $eligibleCities->count() }} Municipalities
            </div>
            <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight mb-3">
                {{ $chain['name'] }} in {{ $state->name }}
            </h1>
            <p class="text-blue-100 text-base md:text-lg leading-relaxed mb-6">
                {{ $chain['description'] }} Find certified walk-in testing facilities in {{ $state->name }} with Quest Diagnostics & Labcorp collection sites. Same-day registration and official MRO results.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="#cities-list" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-6 py-3 rounded-xl transition shadow">
                    Browse Cities in {{ $state->name }}
                </a>
                <a href="tel:18009854339" class="bg-white/10 hover:bg-white/20 text-white font-semibold text-sm px-6 py-3 rounded-xl transition border border-white/20">
                    Call 1-800-985-4339
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Content Body -->
<div class="max-w-7xl mx-auto px-4 py-12">
    <!-- Cities Directory Section -->
    <div id="cities-list" class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-black text-slate-900">
                    Active {{ $chain['name'] }} Locations in {{ $state->name }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Select your city to view exact nearby collection facilities, directions, hours, and electronic passes:
                </p>
            </div>
            <span class="bg-blue-50 text-blue-800 text-xs font-bold px-3 py-1.5 rounded-full border border-blue-200">
                {{ $eligibleCities->count() }} Cities Available
            </span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
            @foreach($eligibleCities as $eligibleCity)
                <a href="{{ url('/services/' . $chain['slug'] . '/' . $state->slug . '/' . $eligibleCity->slug . '/') }}" class="flex items-center justify-between p-3 rounded-xl border border-slate-200 bg-white hover:border-blue-400 hover:bg-blue-50/40 hover:shadow-sm transition group text-sm">
                    <span class="font-medium text-slate-800 group-hover:text-blue-700">{{ $eligibleCity->name }}</span>
                    <span class="text-xs text-slate-400 group-hover:text-blue-700">→</span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- State Legal & Compliance Overview -->
    <div class="bg-white border border-slate-200 rounded-2xl p-8 shadow-sm mb-12">
        <h2 class="text-xl font-bold text-slate-900 mb-3">
            {{ $state->name }} Drug Testing Regulations & Legal Summary
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 text-sm">
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                <div class="text-xs text-slate-500 font-semibold uppercase mb-1">State Statute</div>
                <div class="font-bold text-slate-900">{{ $state->statute_code ?: 'State Common Law' }}</div>
            </div>
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                <div class="text-xs text-slate-500 font-semibold uppercase mb-1">Medical Marijuana</div>
                <div class="font-bold text-slate-900">{{ $state->medical_marijuana_status ?: 'State Specific' }}</div>
            </div>
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl">
                <div class="text-xs text-slate-500 font-semibold uppercase mb-1">Workers' Comp Discounts</div>
                <div class="font-bold text-slate-900">{{ $state->worker_comp_rules ? 'Available' : 'Standard' }}</div>
            </div>
        </div>

        @if($state->employer_rights_summary)
            <div class="text-xs text-slate-600 leading-relaxed">
                <h3 class="text-sm font-bold text-slate-800 mb-1">Statutory Guidelines for Employers & Individuals</h3>
                <p>{{ $state->employer_rights_summary }}</p>
            </div>
        @endif
    </div>
</div>

<!-- Structured Data -->
<script type="application/ld+json">
{!! json_encode($schemaBreadcrumbs, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endsection
