@extends('admin.layouts.app', ['title' => 'Products & Tests', 'heading' => 'Product Catalog Management'])

@section('topbar_actions')
<a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
    + Add New Product
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header" style="flex-wrap:wrap; gap:16px;">
        <form action="{{ route('admin.products.index') }}" method="GET" style="display:flex; gap:12px; flex-grow:1; max-width:800px; flex-wrap:wrap;">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name, slug or code..." style="flex-grow:1; min-width:200px;">

            <select name="category_id" class="form-control" style="width:200px;">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->display_name ?: $cat->name }}
                    </option>
                @endforeach
            </select>

            <select name="specimen" class="form-control" style="width:160px;">
                <option value="">All Specimens</option>
                <option value="urine" {{ request('specimen') == 'urine' ? 'selected' : '' }}>Urine</option>
                <option value="hair" {{ request('specimen') == 'hair' ? 'selected' : '' }}>Hair</option>
                <option value="alcohol" {{ request('specimen') == 'alcohol' ? 'selected' : '' }}>Alcohol</option>
                <option value="saliva" {{ request('specimen') == 'saliva' ? 'selected' : '' }}>Saliva</option>
                <option value="blood" {{ request('specimen') == 'blood' ? 'selected' : '' }}>Blood</option>
                <option value="dna" {{ request('specimen') == 'dna' ? 'selected' : '' }}>DNA</option>
            </select>

            <button type="submit" class="btn btn-navy btn-sm">Filter</button>
            @if(request()->anyFilled(['search', 'category_id', 'specimen']))
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-sm">Reset</a>
            @endif
        </form>
    </div>

    <div class="card-body" style="padding:0;">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:60px;">ID</th>
                        <th>Test Name &amp; Specimen</th>
                        <th>Categories</th>
                        <th>Web Price</th>
                        <th>DOT Status</th>
                        <th>Status</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td><small style="color:#64748B;">#{{ $product->id }}</small></td>
                        <td>
                            <div style="font-weight:700; color:var(--admin-navy);">{{ $product->name }}</div>
                            <div style="font-size:12px; color:var(--admin-slate-500); display:flex; gap:8px; margin-top:2px;">
                                <span class="badge badge-neutral" style="text-transform:uppercase;">{{ $product->specimen_type }}</span>
                                <span>{{ $product->turnaround_time }}</span>
                            </div>
                        </td>
                        <td>
                            @forelse($product->categories as $c)
                                <span class="badge badge-info" style="margin-right:4px;">{{ $c->name }}</span>
                            @empty
                                <span style="color:#94A3B8; font-size:12px;">Unassigned</span>
                            @endforelse
                        </td>
                        <td>
                            <strong style="color:var(--admin-crimson); font-size:15px;">${{ number_format($product->price, 2) }}</strong>
                            @if($product->retail_price > $product->price)
                                <small style="display:block; text-decoration:line-through; color:#94A3B8;">${{ number_format($product->retail_price, 2) }}</small>
                            @endif
                        </td>
                        <td>
                            @if($product->dot_required)
                                <span class="badge badge-danger">DOT Federal</span>
                            @else
                                <span class="badge badge-neutral">Non-DOT</span>
                            @endif
                        </td>
                        <td>
                            @if($product->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td style="text-align:right;">
                            <div style="display:inline-flex; gap:6px;">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-navy btn-sm">Edit</a>
                                <a href="{{ url('/product/' . $product->slug) }}" target="_blank" class="btn btn-outline btn-sm">View</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?');" style="display:inline;">
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
                            No products found matching your search.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($products->hasPages())
    <div style="padding:16px 24px; border-top:1px solid var(--admin-slate-200);">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
