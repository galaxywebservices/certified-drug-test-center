@extends('admin.layouts.app', ['title' => 'Dashboard', 'heading' => 'Platform Overview'])

@section('content')
<style>
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }

    .metric-card {
        background: #fff;
        border: 1px solid var(--admin-slate-200);
        border-radius: 10px;
        padding: 22px;
        display: flex;
        flex-direction: column;
    }

    .metric-label {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--admin-slate-500);
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .metric-val {
        font-size: 32px;
        font-weight: 800;
        color: var(--admin-navy);
        line-height: 1;
    }

    .metric-sub {
        font-size: 13px;
        color: var(--admin-slate-500);
        margin-top: 8px;
    }

    .metric-icon-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .dashboard-two-col {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }

    @media (max-width: 992px) {
        .dashboard-two-col { grid-template-columns: 1fr; }
    }
</style>

<!-- Metric KPI Cards -->
<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-icon-wrap">
            <span class="metric-label">Active Products</span>
            <span class="badge badge-info">{{ $activeProductsCount }} Live</span>
        </div>
        <div class="metric-val">{{ $productsCount }}</div>
        <div class="metric-sub">Tests &amp; Panel configurations</div>
    </div>

    <div class="metric-card">
        <div class="metric-icon-wrap">
            <span class="metric-label">CMS Pages</span>
            <span class="badge badge-success">Migrated</span>
        </div>
        <div class="metric-val">{{ $pagesCount }}</div>
        <div class="metric-sub">Editable via Page Builder</div>
    </div>

    <div class="metric-card">
        <div class="metric-icon-wrap">
            <span class="metric-label">Categories</span>
            <span class="badge badge-neutral">15 Total</span>
        </div>
        <div class="metric-val">{{ $categoriesCount }}</div>
        <div class="metric-sub">Urine, Hair, DOT, Alcohol, DNA</div>
    </div>

    <div class="metric-card">
        <div class="metric-icon-wrap">
            <span class="metric-label">Collection Sites</span>
            <span class="badge badge-success">Quest &amp; Labcorp</span>
        </div>
        <div class="metric-val">{{ $locationsCount }}+</div>
        <div class="metric-sub">Nationwide Walk-in Facilities</div>
    </div>

    <div class="metric-card">
        <div class="metric-icon-wrap">
            <span class="metric-label">Total Revenue</span>
            <span class="badge badge-success">PayTrace</span>
        </div>
        <div class="metric-val">${{ number_format($revenue, 2) }}</div>
        <div class="metric-sub">{{ $ordersCount }} Test Registrations</div>
    </div>
</div>

<!-- Main Section: Recent CMS Pages & Quick Actions -->
<div class="dashboard-two-col">
    <!-- Left Column: Pages Ready For Editing -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Recently Updated CMS Pages</h2>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-outline btn-sm">View All Pages ({{ $pagesCount }})</a>
        </div>
        <div class="card-body" style="padding:0;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Page Title</th>
                        <th>URL Slug</th>
                        <th>SEO Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPages as $p)
                    <tr>
                        <td>
                            <strong>{{ $p->title }}</strong>
                        </td>
                        <td><code>/{{ $p->slug }}</code></td>
                        <td>
                            <small class="text-muted">{{ Str::limit($p->meta_title, 40) }}</small>
                        </td>
                        <td>
                            <div style="display:flex; gap:8px;">
                                <a href="{{ route('admin.pages.edit', $p) }}" class="btn btn-navy btn-sm">Edit / PageBuilder</a>
                                <a href="{{ url('/' . $p->slug) }}" target="_blank" class="btn btn-outline btn-sm">Preview</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Right Column: Quick Shortcuts -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Super Admin Quick Tools</h2>
        </div>
        <div class="card-body">
            <div style="display:flex; flex-direction:column; gap:12px;">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary" style="justify-content:center;">
                    + Add New Product / Panel
                </a>
                <a href="{{ route('admin.pages.create') }}" class="btn btn-navy" style="justify-content:center;">
                    + Create New CMS Page
                </a>
                <a href="{{ route('admin.settings.index') }}" class="btn btn-outline" style="justify-content:center;">
                    Configure PayTrace Payment Gateway
                </a>
                <a href="{{ route('sitemap') }}" target="_blank" class="btn btn-outline" style="justify-content:center;">
                    Verify Live XML Sitemap (SEO)
                </a>
            </div>

            <div style="margin-top:24px; padding-top:20px; border-top:1px solid var(--admin-slate-200);">
                <div style="font-size:12px; font-weight:700; color:var(--admin-slate-500); text-transform:uppercase; margin-bottom:8px;">
                    Platform Version &amp; Status
                </div>
                <div style="font-size:13px; color:var(--admin-slate-700); line-height:1.6;">
                    • <strong>Design Theme:</strong> Option 2 (Corporate Clean Trust)<br>
                    • <strong>Gateway:</strong> PayTrace Integrated<br>
                    • <strong>Database:</strong> cdtc (Migrated from ADT)<br>
                    • <strong>Framework:</strong> Laravel {{ app()->version() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
