@extends('admin.layouts.app', ['title' => 'Create Category', 'heading' => 'Create New Category'])

@section('topbar_actions')
<a href="{{ route('admin.categories.index') }}" class="btn btn-outline btn-sm">
    &larr; Back to Categories
</a>
@endsection

@section('content')
<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf

    <div style="display:grid; grid-template-columns:2fr 1fr; gap:24px;">
        <div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Category Details</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="name">Internal Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" placeholder="e.g. Rapid Testing" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="display_name">Public Display Name</label>
                        <input type="text" id="display_name" name="display_name" value="{{ old('display_name') }}" class="form-control" placeholder="e.g. Instant Rapid Drug Testing Options">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="slug">URL Slug</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug') }}" class="form-control" placeholder="auto-generated-from-name">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="subtitle">Subtitle / Tagline</label>
                        <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="description">Category Overview &amp; Description</label>
                        <textarea id="description" name="description" rows="5" class="form-control">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">100% SEO Configuration</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="meta_title">Meta Title Tag</label>
                        <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="meta_description">Meta Description Tag</label>
                        <textarea id="meta_description" name="meta_description" rows="3" class="form-control">{{ old('meta_description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="canonical_url">Canonical URL</label>
                        <input type="text" id="canonical_url" name="canonical_url" value="{{ old('canonical_url') }}" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Settings</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="position">Display Order Position</label>
                        <input type="number" id="position" name="position" value="{{ old('position', 10) }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label style="display:flex; align-items:center; gap:8px; font-weight:600; cursor:pointer;">
                            <input type="checkbox" name="is_active" value="1" checked>
                            <span>Active / Visible on Frontend</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:12px; margin-top:12px;">
                        Create Category
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
