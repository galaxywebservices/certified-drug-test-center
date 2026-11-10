@extends('admin.layouts.app', ['title' => 'State Landing Pages', 'heading' => 'State Landing Pages & Compliance Manager'])

@section('topbar_actions')
<a href="{{ url('/locations') }}" target="_blank" class="btn btn-outline btn-sm">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
    Browse All States
</a>
<a href="{{ route('admin.chains.national') }}" class="btn btn-navy btn-sm">
    🏛️ Edit National Chain Page
</a>
@endsection

@section('content')

@if(session('success'))
<div class="alert alert-success" style="margin-bottom:20px;">
    {{ session('success') }}
</div>
@endif

<!-- Search & Filter Card -->
<div class="card" style="margin-bottom:20px;">
    <div class="card-body" style="padding:16px 20px;">
        <form action="{{ route('admin.states.index') }}" method="GET" style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
            <div style="flex:1; min-width:240px;">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search state by name, abbreviation, or slug...">
            </div>

            <div style="width:160px;">
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-sm">Filter States</button>
            @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('admin.states.index') }}" class="btn btn-outline btn-sm">Reset</a>
            @endif
        </form>
    </div>
</div>

<!-- States Table Card -->
<div class="card">
    <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h2 class="card-title">All 50 US States &amp; Jurisdictions</h2>
            <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                Edit landing page content, workplace statutes, cannabis regulations, and state-specific legal FAQs.
            </p>
        </div>
        <span class="badge badge-neutral">{{ $states->total() }} States Total</span>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>State</th>
                    <th>Abbr</th>
                    <th>URL Slugs</th>
                    <th>Active Labs</th>
                    <th>Cities</th>
                    <th>Compliance Statute</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($states as $st)
                <tr>
                    <td>
                        <strong style="color:var(--admin-navy); font-size:15px;">{{ $st->name }}</strong>
                    </td>
                    <td>
                        <span class="badge badge-info" style="font-weight:700;">{{ $st->abbr }}</span>
                    </td>
                    <td>
                        <div style="font-size:12px; font-family:monospace; color:#64748B;">
                            /locations/{{ $st->slug }}
                        </div>
                    </td>
                    <td>
                        <strong style="color:#0B2545;">{{ number_format($locationCounts[$st->abbr] ?? 0) }}</strong>
                        <span style="font-size:12px; color:#64748B;">centers</span>
                    </td>
                    <td>
                        <span style="font-size:13px; font-weight:600;">{{ $st->cities_count }}</span>
                        <a href="{{ route('admin.cities.index', ['state_id' => $st->id]) }}" style="font-size:11px; color:#0284C7; margin-left:4px;">(view)</a>
                    </td>
                    <td>
                        @if($st->statute_code)
                        <span class="badge badge-neutral" style="font-size:11px;" title="{{ $st->statute_code }}">
                            {{ \Illuminate\Support\Str::limit($st->statute_code, 22) }}
                        </span>
                        @else
                        <span style="color:#94A3B8; font-size:12px;">Standard At-Will</span>
                        @endif
                    </td>
                    <td>
                        @if($st->is_active)
                        <span class="badge badge-success">Active</span>
                        @else
                        <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td style="text-align:right; white-space:nowrap;">
                        <a href="{{ route('admin.states.edit', $st->id) }}" class="btn btn-sm btn-primary">
                            Edit State
                        </a>
                        <a href="{{ url('/locations/' . $st->slug) }}" target="_blank" class="btn btn-sm btn-outline" title="View live state landing page">
                            Live ↗
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:32px; color:#64748B;">
                        No states matching your query.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($states->hasPages())
    <div style="padding:16px 24px; border-top:1px solid #E2E8F0; display:flex; justify-content:center;">
        {{ $states->links() }}
    </div>
    @endif
</div>
@endsection

