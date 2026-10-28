@extends('admin.layouts.app', ['title' => 'Edit City SEO Guide', 'heading' => 'Edit ' . $city->name . ', ' . $city->state->abbr . ' SEO Guide'])

@section('topbar_actions')
<a href="{{ url('/drug-testing-' . $city->slug . '-' . strtolower($city->state->abbr)) }}" target="_blank" class="btn btn-outline btn-sm">
    View Live Landing Page &rarr;
</a>
<a href="{{ route('admin.cities.index') }}" class="btn btn-outline btn-sm">
    &larr; Back to Cities
</a>
@endsection

@section('content')
<div class="card" style="max-width:960px; margin:0 auto;">
    <div class="card-header">
        <h2 class="card-title">Localized Testing Content &amp; Meta Tags</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.cities.update', $city) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:16px;">
                <div class="form-group">
                    <label class="form-label" for="name">City Name *</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $city->name) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">State</label>
                    <input type="text" class="form-control" value="{{ $city->state->name }} ({{ $city->state->abbr }})" disabled style="background:#F1F5F9;">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="meta_title">SEO Title (Title Tag)</label>
                <input type="text" id="meta_title" name="meta_title" class="form-control" value="{{ old('meta_title', $city->meta_title) }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="meta_description">Meta Description</label>
                <textarea id="meta_description" name="meta_description" rows="2" class="form-control">{{ old('meta_description', $city->meta_description) }}</textarea>
            </div>

            <div class="form-group">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                    <label class="form-label" for="content" style="margin:0;">Localized City Guide (HTML)</label>
                    <span style="font-size:12px; color:#64748B;">Supports full HTML formatting and headings</span>
                </div>
                <textarea id="content" name="content" rows="12" class="form-control" style="font-family:monospace; font-size:13px; line-height:1.6;">{{ old('content', $city->content) }}</textarea>
            </div>

            <div class="form-group">
                <label style="display:inline-flex; align-items:center; gap:8px; font-weight:600; cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $city->is_active) ? 'checked' : '' }}>
                    City Landing Page Active &amp; Indexed
                </label>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:24px;">
                <a href="{{ route('admin.cities.index') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Save City SEO Guide</button>
            </div>
        </form>
    </div>
</div>
@endsection
