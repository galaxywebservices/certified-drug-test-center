@extends('admin.layouts.app', ['title' => 'City Landing Pages & SEO Guides', 'heading' => 'PSEO City Guides (1,000 Nationwide Cities)'])

@section('content')
<div class="card">
    <div class="card-header" style="flex-wrap:wrap; gap:16px; justify-content:space-between;">
        <form action="{{ route('admin.cities.index') }}" method="GET" style="display:flex; gap:12px; flex-grow:1; flex-wrap:wrap; max-width:600px;">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search city name or slug..." style="flex:2; min-width:200px;">
            
            <select name="state_id" class="form-control" style="flex:1; min-width:140px;">
                <option value="">All States</option>
                @foreach($states as $st)
                    <option value="{{ $st->id }}" {{ request('state_id') == $st->id ? 'selected' : '' }}>{{ $st->name }} ({{ $st->abbr }})</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-navy btn-sm">Filter</button>
            @if(request()->anyFilled(['search', 'state_id']))
                <a href="{{ route('admin.cities.index') }}" class="btn btn-outline btn-sm">Clear</a>
            @endif
        </form>

        <a href="{{ route('admin.locations.index') }}" class="btn btn-outline btn-sm">
            &larr; Back to Collection Facilities
        </a>
    </div>

    <div class="card-body" style="padding:0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>City</th>
                    <th>State</th>
                    <th>Chain URL</th>
                    <th>Content Status</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cities as $city)
                <tr>
                    <td>
                        <strong>{{ $city->name }}</strong>
                    </td>
                    <td>{{ $city->state->abbr }} - {{ $city->state->name }}</td>
                    <td>
                        <a href="{{ url('/drug-testing-' . $city->slug . '-' . strtolower($city->state->abbr)) }}" target="_blank" style="color:var(--admin-navy); text-decoration:none;">
                            <code>/drug-testing-{{ $city->slug }}-{{ strtolower($city->state->abbr) }}</code>
                        </a>
                    </td>
                    <td>
                        @if(!empty($city->content))
                            <span class="badge badge-success">Unique Content ({{ strlen($city->content) }} chars)</span>
                        @else
                            <span class="badge badge-neutral">Standard Directory</span>
                        @endif
                    </td>
                    <td>
                        @if($city->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-neutral">Inactive</span>
                        @endif
                    </td>
                    <td style="text-align:right;">
                        <div class="action-btn-group">
                            <a href="{{ url('/drug-testing-' . $city->slug . '-' . strtolower($city->state->abbr)) }}" target="_blank" class="action-btn action-btn-view" title="View Live City SEO Guide" aria-label="View">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </a>
                            <a href="{{ route('admin.cities.edit', $city) }}" class="action-btn action-btn-edit" title="Edit City SEO Guide" aria-label="Edit">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:30px; color:#64748B;">No cities found matching your filter criteria.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($cities->hasPages())
    <div style="padding:16px 24px; border-top:1px solid var(--admin-slate-200);">
        {{ $cities->links() }}
    </div>
    @endif
</div>
@endsection
