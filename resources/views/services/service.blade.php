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

<!-- Hero Bar -->
<section class="city-hero-bar" style="background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%); color: #fff; padding: 48px 0; border-bottom: 3px solid #C1121F;">
    <div class="max-w-7xl mx-auto px-4">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 bg-blue-900/60 border border-blue-400/30 text-blue-200 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Nationwide Testing Directory • 50 States
            </div>
            <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight mb-3">
                Nationwide {{ $chain['full_title'] }}
            </h1>
            <p class="text-blue-100 text-base md:text-lg leading-relaxed mb-6">
                {{ $chain['description'] }} Walk in today at over 20,000 certified Quest Diagnostics & Labcorp partner collection facilities across all 50 states. Confidential MRO results delivered in {{ $chain['turnaround'] }}.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="#states-grid" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm px-6 py-3 rounded-xl transition shadow">
                    Find by State
                </a>
                <a href="tel:18009854339" class="bg-white/10 hover:bg-white/20 text-white font-semibold text-sm px-6 py-3 rounded-xl transition border border-white/20">
                    Call 1-800-985-4339
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Content Grid -->
<div class="max-w-7xl mx-auto px-4 py-12">
    <!-- States Selection Grid -->
    <div id="states-grid" class="mb-14">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-black text-slate-900">
                    Select Your State for {{ $chain['name'] }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Choose your state to see local certified collection centers, city directories, and state statutory compliance notes:
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3.5">
            @foreach($states as $st)
                <a href="{{ url('/services/' . $chain['slug'] . '/' . $st->slug . '/') }}" class="flex items-center justify-between p-3.5 rounded-xl border border-slate-200 bg-white hover:border-blue-400 hover:bg-blue-50/40 hover:shadow-sm transition group">
                    <div>
                        <div class="font-bold text-slate-900 group-hover:text-blue-700 text-sm">{{ $st->name }}</div>
                        <div class="text-[11px] text-slate-400">{{ $st->eligible_cities_count }} active cities</div>
                    </div>
                    <span class="text-xs text-slate-400 group-hover:text-blue-700">→</span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Substances Screened -->
    <div class="bg-white border border-slate-200 rounded-2xl p-8 shadow-sm mb-12">
        <h2 class="text-xl font-bold text-slate-900 mb-2">Substances Tested in {{ $chain['name'] }}</h2>
        <p class="text-sm text-slate-500 mb-6">
            All screening is performed in accordance with federal SAMHSA and CLIA analytical cutoff guidelines:
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
            @foreach($chain['substances'] as $substance)
                <div class="flex items-center gap-2.5 bg-slate-50 border border-slate-200 px-4 py-3 rounded-xl text-sm text-slate-800">
                    <span class="w-2 h-2 rounded-full bg-blue-600 flex-shrink-0"></span>
                    <span>{{ $substance }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Cross-Service Switcher -->
    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-8 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900 mb-2">Explore All Nationwide Drug Testing Services</h2>
        <p class="text-sm text-slate-500 mb-6">
            Certified Drug Test Centers provides a full spectrum of laboratory drug and alcohol screening panels:
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($allChains as $cSlug => $cData)
                @if($cSlug !== $chain['slug'])
                    <a href="{{ url('/services/' . $cSlug . '/') }}" class="p-4 bg-white border border-slate-200 rounded-xl hover:border-blue-400 hover:shadow-sm transition group">
                        <div class="font-bold text-slate-900 group-hover:text-blue-700 text-sm mb-1">{{ $cData['name'] }}</div>
                        <div class="text-xs text-slate-500 line-clamp-2">{{ $cData['description'] }}</div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</div>

<!-- Structured Data -->
<script type="application/ld+json">
{!! json_encode($schemaBreadcrumbs, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endsection
