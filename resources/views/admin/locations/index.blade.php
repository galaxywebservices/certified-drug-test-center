@extends('admin.layouts.app', ['title' => 'Collection Locations', 'heading' => 'Certified Collection Centers (Quest & Labcorp)'])

@section('content')
<div class="card">
    <div class="card-header" style="flex-wrap:wrap; gap:16px; justify-content:space-between;">
        <form action="{{ route('admin.locations.index') }}" method="GET" style="display:flex; gap:12px; flex-grow:1; flex-wrap:wrap; max-width:800px;">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search clinic name, city, zip code or address..." style="flex:2; min-width:200px;">
            
            <select name="state" class="form-control" style="flex:1; min-width:140px;">
                <option value="">All States</option>
                @foreach($states as $st)
                    <option value="{{ $st->abbr }}" {{ request('state') == $st->abbr ? 'selected' : '' }}>{{ $st->name }} ({{ $st->abbr }})</option>
                @endforeach
            </select>

            <select name="provider" class="form-control" style="flex:1; min-width:130px;">
                <option value="">All Labs</option>
                <option value="quest" {{ request('provider') == 'quest' ? 'selected' : '' }}>Quest</option>
                <option value="labcorp" {{ request('provider') == 'labcorp' ? 'selected' : '' }}>Labcorp</option>
            </select>

            <button type="submit" class="btn btn-navy btn-sm">Filter</button>
            @if(request()->anyFilled(['search', 'state', 'provider']))
                <a href="{{ route('admin.locations.index') }}" class="btn btn-outline btn-sm">Clear</a>
            @endif
        </form>

        <div>
            <a href="{{ route('admin.cities.index') }}" class="btn btn-outline btn-sm">
                View 1,000 PSEO City Guides &rarr;
            </a>
        </div>
    </div>

    <div class="card-body" style="padding:0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Lab Facility</th>
                    <th>Address</th>
                    <th>City / State / ZIP</th>
                    <th>Operating Hours</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($locations as $loc)
                <tr>
                    <td>
                        <strong>{{ $loc->name }}</strong>
                        <div>
                            <span class="badge" style="background:#E0F2FE; color:#0369A1; text-transform:uppercase; font-size:10px;">
                                {{ $loc->provider ?: 'Lab' }}
                            </span>
                        </div>
                    </td>
                    <td>{{ $loc->address1 }} {{ $loc->address2 }}</td>
                    <td>
                        <strong>{{ $loc->city }}</strong>, {{ $loc->state }} {{ $loc->zip }}
                    </td>
                    <td style="max-width:220px; font-size:12px; color:#64748B;">
                        {{ Str::limit($loc->hours ?: 'Monday - Friday 8:00 AM - 5:00 PM', 40) }}
                    </td>
                    <td>
                        @if($loc->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-neutral">Inactive</span>
                        @endif
                    </td>
                    <td style="text-align:right;">
                        <div class="action-btn-group">
                            <a href="https://maps.google.com/?q={{ urlencode($loc->address1 . ', ' . $loc->city . ', ' . $loc->state . ' ' . $loc->zip) }}" target="_blank" class="action-btn action-btn-view" title="Open in Google Maps" aria-label="Map">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            </a>
                            <a href="{{ route('admin.locations.edit', $loc) }}" class="action-btn action-btn-edit" title="Edit Facility" aria-label="Edit">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:30px; color:#64748B;">No locations found matching your search criteria.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($locations->hasPages())
    <div style="padding:16px 24px; border-top:1px solid var(--admin-slate-200);">
        {{ $locations->links() }}
    </div>
    @endif
</div>
@endsection
