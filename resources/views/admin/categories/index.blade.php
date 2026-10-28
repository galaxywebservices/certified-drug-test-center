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
                        <div style="display:inline-flex; gap:6px;">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-navy btn-sm">Edit</a>
                            <a href="{{ url('/category/' . $category->slug) }}" target="_blank" class="btn btn-outline btn-sm">View</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete category: {{ $category->name }}?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline btn-sm" style="color:#C1121F; border-color:#FECACA;">Delete</button>
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
