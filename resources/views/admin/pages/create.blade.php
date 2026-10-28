@extends('admin.layouts.app', ['title' => 'Create CMS Page', 'heading' => 'Create New CMS Page'])

@section('topbar_actions')
<a href="{{ route('admin.pages.index') }}" class="btn btn-outline btn-sm">
    &larr; Back to Pages
</a>
@endsection

@section('content')
<form action="{{ route('admin.pages.store') }}" method="POST">
    @csrf

    <div style="display:grid; grid-template-columns:2.5fr 1fr; gap:24px;">
        <div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Page Content &amp; Details</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="title">Page Title *</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" placeholder="e.g. Corporate Drug Free Workplace Program" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="page_heading">H1 Main Page Heading</label>
                        <input type="text" id="page_heading" name="page_heading" value="{{ old('page_heading') }}" class="form-control" placeholder="Main banner headline">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="content">Page Body Content (HTML &amp; Text)</label>
                        <textarea id="content" name="content" rows="14" class="form-control" placeholder="Enter paragraph text, headings, bullet lists, or embed HTML...">{{ old('content') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="featured_image">Featured Photo URL</label>
                        <input type="text" id="featured_image" name="featured_image" value="{{ old('featured_image') }}" class="form-control" placeholder="e.g. /images/lab-facility.jpg">
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
                        <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" class="form-control" placeholder="Leave blank to auto-generate from title">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="meta_description">Meta Description Tag</label>
                        <textarea id="meta_description" name="meta_description" rows="3" class="form-control" placeholder="Short compelling summary for Google snippet...">{{ old('meta_description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="canonical_url">Canonical URL</label>
                        <input type="text" id="canonical_url" name="canonical_url" value="{{ old('canonical_url') }}" class="form-control" placeholder="auto-generated">
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Publishing &amp; Status</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="slug">URL Slug</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug') }}" class="form-control" placeholder="auto-generated-from-title">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="template">Layout Template</label>
                        <select id="template" name="template" class="form-control">
                            <option value="default">Standard Corporate (Option 2)</option>
                            <option value="wide">Full-Width Clean</option>
                            <option value="landing">Direct-to-Test Landing</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label style="display:flex; align-items:center; gap:8px; font-weight:600; cursor:pointer;">
                            <input type="checkbox" name="is_published" value="1" checked>
                            <span>Publish Live</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label style="display:flex; align-items:center; gap:8px; font-weight:600; cursor:pointer;">
                            <input type="checkbox" name="show_in_menu" value="1">
                            <span>Show in Header Navigation</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:12px; margin-top:12px;">
                        Create Page
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
