@extends('layouts.main')

@section('content')
<style>
    .state-hero-bar {
        background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%);
        color: #fff;
        padding: 40px 0;
        border-bottom: 3px solid #C1121F;
    }

    .cities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 12px;
        margin: 20px 0 40px;
    }

    .city-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        padding: 12px 16px;
        text-decoration: none;
        color: #0B2545;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.15s ease;
    }
    .city-card:hover {
        border-color: #0B2545;
        color: #C1121F;
        background: #F8FAFC;
    }

    .lab-cards-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 16px;
        margin: 20px 0 40px;
    }

    .lab-site-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
</style>

<div class="state-hero-bar">
    <div class="container">
        <nav class="breadcrumbs" aria-label="Breadcrumb" style="display:flex; gap:8px; font-size:13px; color:#94A3B8; margin-bottom:12px;">
            <a href="{{ url('/') }}" style="color:#CBD5E1; text-decoration:none;">Home</a>
            <span>&rsaquo;</span>
            <a href="{{ url('/locations') }}" style="color:#CBD5E1; text-decoration:none;">Locations</a>
            <span>&rsaquo;</span>
            <span style="color:#fff;">{{ $state->name }}</span>
        </nav>

        <h1 style="font-size:32px; font-weight:800; color:#fff; margin-bottom:8px;">
            {{ $state->name }} Drug Testing Centers &amp; Walk-In Facilities
        </h1>
        <p style="font-size:16px; color:#E2E8F0; max-width:800px;">
            Accredited Quest Diagnostics and Labcorp collection sites across {{ $state->name }}. Instant electronic donor pass, SAMHSA lab verification, and Medical Review Officer (MRO) certified results.
        </p>
    </div>
</div>

<div class="container" style="padding:40px 0 60px;">
    <!-- Cities Directory in this State -->
    <h2 style="font-size:22px; font-weight:800; color:#0B2545; margin-bottom:8px;">
        Major Cities in {{ $state->name }}
    </h2>
    <p style="font-size:14px; color:#64748B; margin-bottom:16px;">
        Select your city to find collection sites near you:
    </p>

    <div class="cities-grid">
        @forelse($cities as $city)
        <a href="{{ url('/locations/' . $state->slug . '/' . $city->slug) }}" class="city-card">
            <span>{{ $city->name }}</span>
            <span style="color:#94A3B8; font-size:12px;">&rarr;</span>
        </a>
        @empty
        <div style="grid-column:1 / -1; color:#64748B; padding:20px; background:#fff; border-radius:6px;">
            Multiple collection sites available across {{ $state->name }}. Enter your zip code at checkout to find your nearest facility.
        </div>
        @endforelse
    </div>

    <!-- Certified Partner Facilities in this State -->
    @if($sampleLocations->count())
    <h2 style="font-size:22px; font-weight:800; color:#0B2545; margin:30px 0 8px;">
        Accredited Partner Testing Locations in {{ $state->name }}
    </h2>
    <div class="lab-cards-list">
        @foreach($sampleLocations as $loc)
        <div class="lab-site-card">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                <span class="badge" style="background:#E0F2FE; color:#0369A1; text-transform:uppercase; font-size:11px;">
                    {{ $loc->provider ?: 'Quest / Labcorp' }} Partner
                </span>
                <span style="font-size:12px; color:#16A34A; font-weight:700;">Walk-Ins Welcome</span>
            </div>
            <h3 style="font-size:16px; font-weight:700; color:#0B2545; margin-bottom:4px;">{{ $loc->name }}</h3>
            <div style="font-size:14px; color:#475569; line-height:1.6; margin-bottom:12px;">
                {{ $loc->address1 }}<br>
                {{ $loc->city }}, {{ $loc->state }} {{ $loc->zip }}<br>
                <small style="color:#64748B;">Hours: {{ $loc->hours ?: 'Mon-Fri 8:00 AM - 5:00 PM' }}</small>
            </div>
            <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-sm" style="width:100%; justify-content:center;">
                Schedule Test at this Site &rarr;
            </a>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
