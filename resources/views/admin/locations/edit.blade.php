@extends('admin.layouts.app', ['title' => 'Edit Collection Location', 'heading' => 'Edit Collection Facility'])

@section('topbar_actions')
<a href="{{ route('admin.locations.index') }}" class="btn btn-outline btn-sm">
    &larr; Back to Locations
</a>
@endsection

@section('content')
<div class="card" style="max-width:800px; margin:0 auto;">
    <div class="card-header">
        <h2 class="card-title">Location Details &amp; Operational Hours</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.locations.update', $location) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="name">Facility Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $location->name) }}" required>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label class="form-label" for="provider">Lab Provider Network *</label>
                    <select id="provider" name="provider" class="form-control" required>
                        <option value="quest" {{ old('provider', $location->provider) == 'quest' ? 'selected' : '' }}>Quest Diagnostics</option>
                        <option value="labcorp" {{ old('provider', $location->provider) == 'labcorp' ? 'selected' : '' }}>Labcorp</option>
                        <option value="other" {{ old('provider', $location->provider) == 'other' ? 'selected' : '' }}>Other Independent SAMHSA Lab</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="phone">Facility Telephone</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $location->phone) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="address1">Street Address *</label>
                <input type="text" id="address1" name="address1" class="form-control" value="{{ old('address1', $location->address1) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="address2">Suite / Unit / Floor</label>
                <input type="text" id="address2" name="address2" class="form-control" value="{{ old('address2', $location->address2) }}">
            </div>

            <div style="display:grid; grid-template-columns:2fr 1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label class="form-label" for="city">City *</label>
                    <input type="text" id="city" name="city" class="form-control" value="{{ old('city', $location->city) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="state">State *</label>
                    <select id="state" name="state" class="form-control" required>
                        @foreach($states as $st)
                            <option value="{{ $st->abbr }}" {{ old('state', $location->state) == $st->abbr ? 'selected' : '' }}>{{ $st->abbr }} - {{ $st->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="zip">ZIP Code *</label>
                    <input type="text" id="zip" name="zip" class="form-control" value="{{ old('zip', $location->zip) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="hours">Operating Hours &amp; Walk-In Times</label>
                <textarea id="hours" name="hours" rows="3" class="form-control">{{ old('hours', $location->hours) }}</textarea>
                <small style="color:#64748B;">e.g. Monday - Friday 7:30 AM - 4:00 PM (Drug Screen Collections Close 3:30 PM)</small>
            </div>

            <div class="form-group">
                <label style="display:inline-flex; align-items:center; gap:8px; font-weight:600; cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $location->is_active) ? 'checked' : '' }}>
                    Active &amp; Available for Donor Scheduling
                </label>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:24px;">
                <a href="{{ route('admin.locations.index') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Location Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
