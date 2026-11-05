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
                        <select id="template" name="template" class="form-control" onchange="handleTemplateChange(this.value)">
                            <option value="default" {{ old('template') == 'default' ? 'selected' : '' }}>Standard Corporate (with Sidebar)</option>
                            <option value="wide" {{ old('template') == 'wide' ? 'selected' : '' }}>Full-Width Clean (No Sidebar)</option>
                            <option value="landing" {{ old('template') == 'landing' ? 'selected' : '' }}>Full-Screen Landing (100% Width, No Sidebar, No Hero)</option>
                            <option value="fullscreen" {{ old('template') == 'fullscreen' ? 'selected' : '' }}>Full-Screen Clean (100% Width, No Sidebar)</option>
                        </select>
                    </div>

                    <input type="hidden" name="show_sidebar_submitted" value="1">
                    <input type="hidden" name="show_hero_submitted" value="1">
                    <input type="hidden" name="full_width_submitted" value="1">

                    <div class="form-group" style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:12px; margin-top:12px;">
                        <div style="font-size:12px; font-weight:700; color:#0B2545; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                            Layout &amp; Sidebar Controls
                        </div>

                        <label style="display:flex; align-items:flex-start; gap:8px; font-size:13px; font-weight:600; cursor:pointer; margin-bottom:8px;">
                            <input type="checkbox" id="toggle_show_sidebar" name="show_sidebar" value="1" {{ old('show_sidebar', '1') == '1' ? 'checked' : '' }}>
                            <span>
                                Show Sidebar (Popular Tests &amp; Categories)
                                <small style="display:block; font-size:11px; color:#64748B; font-weight:400;">Uncheck to remove side panel and give content full width</small>
                            </span>
                        </label>

                        <label style="display:flex; align-items:flex-start; gap:8px; font-size:13px; font-weight:600; cursor:pointer; margin-bottom:8px;">
                            <input type="checkbox" id="toggle_show_hero" name="show_hero" value="1" {{ old('show_hero', '1') == '1' ? 'checked' : '' }}>
                            <span>
                                Show Top Hero Header Bar
                                <small style="display:block; font-size:11px; color:#64748B; font-weight:400;">Uncheck if your custom HTML contains its own header</small>
                            </span>
                        </label>

                        <label style="display:flex; align-items:flex-start; gap:8px; font-size:13px; font-weight:600; cursor:pointer;">
                            <input type="checkbox" id="toggle_full_width" name="full_width" value="1" {{ old('full_width') == '1' ? 'checked' : '' }}>
                            <span>
                                Full-Screen Fluid (100% Edge-to-Edge)
                                <small style="display:block; font-size:11px; color:#64748B; font-weight:400;">Removes container boundaries for custom full-screen HTML</small>
                            </span>
                        </label>
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

<script>
function handleTemplateChange(template) {
    const sidebar = document.getElementById('toggle_show_sidebar');
    const hero = document.getElementById('toggle_show_hero');
    const fullWidth = document.getElementById('toggle_full_width');

    if (template === 'default') {
        if (sidebar) sidebar.checked = true;
        if (hero) hero.checked = true;
        if (fullWidth) fullWidth.checked = false;
    } else if (template === 'wide') {
        if (sidebar) sidebar.checked = false;
        if (hero) hero.checked = true;
        if (fullWidth) fullWidth.checked = false;
    } else if (template === 'landing') {
        if (sidebar) sidebar.checked = false;
        if (hero) hero.checked = false;
        if (fullWidth) fullWidth.checked = true;
    } else if (template === 'fullscreen') {
        if (sidebar) sidebar.checked = false;
        if (hero) hero.checked = true;
        if (fullWidth) fullWidth.checked = true;
    }
}
</script>
@endsection
