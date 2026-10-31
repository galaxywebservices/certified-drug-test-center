@extends('admin.layouts.app', ['title' => 'Page Editor & Builder', 'heading' => 'Editor: ' . $page->title])

@section('topbar_actions')
<a href="{{ url('/admin/pagebuilder?action=edit&page=' . ($pbPageId ?? 1)) }}" target="_blank" class="btn btn-sm" style="background:#e85b24; border-color:#d44d18; color:#fff; display:inline-flex; align-items:center; gap:6px; font-weight:700; box-shadow:0 2px 4px rgba(232,91,36,0.25);">
    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg>
    Launch Visual PageBuilder
</a>
<a href="{{ url('/' . $page->slug) }}" target="_blank" class="btn btn-outline btn-sm">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
    View Live Page
</a>
<a href="{{ route('admin.pages.index') }}" class="btn btn-outline btn-sm">
    &larr; Back to Pages
</a>
@endsection

@section('content')
<style>
    /* Builder Tabs */
    .tab-nav {
        display: flex;
        border-bottom: 2px solid var(--admin-slate-200);
        margin-bottom: 24px;
        gap: 8px;
    }

    .tab-btn {
        padding: 12px 20px;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        color: var(--admin-slate-500);
        background: transparent;
        border: none;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .tab-btn:hover { color: var(--admin-navy); }
    .tab-btn.active {
        color: var(--admin-navy);
        border-bottom-color: var(--admin-crimson);
        font-weight: 700;
    }

    .tab-content { display: none; }
    .tab-content.active { display: block; }

    /* SERP Google Preview Box */
    .google-serp-preview {
        background: #fff;
        border: 1px solid #DFE1E5;
        border-radius: 8px;
        padding: 18px 20px;
        margin-top: 14px;
        box-shadow: 0 1px 6px rgba(32,33,36,0.08);
        font-family: Arial, sans-serif;
    }

    .serp-url {
        font-size: 12px;
        color: #202124;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 4px;
    }

    .serp-title {
        font-size: 19px;
        color: #1a0dab;
        font-weight: 400;
        text-decoration: none;
        line-height: 1.3;
        cursor: pointer;
    }
    .serp-title:hover { text-decoration: underline; }

    .serp-desc {
        font-size: 14px;
        color: #4d5156;
        line-height: 1.58;
        margin-top: 4px;
        word-wrap: break-word;
    }

    /* Block Builder Cards */
    .block-card {
        background: #fff;
        border: 1px solid var(--admin-slate-200);
        border-radius: 8px;
        margin-bottom: 16px;
        overflow: hidden;
    }

    .block-header {
        background: var(--admin-slate-50);
        padding: 12px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--admin-slate-200);
        cursor: grab;
    }

    /* Editor Layout Grid */
    .editor-grid {
        display: grid;
        grid-template-columns: 2.5fr 1fr;
        gap: 24px;
        align-items: start;
    }
    @media (max-width: 1024px) {
        .editor-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<form action="{{ route('admin.pages.update', $page) }}" method="POST" id="pageEditorForm" novalidate>
    @csrf
    @method('PUT')

    <div class="editor-grid">
        <!-- Left Column: Tabs & Editors -->
        <div>
            <!-- Navigation Tabs -->
            <div class="tab-nav">
                <button type="button" class="tab-btn active" onclick="switchTab('tab-content', this)">
                    📝 Rich Content &amp; Text
                </button>
                <button type="button" class="tab-btn" onclick="switchTab('tab-builder', this)">
                    🎨 Visual PageBuilder (ATA / GrapesJS)
                </button>
                <button type="button" class="tab-btn" onclick="switchTab('tab-seo', this)">
                    🚀 100% SEO &amp; SERP Preview
                </button>
            </div>

            <!-- TAB 1: Rich Content & Text (Direct HTML for all migrated pages) -->
            <div id="tab-content" class="tab-content active">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Page Headings &amp; Body Content</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label" for="title">Page Title (Navigation &amp; System) *</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $page->title) }}" class="form-control" required oninput="updateSerpPreview()">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="page_heading">H1 Main Page Heading</label>
                            <input type="text" id="page_heading" name="page_heading" value="{{ old('page_heading', $page->page_heading) }}" class="form-control" placeholder="Shown in the hero header">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="content">Page Content (WYSIWYG &amp; HTML Editor)</label>
                            
                            <!-- Formatting & Photo Toolbar -->
                            <div style="background:#F1F5F9; border:1px solid #CBD5E1; border-bottom:none; border-radius:6px 6px 0 0; padding:8px 12px; display:flex; gap:6px; flex-wrap:wrap; align-items:center;">
                                <button type="button" class="btn btn-outline btn-sm" onclick="insertTag('<h2>', '</h2>')" title="Heading 2"><strong>H2</strong></button>
                                <button type="button" class="btn btn-outline btn-sm" onclick="insertTag('<h3>', '</h3>')" title="Heading 3"><strong>H3</strong></button>
                                <button type="button" class="btn btn-outline btn-sm" onclick="insertTag('<strong>', '</strong>')" title="Bold"><strong>B</strong></button>
                                <button type="button" class="btn btn-outline btn-sm" onclick="insertTag('<em>', '</em>')" title="Italic"><em>I</em></button>
                                <button type="button" class="btn btn-outline btn-sm" onclick="insertTag('<p>', '</p>')" title="Paragraph">¶</button>
                                <button type="button" class="btn btn-outline btn-sm" onclick="insertTag('<ul>\n  <li>', '</li>\n</ul>')" title="Bullet List">• List</button>
                                <button type="button" class="btn btn-outline btn-sm" onclick="insertLink()" title="Insert Link">🔗 Link</button>
                                <button type="button" class="btn btn-navy btn-sm" onclick="document.getElementById('photoUploadInput').click()" title="Upload Photo to Server">
                                    📷 Upload &amp; Insert Photo
                                </button>
                                <input type="file" id="photoUploadInput" accept="image/*" style="display:none;" onchange="handlePhotoUpload(this)">
                                <span id="uploadStatusText" style="font-size:12px; color:#0B2545; font-weight:600;"></span>
                            </div>

                            <textarea id="content" name="content" rows="18" class="form-control" style="border-radius:0 0 6px 6px; font-family:monospace; font-size:13px; line-height:1.5;">{{ old('content', $page->content) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="featured_image">Featured Photo URL</label>
                            <input type="text" id="featured_image" name="featured_image" value="{{ old('featured_image', $page->featured_image) }}" class="form-control" placeholder="e.g. /images/testing-lab.jpg">
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: Visual Drag & Drop Page Builder (Identical to ATA LMS) -->
            <div id="tab-builder" class="tab-content">
                <div class="card" style="border: 2px solid #e85b24; overflow:hidden;">
                    <div class="card-header" style="background: linear-gradient(135deg, #0B2545 0%, #133E68 100%); color:#fff; padding:18px 24px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                        <div>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <h2 class="card-title" style="color:#fff; margin:0; font-size:17px; display:flex; align-items:center; gap:8px;">
                                    <svg width="20" height="20" fill="none" stroke="#e85b24" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg>
                                    ATA LMS Drag &amp; Drop Visual PageBuilder
                                </h2>
                                <span class="badge" style="background:#e85b24; color:#fff; font-weight:700; font-size:11px; padding:3px 9px;">GrapesJS Engine</span>
                            </div>
                            <p style="font-size:13px; color:#cbd5e1; margin-top:4px; margin-bottom:0;">
                                Build high-converting landing pages with 14 modular drag-and-drop blocks across 4 categories.
                            </p>
                        </div>
                        <div style="display:flex; gap:10px; align-items:center;">
                            <span style="font-size:12px; color:#94a3b8; font-weight:600;">
                                Page ID: #{{ $page->id }} &bull; PB: #{{ $pbPageId ?? 1 }}
                            </span>
                            <a href="{{ url('/admin/pagebuilder?action=edit&page=' . ($pbPageId ?? 1)) }}" target="_blank" class="btn btn-sm" style="background:#e85b24; border-color:#d44d18; color:#fff; font-weight:700; display:inline-flex; align-items:center; gap:8px; padding:8px 16px; border-radius:6px; box-shadow:0 4px 12px rgba(232,91,36,0.35);">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                Launch Fullscreen PageBuilder
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body" style="padding:20px;">
                        <!-- Block Catalog Quick Reference identical to ATA LMS -->
                        <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:16px; margin-bottom:18px;">
                            <div style="font-size:12px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:10px; display:flex; justify-content:space-between; align-items:center;">
                                <span>📦 Available Modular Blocks (14 Components)</span>
                                <span style="font-size:11px; color:#64748b; font-weight:500;">Directly selectable inside the left sidebar drawer</span>
                            </div>
                            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(210px, 1fr)); gap:12px; font-size:12px;">
                                <div style="background:#fff; border:1px solid #cbd5e1; border-radius:6px; padding:10px;">
                                    <strong style="color:#0B2545; display:block; margin-bottom:4px;">Content (7 Blocks)</strong>
                                    <span style="color:#64748b; line-height:1.4; display:block;">CTA Band, How It Works, Content Area, Testimonials, Features Grid, Stats Ribbon, Custom HTML</span>
                                </div>
                                <div style="background:#fff; border:1px solid #cbd5e1; border-radius:6px; padding:10px;">
                                    <strong style="color:#0B2545; display:block; margin-bottom:4px;">Header (4 Blocks)</strong>
                                    <span style="color:#64748b; line-height:1.4; display:block;">Hero Video Banner, Conference Banner, Lab Screening Hero Banner, Top Banner</span>
                                </div>
                                <div style="background:#fff; border:1px solid #cbd5e1; border-radius:6px; padding:10px;">
                                    <strong style="color:#0B2545; display:block; margin-bottom:4px;">Dynamic Content (2 Blocks)</strong>
                                    <span style="color:#64748b; line-height:1.4; display:block;">Dynamic Blogs (live posts), Dynamic Courses/Products (drug testing services)</span>
                                </div>
                                <div style="background:#fff; border:1px solid #cbd5e1; border-radius:6px; padding:10px;">
                                    <strong style="color:#0B2545; display:block; margin-bottom:4px;">Media (1 Block)</strong>
                                    <span style="color:#64748b; line-height:1.4; display:block;">Image Banner (full-width image with responsive scaling)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Live Interactive PageBuilder Container -->
                        <div style="position:relative; background:#2B303A; border-radius:8px; overflow:hidden; box-shadow:0 8px 24px rgba(0,0,0,0.12);">
                            <div style="background:#1E2229; padding:8px 16px; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #3d4451;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="display:inline-block; width:10px; height:10px; border-radius:50%; background:#ef4444;"></span>
                                    <span style="display:inline-block; width:10px; height:10px; border-radius:50%; background:#f59e0b;"></span>
                                    <span style="display:inline-block; width:10px; height:10px; border-radius:50%; background:#10b981;"></span>
                                    <span style="color:#94a3b8; font-size:12px; margin-left:8px; font-family:monospace;">
                                        /admin/pagebuilder?action=edit&amp;page={{ $pbPageId ?? 1 }}
                                    </span>
                                </div>
                                <div style="display:flex; gap:8px;">
                                    <button type="button" class="btn btn-sm btn-outline" onclick="document.getElementById('pbIframe').src = document.getElementById('pbIframe').src" style="color:#fff; border-color:#475569; font-size:11px; padding:3px 8px;">
                                        🔄 Reload Builder
                                    </button>
                                    <a href="{{ url('/admin/pagebuilder?action=edit&page=' . ($pbPageId ?? 1)) }}" target="_blank" class="btn btn-sm" style="background:#e85b24; color:#fff; font-size:11px; padding:3px 10px; font-weight:600;">
                                        ↗ Open in Full Screen
                                    </a>
                                </div>
                            </div>
                            <iframe id="pbIframe" src="{{ url('/admin/pagebuilder?action=edit&page=' . ($pbPageId ?? 1)) }}" style="width:100%; height:760px; border:none; display:block; background:#fff;" loading="lazy"></iframe>
                        </div>

                        <div style="margin-top:14px; font-size:12px; color:#64748b; display:flex; align-items:center; gap:6px;">
                            <svg width="16" height="16" fill="none" stroke="#10b981" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            <span><strong>Instant Auto-Sync:</strong> Changes saved via the Visual PageBuilder ("Save" button at bottom-left) are automatically compiled and synchronized to this page's live HTML.</span>
                        </div>

                        <input type="hidden" name="blocks_json" id="blocksJsonInput" value="{{ json_encode($page->blocks_json) }}">
                    </div>
                </div>
            </div>

            <!-- TAB 3: 100% SEO Suite & Google SERP Simulator -->
            <div id="tab-seo" class="tab-content">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-title">100% Search Engine Optimization (SEO)</h2>
                            <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                                Control how this page appears on Google search results.
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Live Google Desktop SERP Simulator -->
                        <div style="font-size:12px; font-weight:700; text-transform:uppercase; color:var(--admin-slate-500); letter-spacing:0.5px;">
                            Live Google SERP Snippet Preview
                        </div>
                        <div class="google-serp-preview">
                            <div class="serp-url">
                                <span>https://certifieddrugtesting.com</span>
                                <span>›</span>
                                <span id="serpSlugPreview">{{ $page->slug }}</span>
                            </div>
                            <div class="serp-title" id="serpTitlePreview">
                                {{ $page->meta_title ?: ($page->title . ' | Certified Drug Test Center') }}
                            </div>
                            <div class="serp-desc" id="serpDescPreview">
                                {{ $page->meta_description ?: 'Accredited nationwide drug and alcohol testing collection facilities. Order online in 2 minutes with instant donor pass.' }}
                            </div>
                        </div>

                        <div style="margin-top:24px;">
                            <div class="form-group">
                                <div style="display:flex; justify-content:space-between;">
                                    <label class="form-label" for="meta_title">Meta Title Tag *</label>
                                    <small id="metaTitleCount" style="color:#64748B;">{{ strlen($page->meta_title ?? '') }}/60 chars</small>
                                </div>
                                <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" class="form-control" oninput="updateSerpPreview()">
                                <div class="form-hint">Optimal length: 50 - 60 characters for maximum Google visibility.</div>
                            </div>

                            <div class="form-group">
                                <div style="display:flex; justify-content:space-between;">
                                    <label class="form-label" for="meta_description">Meta Description Tag *</label>
                                    <small id="metaDescCount" style="color:#64748B;">{{ strlen($page->meta_description ?? '') }}/160 chars</small>
                                </div>
                                <textarea id="meta_description" name="meta_description" rows="3" class="form-control" oninput="updateSerpPreview()">{{ old('meta_description', $page->meta_description) }}</textarea>
                                <div class="form-hint">Optimal length: 140 - 160 characters. Compelling summary to drive click-through rate.</div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="canonical_url">Canonical URL</label>
                                <input type="text" id="canonical_url" name="canonical_url" value="{{ old('canonical_url', $page->canonical_url) }}" class="form-control" placeholder="{{ url('/' . $page->slug) }}">
                                <div class="form-hint">Prevents duplicate content penalties by pointing search engines to the primary URL.</div>
                            </div>

                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                                <div class="form-group">
                                    <label class="form-label">Robots Indexing</label>
                                    <label style="display:flex; align-items:center; gap:8px; font-size:13px; cursor:pointer;">
                                        <input type="checkbox" name="robots_index" value="1" {{ $page->robots_index ? 'checked' : '' }}>
                                        <span>Allow search engines to index this page (index)</span>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Robots Link Following</label>
                                    <label style="display:flex; align-items:center; gap:8px; font-size:13px; cursor:pointer;">
                                        <input type="checkbox" name="robots_follow" value="1" {{ $page->robots_follow ? 'checked' : '' }}>
                                        <span>Allow search engines to follow page links (follow)</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Publishing Controls & URL Structure -->
        <div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Publishing &amp; Status</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="slug">URL Slug *</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $page->slug) }}" class="form-control" required oninput="updateSerpPreview()">
                        <div class="form-hint">Live URL: <code>/{{ $page->slug }}</code></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="template">Page Layout Template</label>
                        <select id="template" name="template" class="form-control">
                            <option value="default" {{ $page->template == 'default' ? 'selected' : '' }}>Standard Corporate (Option 2)</option>
                            <option value="wide" {{ $page->template == 'wide' ? 'selected' : '' }}>Full-Width Clean</option>
                            <option value="landing" {{ $page->template == 'landing' ? 'selected' : '' }}>Direct-to-Test Landing</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label style="display:flex; align-items:center; gap:8px; font-weight:600; cursor:pointer;">
                            <input type="checkbox" name="is_published" value="1" {{ $page->is_published ? 'checked' : '' }}>
                            <span>Publish Live (Visible on Site)</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label style="display:flex; align-items:center; gap:8px; font-weight:600; cursor:pointer;">
                            <input type="checkbox" name="show_in_menu" value="1" {{ $page->show_in_menu ? 'checked' : '' }}>
                            <span>Show in Header Navigation</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:12px; margin-top:12px;">
                        Save Page Changes
                    </button>
                </div>
            </div>

            <!-- Page Meta Info -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Page Metadata</h2>
                </div>
                <div class="card-body" style="font-size:13px; color:var(--admin-slate-700); line-height:1.7;">
                    <div><strong>Page ID:</strong> #{{ $page->id }}</div>
                    <div><strong>Created:</strong> {{ $page->created_at ? $page->created_at->format('M d, Y') : 'Migrated' }}</div>
                    <div><strong>Last Updated:</strong> {{ $page->updated_at ? $page->updated_at->format('M d, Y H:i') : 'N/A' }}</div>
                    <div><strong>Sitemap Priority:</strong> 0.70</div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function switchTab(tabId, btn) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

        if (btn) {
            btn.classList.add('active');
        }
        const target = document.getElementById(tabId);
        if (target) {
            target.classList.add('active');
        }
    }

    // Auto-serialize block builder on save
    document.getElementById('pageEditorForm').addEventListener('submit', function (e) {
        const titleInput = document.getElementById('title');
        if (!titleInput.value.trim()) {
            e.preventDefault();
            switchTab('tab-content', document.querySelector('.tab-btn'));
            titleInput.focus();
            alert('Please enter a Page Title.');
            return false;
        }

        const heroHeadline = document.getElementById('blockHeroHeadline')?.value;
        const heroSub = document.getElementById('blockHeroSubheadline')?.value;
        const heroBtn = document.getElementById('blockHeroBtnText')?.value;
        const heroUrl = document.getElementById('blockHeroBtnUrl')?.value;

        const blocks = [];
        if (heroHeadline) {
            blocks.push({
                type: 'hero',
                headline: heroHeadline,
                subheadline: heroSub,
                btn_text: heroBtn,
                btn_url: heroUrl
            });
        }

        const faqItems = [];
        const faqQuestions = document.querySelectorAll('.faq-question-input');
        const faqAnswers = document.querySelectorAll('.faq-answer-input');
        faqQuestions.forEach((qInput, i) => {
            const q = qInput.value.trim();
            const a = faqAnswers[i]?.value.trim();
            if (q && a) {
                faqItems.push({ question: q, answer: a });
            }
        });
        if (faqItems.length > 0) {
            blocks.push({
                type: 'faq',
                items: faqItems
            });
        }

        const ctaTitle = document.getElementById('blockCtaTitle')?.value;
        const ctaPhone = document.getElementById('blockCtaPhone')?.value;
        if (ctaTitle) {
            blocks.push({
                type: 'cta',
                title: ctaTitle,
                btn_text: 'Call ' + (ctaPhone || '(800)-985-4339'),
                btn_url: 'tel:' + (ctaPhone || '18009854339').replace(/\D/g, '')
            });
        }

        if (blocks.length > 0) {
            document.getElementById('blocksJsonInput').value = JSON.stringify(blocks);
        }
    });

    function updateSerpPreview() {
        const titleInput = document.getElementById('meta_title');
        const descInput = document.getElementById('meta_description');
        const pageTitleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');

        const titleVal = titleInput.value.trim() || (pageTitleInput.value.trim() + ' | Certified Drug Test Center');
        const descVal = descInput.value.trim() || 'Accredited nationwide drug and alcohol testing collection facilities. Order online in 2 minutes with instant donor pass.';
        const slugVal = slugInput.value.trim() || 'page';

        document.getElementById('serpTitlePreview').textContent = titleVal;
        document.getElementById('serpDescPreview').textContent = descVal;
        document.getElementById('serpSlugPreview').textContent = slugVal;

        // Character counts
        document.getElementById('metaTitleCount').textContent = titleInput.value.length + '/60 chars';
        document.getElementById('metaDescCount').textContent = descInput.value.length + '/160 chars';
    }

    function insertTag(startTag, endTag) {
        const textarea = document.getElementById('content');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selectedText = textarea.value.substring(start, end) || 'Sample text';
        const replacement = startTag + selectedText + endTag;
        
        textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end);
        textarea.focus();
        textarea.setSelectionRange(start + startTag.length, start + startTag.length + selectedText.length);
    }

    function insertLink() {
        const url = prompt('Enter Destination URL:', 'https://');
        if (!url) return;
        const label = prompt('Enter Link Text:', 'Click Here') || url;
        const html = `<a href="${url}">${label}</a>`;
        
        const textarea = document.getElementById('content');
        const start = textarea.selectionStart;
        textarea.value = textarea.value.substring(0, start) + html + textarea.value.substring(start);
        textarea.focus();
    }

    function handlePhotoUpload(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', '{{ csrf_token() }}');

        const statusText = document.getElementById('uploadStatusText');
        statusText.textContent = '⏳ Uploading ' + file.name + '...';

        fetch('{{ route("admin.media.upload") }}', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.url) {
                statusText.textContent = '✅ Inserted!';
                setTimeout(() => statusText.textContent = '', 3000);
                
                const imgHtml = `\n<div style="text-align:center; margin:20px 0;">\n  <img src="${data.url}" alt="${file.name}" style="max-width:100%; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">\n</div>\n`;
                const textarea = document.getElementById('content');
                const start = textarea.selectionStart;
                textarea.value = textarea.value.substring(0, start) + imgHtml + textarea.value.substring(start);
                textarea.focus();
            } else {
                alert('Upload failed: ' + (data.message || 'Server error'));
                statusText.textContent = '';
            }
        })
        .catch(err => {
            alert('Upload error: ' + err.message);
            statusText.textContent = '';
        });
    }
</script>
@endsection
