@extends('layouts.main')

@section('content')
<style>
    .loc-hero-bar {
        background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%);
        color: #fff;
        padding: 40px 0;
        border-bottom: 3px solid #C1121F;
    }

    .state-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 16px;
        margin: 30px 0 60px;
    }

    .state-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 16px 20px;
        text-decoration: none;
        color: #0B2545;
        font-weight: 700;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.15s ease;
    }
    .state-card:hover {
        border-color: #0B2545;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(11,37,69,0.08);
        color: #C1121F;
    }

    .state-abbr-badge {
        background: #F1F5F9;
        color: #475569;
        font-size: 11px;
        font-weight: 800;
        padding: 3px 6px;
        border-radius: 4px;
    }
</style>

<div class="loc-hero-bar">
    <div class="container">
        <h1 style="font-size:32px; font-weight:800; color:#fff; margin-bottom:8px;">
            Nationwide Drug Testing Collection Locations
        </h1>
        <p style="font-size:16px; color:#E2E8F0; max-width:800px;">
            Walk into any of our 20,000+ certified Quest Diagnostics and Labcorp partner facilities across all 51 states. Select your state below to find local collection centers.
        </p>
    </div>
</div>

<div class="container" style="padding-top:30px;">
    <h2 style="font-size:22px; font-weight:800; color:#0B2545;">
        Select Your State (51 States &amp; Territories)
    </h2>

    <div class="state-grid">
        @foreach($states as $s)
        <a href="{{ url('/locations/' . $s->slug) }}" class="state-card">
            <span>{{ $s->name }}</span>
            <span class="state-abbr-badge">{{ $s->abbr }}</span>
        </a>
        @endforeach
    </div>
</div>
@endsection
