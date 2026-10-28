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
                            <div style="display:inline-flex; gap:6px;">
                                <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-navy btn-sm">Edit / PageBuilder</a>
                                <a href="{{ url('/' . $page->slug) }}" target="_blank" class="btn btn-outline btn-sm">View Live</a>
                                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Delete page: {{ $page->title }}?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline btn-sm" style="color:#C1121F; border-color:#FECACA;">Delete</button>
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
