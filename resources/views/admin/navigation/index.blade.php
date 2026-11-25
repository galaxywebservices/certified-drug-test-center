@extends('admin.layouts.app', ['title' => 'Navigation Menu Management', 'heading' => 'Header Navigation & Toolbar Management'])

@section('topbar_actions')
<a href="{{ url('/') }}" target="_blank" class="btn btn-outline btn-sm">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
    View Live Website
</a>
<form action="{{ route('admin.navigation.reset-default') }}" method="POST" style="display:inline;" onsubmit="return confirm('Reset navigation to the default Certified Drug Test Centers menu structure? This will restore the standard toolbar and category dropdowns.');">
    @csrf
    <button type="submit" class="btn btn-outline btn-sm" style="color:#C1121F; border-color:#FCA5A5;">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
        Reset Defaults
    </button>
</form>
<button type="button" class="btn btn-primary btn-sm" onclick="openAddModal()">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
    + Add Menu Item
</button>
@endsection

@section('content')
<style>
    .nav-manager-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 24px;
        align-items: start;
    }
    @media (max-width: 1080px) {
        .nav-manager-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Menu Tree Styling */
    .menu-tree-container {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .parent-menu-card {
        background: #FFFFFF;
        border: 1px solid var(--admin-slate-200);
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        transition: all 0.15s ease;
        overflow: hidden;
    }
    .parent-menu-card:hover {
        border-color: var(--admin-slate-300);
    }
    .parent-menu-card.is-dragging {
        opacity: 0.5;
        background: #F1F5F9;
    }

    .parent-header {
        background: #FFFFFF;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        border-bottom: 1px solid transparent;
    }
    .parent-menu-card.has-children .parent-header {
        border-bottom-color: var(--admin-slate-100);
    }

    .drag-handle {
        cursor: grab;
        color: var(--admin-slate-400);
        display: flex;
        align-items: center;
        padding: 4px;
        user-select: none;
    }
    .drag-handle:hover { color: var(--admin-navy); }
    .drag-handle:active { cursor: grabbing; }

    .menu-item-info {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-grow: 1;
        min-width: 0;
    }

    .menu-title-text {
        font-weight: 700;
        font-size: 14px;
        color: var(--admin-navy);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .menu-url-pill {
        font-size: 11px;
        font-family: monospace;
        color: var(--admin-slate-500);
        background: var(--admin-slate-100);
        padding: 2px 8px;
        border-radius: 4px;
        max-width: 240px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .menu-actions {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }

    /* Submenu items list */
    .submenu-list {
        background: #F8FAFC;
        padding: 8px 14px 12px 34px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        min-height: 10px;
    }

    .submenu-item-card {
        background: #FFFFFF;
        border: 1px solid var(--admin-slate-200);
        border-radius: 6px;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }
    .submenu-item-card:hover {
        border-color: #CBD5E1;
    }
    .submenu-item-card.is-dragging {
        opacity: 0.5;
        background: #E2E8F0;
    }

    .status-toggle {
        cursor: pointer;
        background: transparent;
        border: none;
        padding: 0;
        display: inline-flex;
        align-items: center;
    }

    /* Floating Toast */
    #navToast {
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: var(--admin-navy);
        color: #fff;
        padding: 12px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 16px rgba(11,37,69,0.3);
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.25s ease, transform 0.25s ease;
        transform: translateY(10px);
        z-index: 9999;
    }
    #navToast.show {
        opacity: 1;
        pointer-events: auto;
        transform: translateY(0);
    }

    /* Modal Backdrop */
    .admin-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        padding: 16px;
    }
    .admin-modal-backdrop.open {
        display: flex;
    }
    .admin-modal-card {
        background: #fff;
        border-radius: 12px;
        width: 100%;
        max-width: 520px;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        overflow: hidden;
    }
</style>

<!-- Live Notification Toast -->
<div id="navToast">
    <svg width="18" height="18" fill="none" stroke="#10B981" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
    <span id="navToastMessage">Order updated successfully</span>
</div>

<!-- Info Banner -->
<div style="background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%); color:#fff; border-radius:10px; padding:18px 24px; margin-bottom:24px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
    <div>
        <div style="display:flex; align-items:center; gap:8px;">
            <span style="background:rgba(255,255,255,0.2); font-size:12px; font-weight:700; padding:2px 8px; border-radius:4px; text-transform:uppercase;">Live Navbar Sync</span>
            <h2 style="font-size:17px; font-weight:700; color:#fff; margin:0;">Dynamic Primary Navigation Toolbar</h2>
        </div>
        <p style="font-size:13px; color:#CBD5E1; margin-top:6px; margin-bottom:0; max-width:820px; line-height:1.5;">
            Manage all toolbar links and dropdown submenus shown to nationwide visitors. Drag and drop items to re-order or move between submenus. Any new CMS page created can be instantly pinned to any dropdown menu.
        </p>
    </div>
    <div style="display:flex; gap:10px;">
        <span class="badge" style="background:rgba(255,255,255,0.15); color:#fff; font-size:12px; padding:6px 12px;">
            <strong>{{ $items->count() }}</strong> Top Menu Items
        </span>
        <span class="badge" style="background:rgba(255,255,255,0.15); color:#fff; font-size:12px; padding:6px 12px;">
            <strong>{{ $items->sum(fn($i) => $i->children->count()) }}</strong> Submenu Links
        </span>
    </div>
</div>

<div class="nav-manager-grid">
    <!-- Left Column: Interactive Navigation Hierarchy (Drag & Drop) -->
    <div>
        <div class="card">
            <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <h2 class="card-title" style="margin:0; font-size:16px;">Navigation Menu Structure</h2>
                    <p style="font-size:12px; color:var(--admin-slate-500); margin-top:2px; margin-bottom:0;">
                        Drag items by the ⠿ handle to re-order. Click ➕ to add a submenu item under any parent.
                    </p>
                </div>
                <div style="font-size:12px; color:var(--admin-slate-500); display:flex; align-items:center; gap:6px;">
                    <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#10B981;"></span>
                    <span>Auto-saves on drag</span>
                </div>
            </div>

            <div class="card-body" style="padding:16px;">
                <div class="menu-tree-container" id="topLevelSortable">
                    @forelse($items as $topItem)
                    <div class="parent-menu-card {{ $topItem->children->count() > 0 ? 'has-children' : '' }}" data-id="{{ $topItem->id }}">
                        <!-- Top-Level Item Row -->
                        <div class="parent-header">
                            <div class="drag-handle" title="Drag to reorder top-level menu">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 9h.01M8 15h.01M16 9h.01M16 15h.01M12 9h.01M12 15h.01"></path></svg>
                            </div>

                            <div class="menu-item-info">
                                <span class="badge" style="background:#0B2545; color:#fff; font-size:11px; font-weight:700;">Top Menu</span>
                                <span class="menu-title-text">{{ $topItem->title }}</span>
                                <span class="menu-url-pill" title="{{ $topItem->href }}">{{ $topItem->url ?: ($topItem->page ? '/' . $topItem->page->slug : '#') }}</span>
                                @if($topItem->page)
                                    <span class="badge badge-info" style="font-size:10px;">CMS Page #{{ $topItem->page->id }}</span>
                                @endif
                                @if($topItem->target === '_blank')
                                    <span class="badge badge-neutral" style="font-size:10px;" title="Opens in new tab">↗ New Tab</span>
                                @endif
                                @if($topItem->css_class === 'nav-item-employer')
                                    <span class="badge" style="background:#FEF3C7; color:#B45309; font-size:10px;">Gold Accent</span>
                                @endif
                            </div>

                            <div class="menu-actions">
                                <!-- Move Up / Move Down Click Fallbacks -->
                                <button type="button" class="action-btn" title="Move Up" onclick="moveItem({{ $topItem->id }}, -1)">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path></svg>
                                </button>
                                <button type="button" class="action-btn" title="Move Down" onclick="moveItem({{ $topItem->id }}, 1)">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                </button>

                                <!-- Toggle Active Switch -->
                                <button type="button" class="status-toggle" onclick="toggleActive({{ $topItem->id }}, this)" title="{{ $topItem->is_active ? 'Active (Click to hide from site)' : 'Hidden (Click to show on site)' }}">
                                    @if($topItem->is_active)
                                        <span class="badge badge-success" style="font-size:11px;">Active</span>
                                    @else
                                        <span class="badge badge-neutral" style="font-size:11px;">Hidden</span>
                                    @endif
                                </button>

                                <!-- Add Sub-Item Button -->
                                <button type="button" class="btn btn-outline btn-sm" style="padding:4px 8px; font-size:11px;" onclick="openAddModal({{ $topItem->id }}, '{{ addslashes($topItem->title) }}')" title="Add submenu link under {{ $topItem->title }}">
                                    ➕ Sub-Link
                                </button>

                                <!-- Edit Button -->
                                <button type="button" class="action-btn action-btn-edit" title="Edit Menu Item" onclick="openEditModal({{ json_encode($topItem) }})">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.navigation.destroy', $topItem) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete \'{{ addslashes($topItem->title) }}\' and all its submenu items?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn" style="background:#FEE2E2; color:#DC2626; border-color:#FECACA;" title="Delete">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Submenu Container -->
                        <div class="submenu-list submenu-sortable" data-parent-id="{{ $topItem->id }}">
                            @forelse($topItem->children as $child)
                            <div class="submenu-item-card" data-id="{{ $child->id }}" data-parent-id="{{ $topItem->id }}">
                                <div class="drag-handle" title="Drag to reorder submenu link">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 9h.01M8 15h.01M16 9h.01M16 15h.01M12 9h.01M12 15h.01"></path></svg>
                                </div>

                                <div class="menu-item-info">
                                    <span style="font-size:12px; color:var(--admin-slate-400);">↳</span>
                                    <span class="menu-title-text" style="font-size:13px; font-weight:600;">{{ $child->title }}</span>
                                    <span class="menu-url-pill" title="{{ $child->href }}">{{ $child->url ?: ($child->page ? '/' . $child->page->slug : '#') }}</span>
                                    @if($child->page)
                                        <span class="badge badge-info" style="font-size:10px;">CMS Page #{{ $child->page->id }}</span>
                                    @endif
                                    @if($child->css_class === 'nav-dropdown-viewall')
                                        <span class="badge" style="background:#E0F2FE; color:#0369A1; font-size:10px;">View All Link</span>
                                    @endif
                                </div>

                                <div class="menu-actions">
                                    <button type="button" class="action-btn" title="Move Up" onclick="moveItem({{ $child->id }}, -1)">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path></svg>
                                    </button>
                                    <button type="button" class="action-btn" title="Move Down" onclick="moveItem({{ $child->id }}, 1)">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>

                                    <button type="button" class="status-toggle" onclick="toggleActive({{ $child->id }}, this)" title="{{ $child->is_active ? 'Active' : 'Hidden' }}">
                                        @if($child->is_active)
                                            <span class="badge badge-success" style="font-size:10px;">Active</span>
                                        @else
                                            <span class="badge badge-neutral" style="font-size:10px;">Hidden</span>
                                        @endif
                                    </button>

                                    <button type="button" class="action-btn action-btn-edit" title="Edit Submenu Item" onclick="openEditModal({{ json_encode($child) }})">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>

                                    <form action="{{ route('admin.navigation.destroy', $child) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete \'{{ addslashes($child->title) }}\'?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn" style="background:#FEE2E2; color:#DC2626; border-color:#FECACA;" title="Delete">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <div style="font-size:12px; color:var(--admin-slate-500); padding:6px 0; font-style:italic;">
                                No submenu links. This top-level item acts as a direct link. Click <strong>➕ Sub-Link</strong> above to add dropdown links.
                            </div>
                            @endforelse
                        </div>
                    </div>
                    @empty
                    <div style="text-align:center; padding:40px; color:var(--admin-slate-500);">
                        <p style="font-size:16px; font-weight:600; margin-bottom:12px;">No Navigation Items Found</p>
                        <form action="{{ route('admin.navigation.reset-default') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Restore Default Certified Menu</button>
                        </form>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Quick Add Tools -->
    <div style="display:flex; flex-direction:column; gap:20px;">
        <!-- Card 1: Quick-Add CMS Page (Directly Solves Client Joel's Need!) -->
        <div class="card" style="border: 2px solid #0B2545;">
            <div class="card-header" style="background:#0B2545; color:#fff;">
                <div>
                    <h3 style="font-size:15px; font-weight:700; color:#fff; margin:0; display:flex; align-items:center; gap:8px;">
                        <svg width="16" height="16" fill="none" stroke="#F59E0B" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Quick-Add CMS Page
                    </h3>
                    <p style="font-size:12px; color:#CBD5E1; margin-top:2px; margin-bottom:0;">
                        Place any CMS page into the toolbar or a submenu
                    </p>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.navigation.quick-add-page') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="page_id">Select CMS Page *</label>
                        <select name="page_id" id="page_id" class="form-control" required onchange="handlePageSelect(this)">
                            <option value="">-- Choose a Page --</option>
                            @foreach($pages as $p)
                                <option value="{{ $p->id }}" data-title="{{ $p->title }}" data-slug="{{ $p->slug }}">
                                    {{ $p->title }} (/{{ $p->slug }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="quick_parent_id">Place Inside Navigation Menu</label>
                        <select name="parent_id" id="quick_parent_id" class="form-control">
                            <option value="">[ Top-Level Toolbar (New Main Menu) ]</option>
                            @foreach($parentOptions as $parent)
                                <option value="{{ $parent->id }}">↳ Submenu of: {{ $parent->title }}</option>
                            @endforeach
                        </select>
                        <div class="form-hint">Choose a parent to put this page inside its dropdown, or select Top-Level to put it on the main toolbar.</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="custom_title">Custom Menu Label (Optional)</label>
                        <input type="text" name="custom_title" id="custom_title" class="form-control" placeholder="Leave blank to use Page Title">
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                        + Add Page to Navigation
                    </button>
                </form>
            </div>
        </div>

        <!-- Card 2: Add Custom Link / External URL -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-size:15px; margin:0;">Add Custom URL or Link</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.navigation.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="custom_link_title">Link Label *</label>
                        <input type="text" name="title" id="custom_link_title" class="form-control" placeholder="e.g. Rapid Results FAQ" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="custom_link_url">URL / Destination *</label>
                        <input type="text" name="url" id="custom_link_url" class="form-control" placeholder="e.g. /category/urine or https://..." required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="custom_link_parent">Parent Menu</label>
                        <select name="parent_id" id="custom_link_parent" class="form-control">
                            <option value="">[ Top-Level Toolbar ]</option>
                            @foreach($parentOptions as $parent)
                                <option value="{{ $parent->id }}">↳ Submenu of: {{ $parent->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label style="display:flex; align-items:center; gap:8px; font-size:13px; cursor:pointer;">
                            <input type="checkbox" name="target" value="_blank">
                            <span>Open in new window / tab (_blank)</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-outline" style="width:100%; justify-content:center; font-weight:700;">
                        + Add Custom Link
                    </button>
                </form>
            </div>
        </div>

        <!-- Card 3: Quick Add Category -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-size:15px; margin:0;">Quick-Add Category</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.navigation.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="cat_select">Select Category *</label>
                        <select name="cat_slug" id="cat_select" class="form-control" required onchange="handleCatSelect(this)">
                            <option value="">-- Choose a Category --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" data-name="{{ $cat->name }}">
                                    {{ $cat->name }} (/category/{{ $cat->slug }})
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="title" id="cat_title_input">
                        <input type="hidden" name="url" id="cat_url_input">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="cat_parent">Parent Menu</label>
                        <select name="parent_id" id="cat_parent" class="form-control">
                            <option value="">[ Top-Level Toolbar ]</option>
                            @foreach($parentOptions as $parent)
                                <option value="{{ $parent->id }}">↳ Submenu of: {{ $parent->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-outline" style="width:100%; justify-content:center; font-weight:700;">
                        + Add Category Link
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add New Menu Item (Top or Sub) -->
<div class="admin-modal-backdrop" id="addModal">
    <div class="admin-modal-card">
        <div class="card-header" style="background:var(--admin-navy); color:#fff; padding:16px 20px;">
            <h3 style="color:#fff; font-size:16px; margin:0;" id="addModalHeading">Add Navigation Item</h3>
            <button type="button" onclick="closeAddModal()" style="background:none; border:none; color:#fff; font-size:20px; cursor:pointer;">&times;</button>
        </div>
        <form action="{{ route('admin.navigation.store') }}" method="POST">
            @csrf
            <div class="card-body" style="padding:20px;">
                <div class="form-group">
                    <label class="form-label" for="modal_add_title">Display Title *</label>
                    <input type="text" name="title" id="modal_add_title" class="form-control" required placeholder="e.g. Oral Swab Tests">
                </div>

                <div class="form-group">
                    <label class="form-label" for="modal_add_url">URL / Path</label>
                    <input type="text" name="url" id="modal_add_url" class="form-control" placeholder="/category/oral-fluid-testing">
                </div>

                <div class="form-group">
                    <label class="form-label" for="modal_add_parent">Parent Menu Item</label>
                    <select name="parent_id" id="modal_add_parent" class="form-control">
                        <option value="">[ Top-Level Toolbar Menu ]</option>
                        @foreach($parentOptions as $parent)
                            <option value="{{ $parent->id }}">↳ Submenu of: {{ $parent->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="modal_add_page_id">Or Link to CMS Page</label>
                    <select name="page_id" id="modal_add_page_id" class="form-control" onchange="if(this.value){ const opt=this.options[this.selectedIndex]; document.getElementById('modal_add_url').value = '/' + opt.dataset.slug; if(!document.getElementById('modal_add_title').value) document.getElementById('modal_add_title').value = opt.dataset.title; }">
                        <option value="">-- None (Use Custom URL) --</option>
                        @foreach($pages as $p)
                            <option value="{{ $p->id }}" data-slug="{{ $p->slug }}" data-title="{{ $p->title }}">{{ $p->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="form-group">
                        <label class="form-label" for="modal_add_target">Target</label>
                        <select name="target" id="modal_add_target" class="form-control">
                            <option value="_self">Same Window (_self)</option>
                            <option value="_blank">New Tab (_blank)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="modal_add_order">Order Position</label>
                        <input type="number" name="order" id="modal_add_order" class="form-control" placeholder="e.g. 1">
                    </div>
                </div>

                <div class="form-group">
                    <label style="display:flex; align-items:center; gap:8px; font-size:13px; cursor:pointer;">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Active (Visible on Website Navbar)</span>
                    </label>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
                    <button type="button" class="btn btn-outline" onclick="closeAddModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Menu Item</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Menu Item -->
<div class="admin-modal-backdrop" id="editModal">
    <div class="admin-modal-card">
        <div class="card-header" style="background:var(--admin-navy); color:#fff; padding:16px 20px;">
            <h3 style="color:#fff; font-size:16px; margin:0;">Edit Navigation Item</h3>
            <button type="button" onclick="closeEditModal()" style="background:none; border:none; color:#fff; font-size:20px; cursor:pointer;">&times;</button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body" style="padding:20px;">
                <div class="form-group">
                    <label class="form-label" for="edit_title">Display Title *</label>
                    <input type="text" name="title" id="edit_title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_url">URL / Destination</label>
                    <input type="text" name="url" id="edit_url" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_parent_id">Parent Menu Item</label>
                    <select name="parent_id" id="edit_parent_id" class="form-control">
                        <option value="">[ Top-Level Toolbar Menu ]</option>
                        @foreach($parentOptions as $parent)
                            <option value="{{ $parent->id }}">↳ Submenu of: {{ $parent->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_page_id">Or Link to CMS Page</label>
                    <select name="page_id" id="edit_page_id" class="form-control">
                        <option value="">-- None (Custom URL) --</option>
                        @foreach($pages as $p)
                            <option value="{{ $p->id }}">{{ $p->title }} (/{{ $p->slug }})</option>
                        @endforeach
                    </select>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="form-group">
                        <label class="form-label" for="edit_target">Target Window</label>
                        <select name="target" id="edit_target" class="form-control">
                            <option value="_self">Same Window (_self)</option>
                            <option value="_blank">New Window (_blank)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="edit_order">Sort Order</label>
                        <input type="number" name="order" id="edit_order" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_css_class">Optional CSS / Style Tag</label>
                    <input type="text" name="css_class" id="edit_css_class" class="form-control" placeholder="e.g. nav-dropdown-viewall, nav-item-employer">
                </div>

                <div class="form-group">
                    <label style="display:flex; align-items:center; gap:8px; font-size:13px; cursor:pointer;">
                        <input type="checkbox" name="is_active" id="edit_is_active" value="1">
                        <span>Active (Visible on Website Navbar)</span>
                    </label>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
                    <button type="button" class="btn btn-outline" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<!-- Load SortableJS for smooth drag and drop reordering -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

<script>
    // Show toast message
    function showToast(message) {
        const toast = document.getElementById('navToast');
        const text = document.getElementById('navToastMessage');
        text.textContent = message;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    // Auto-fill custom title when selecting a CMS page in right panel
    function handlePageSelect(select) {
        const selected = select.options[select.selectedIndex];
        if (selected && selected.dataset.title) {
            document.getElementById('custom_title').value = selected.dataset.title;
        }
    }

    // Handle Category Select
    function handleCatSelect(select) {
        const selected = select.options[select.selectedIndex];
        if (selected && selected.value) {
            document.getElementById('cat_title_input').value = selected.dataset.name;
            document.getElementById('cat_url_input').value = '/category/' + selected.value;
        }
    }

    // Modal controls
    function openAddModal(parentId = '', parentTitle = '') {
        const parentSelect = document.getElementById('modal_add_parent');
        if (parentId) {
            parentSelect.value = parentId;
            document.getElementById('addModalHeading').textContent = 'Add Submenu Item under "' + parentTitle + '"';
        } else {
            parentSelect.value = '';
            document.getElementById('addModalHeading').textContent = 'Add Top-Level Menu Item';
        }
        document.getElementById('addModal').classList.add('open');
    }

    function closeAddModal() {
        document.getElementById('addModal').classList.remove('open');
    }

    function openEditModal(item) {
        const form = document.getElementById('editForm');
        form.action = '{{ url("/admin/navigation") }}/' + item.id;

        document.getElementById('edit_title').value = item.title || '';
        document.getElementById('edit_url').value = item.url || '';
        document.getElementById('edit_parent_id').value = item.parent_id || '';
        document.getElementById('edit_page_id').value = item.page_id || '';
        document.getElementById('edit_target').value = item.target || '_self';
        document.getElementById('edit_order').value = item.order || 0;
        document.getElementById('edit_css_class').value = item.css_class || '';
        document.getElementById('edit_is_active').checked = !!item.is_active;

        document.getElementById('editModal').classList.add('open');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.remove('open');
    }

    // Toggle Active Status via AJAX
    function toggleActive(id, btn) {
        fetch('{{ url("/admin/navigation") }}/' + id + '/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (data.is_active) {
                    btn.innerHTML = '<span class="badge badge-success" style="font-size:10px;">Active</span>';
                    btn.title = 'Active (Click to hide from site)';
                } else {
                    btn.innerHTML = '<span class="badge badge-neutral" style="font-size:10px;">Hidden</span>';
                    btn.title = 'Hidden (Click to show on site)';
                }
                showToast(data.message);
            }
        })
        .catch(err => {
            console.error('Toggle error', err);
            alert('Failed to update status.');
        });
    }

    // Send updated order to server
    function saveReorderState() {
        const items = [];

        // Collect top-level items
        const topElements = document.querySelectorAll('#topLevelSortable > .parent-menu-card');
        topElements.forEach((el, index) => {
            const topId = parseInt(el.getAttribute('data-id'), 10);
            items.push({
                id: topId,
                parent_id: null,
                order: index + 1
            });

            // Collect submenu items under this parent
            const subElements = el.querySelectorAll('.submenu-sortable > .submenu-item-card');
            subElements.forEach((subEl, subIndex) => {
                const subId = parseInt(subEl.getAttribute('data-id'), 10);
                items.push({
                    id: subId,
                    parent_id: topId,
                    order: subIndex + 1
                });
            });
        });

        fetch('{{ route("admin.navigation.reorder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ items: items })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('Navigation order saved successfully!');
            }
        })
        .catch(err => {
            console.error('Reorder error', err);
            alert('Error saving order.');
        });
    }

    // Move Item Up or Down with buttons (Fallback for Drag & Drop)
    function moveItem(id, direction) {
        const el = document.querySelector('[data-id="' + id + '"]');
        if (!el) return;

        if (direction === -1) {
            const prev = el.previousElementSibling;
            if (prev && (prev.classList.contains('parent-menu-card') || prev.classList.contains('submenu-item-card'))) {
                el.parentNode.insertBefore(el, prev);
                saveReorderState();
            }
        } else if (direction === 1) {
            const next = el.nextElementSibling;
            if (next && (next.classList.contains('parent-menu-card') || next.classList.contains('submenu-item-card'))) {
                el.parentNode.insertBefore(next, el);
                saveReorderState();
            }
        }
    }

    // Initialize SortableJS
    document.addEventListener('DOMContentLoaded', function () {
        // Top-level drag & drop
        const topContainer = document.getElementById('topLevelSortable');
        if (topContainer && window.Sortable) {
            new Sortable(topContainer, {
                handle: '.drag-handle',
                draggable: '.parent-menu-card',
                animation: 150,
                ghostClass: 'is-dragging',
                onEnd: function () {
                    saveReorderState();
                }
            });
        }

        // Submenu drag & drop across and within parents
        const submenuContainers = document.querySelectorAll('.submenu-sortable');
        submenuContainers.forEach(container => {
            if (window.Sortable) {
                new Sortable(container, {
                    group: 'submenus',
                    handle: '.drag-handle',
                    draggable: '.submenu-item-card',
                    animation: 150,
                    ghostClass: 'is-dragging',
                    onEnd: function (evt) {
                        saveReorderState();
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection
