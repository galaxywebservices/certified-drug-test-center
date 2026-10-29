@extends('admin.layouts.app', ['title' => 'Pages & CMS', 'heading' => 'Content Management & Page Builder'])

@section('topbar_actions')
<a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-sm">
    + Create New Page
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header" style="flex-wrap:wrap; gap:16px;">
        <form action="{{ route('admin.pages.index') }}" method="GET" style="display:flex; gap:12px; flex-grow:1; max-width:600px;">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search pages by title, slug or SEO keywords...">
            <button type="submit" class="btn btn-navy btn-sm">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.pages.index') }}" class="btn btn-outline btn-sm">Clear</a>
            @endif
        </form>
        <div>
            <span class="badge badge-info">{{ $pages->total() }} Migrated &amp; Active Pages</span>
        </div>
    </div>

    <div class="card-body" style="padding:0;">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:60px;">ID</th>
                        <th>Page Title &amp; Heading</th>
                        <th>URL Slug</th>
                        <th>SEO Health</th>
                        <th>Status</th>
                        <th>Last Modified</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                    <tr>
                        <td><small style="color:#64748B;">#{{ $page->id }}</small></td>
                        <td>
                            <strong style="color:var(--admin-navy); font-size:14px;">{{ $page->title }}</strong>
                            @if($page->page_heading && $page->page_heading != $page->title)
                                <div style="font-size:12px; color:var(--admin-slate-500);">{{ $page->page_heading }}</div>
                            @endif
                        </td>
                        <td>
                            <code>/{{ $page->slug }}</code>
                        </td>
                        <td>
                            @php
                                $titleLen = strlen($page->meta_title ?? '');
                                $descLen = strlen($page->meta_description ?? '');
                            @endphp
                            <div style="font-size:11px; display:flex; gap:6px;">
                                <span class="badge {{ ($titleLen >= 30 && $titleLen <= 70) ? 'badge-success' : 'badge-neutral' }}">
                                    Title: {{ $titleLen }}c
                                </span>
                                <span class="badge {{ ($descLen >= 80 && $descLen <= 170) ? 'badge-success' : 'badge-neutral' }}">
                                    Desc: {{ $descLen }}c
                                </span>
                            </div>
                        </td>
                        <td>
                            @if($page->is_published)
                                <span class="badge badge-success">Published</span>
                            @else
                                <span class="badge badge-danger">Draft</span>
                            @endif
                        </td>
                        <td>
                            <small style="color:#64748B;">{{ $page->updated_at ? $page->updated_at->diffForHumans() : 'N/A' }}</small>
                        </td>
                        <td style="text-align:right;">
                            <div class="action-btn-group">
                                <a href="{{ url('/' . $page->slug) }}" target="_blank" class="action-btn action-btn-view" title="View Live Page" aria-label="View">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </a>
                                <a href="{{ route('admin.pages.edit', $page) }}" class="action-btn action-btn-edit" title="Edit Page & PageBuilder" aria-label="Edit">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                </a>
                                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Delete page: {{ $page->title }}?');" style="display:inline; margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn action-btn-delete" title="Delete Page" aria-label="Delete">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px; color:#64748B;">
                            No pages found matching your search.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($pages->hasPages())
    <div style="padding:16px 24px; border-top:1px solid var(--admin-slate-200);">
        {{ $pages->links() }}
    </div>
    @endif
</div>
@endsection
