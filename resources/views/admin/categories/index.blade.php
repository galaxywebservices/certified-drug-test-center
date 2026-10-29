@extends('admin.layouts.app', ['title' => 'Categories', 'heading' => 'Test Categories'])

@section('topbar_actions')
<a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
    + Add Category
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">All Categories</h2>
    </div>
    <div class="card-body" style="padding:0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:60px;">ID</th>
                    <th>Category Name</th>
                    <th>URL Slug</th>
                    <th>Total Tests</th>
                    <th>Order Position</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td><small style="color:#64748B;">#{{ $category->id }}</small></td>
                    <td>
                        <strong style="color:var(--admin-navy);">{{ $category->name }}</strong>
                        @if($category->display_name && $category->display_name != $category->name)
                            <div style="font-size:12px; color:var(--admin-slate-500);">{{ $category->display_name }}</div>
                        @endif
                    </td>
                    <td><code>/category/{{ $category->slug }}</code></td>
                    <td>
                        <span class="badge badge-info">{{ $category->products_count }} Products</span>
                    </td>
                    <td>{{ $category->position }}</td>
                    <td>
                        @if($category->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Hidden</span>
                        @endif
                    </td>
                    <td style="text-align:right;">
                        <div class="action-btn-group">
                            <a href="{{ url('/category/' . $category->slug) }}" target="_blank" class="action-btn action-btn-view" title="View Category Live" aria-label="View">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </a>
                            <a href="{{ route('admin.categories.edit', $category) }}" class="action-btn action-btn-edit" title="Edit Category" aria-label="Edit">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete category: {{ $category->name }}?');" style="display:inline; margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn action-btn-delete" title="Delete Category" aria-label="Delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
