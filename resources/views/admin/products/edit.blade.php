@extends('admin.layouts.app', ['title' => 'Edit Product', 'heading' => 'Edit: ' . $product->name])

@section('topbar_actions')
<a href="{{ url('/product/' . $product->slug) }}" target="_blank" class="btn btn-outline btn-sm">
    View Live on Site
</a>
<a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-sm">
    &larr; Back to Catalog
</a>
@endsection

@section('content')
<form action="{{ route('admin.products.update', $product) }}" method="POST">
    @csrf
    @method('PUT')

    <div style="display:grid; grid-template-columns:2fr 1fr; gap:24px;">
        <!-- Left Main Column -->
        <div>
            <!-- Basic Information Card -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Test Details &amp; Configuration</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="name">Test Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                        <div class="form-group">
                            <label class="form-label" for="slug">URL Slug *</label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" class="form-control" required>
                            <div class="form-hint">Used in URL: /product/{{ $product->slug }}</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="subtitle">Subtitle / Discount Badge</label>
                            <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $product->subtitle) }}" class="form-control">
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
                        <div class="form-group">
                            <label class="form-label" for="price">Online Price ($) *</label>
                            <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $product->price) }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="retail_price">Regular / Retail Price ($)</label>
                            <input type="number" step="0.01" id="retail_price" name="retail_price" value="{{ old('retail_price', $product->retail_price) }}" class="form-control">
                            <div class="form-hint">Strikethrough price shown to user</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="specimen_type">Specimen Type *</label>
                            <select id="specimen_type" name="specimen_type" class="form-control" required>
                                <option value="urine" {{ $product->specimen_type == 'urine' ? 'selected' : '' }}>Urine Specimen</option>
                                <option value="hair" {{ $product->specimen_type == 'hair' ? 'selected' : '' }}>Hair Follicle (90-Day)</option>
                                <option value="alcohol" {{ $product->specimen_type == 'alcohol' ? 'selected' : '' }}>Alcohol / Breath</option>
                                <option value="saliva" {{ $product->specimen_type == 'saliva' ? 'selected' : '' }}>Oral Fluid / Saliva</option>
                                <option value="blood" {{ $product->specimen_type == 'blood' ? 'selected' : '' }}>Blood Specimen</option>
                                <option value="dna" {{ $product->specimen_type == 'dna' ? 'selected' : '' }}>DNA Testing</option>
                            </select>
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                        <div class="form-group">
                            <label class="form-label" for="turnaround_time">Turnaround Time</label>
                            <input type="text" id="turnaround_time" name="turnaround_time" value="{{ old('turnaround_time', $product->turnaround_time) }}" class="form-control" placeholder="e.g. 24-48 Hours Lab MRO">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="included_panels">Included Drug Panels (Comma Separated)</label>
                            @php
                                $panelsStr = is_array($product->included_panels) ? implode(', ', $product->included_panels) : '';
                            @endphp
                            <input type="text" id="included_panels" name="included_panels" value="{{ old('included_panels', $panelsStr) }}" class="form-control" placeholder="THC, Cocaine, Opiates, Amphetamines, PCP">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="short_description">Short Overview</label>
                        <textarea id="short_description" name="short_description" rows="2" class="form-control">{{ old('short_description', $product->short_description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="details">Full Details &amp; Scientific Specifications</label>
                        <textarea id="details" name="details" rows="6" class="form-control">{{ old('details', $product->details) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="preparation_instructions">Donor Preparation Instructions</label>
                        <textarea id="preparation_instructions" name="preparation_instructions" rows="2" class="form-control">{{ old('preparation_instructions', $product->preparation_instructions) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- SEO Settings Card -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">100% SEO Management</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="meta_title">Meta Title Tag</label>
                        <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" class="form-control">
                        <div class="form-hint">Recommended length: 50-60 characters</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="meta_description">Meta Description Tag</label>
                        <textarea id="meta_description" name="meta_description" rows="3" class="form-control">{{ old('meta_description', $product->meta_description) }}</textarea>
                        <div class="form-hint">Recommended length: 150-160 characters</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="canonical_url">Canonical URL</label>
                        <input type="text" id="canonical_url" name="canonical_url" value="{{ old('canonical_url', $product->canonical_url) }}" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Category Assignment & Status -->
        <div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Publish &amp; Settings</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label style="display:flex; align-items:center; gap:8px; font-weight:600; cursor:pointer;">
                            <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
                            <span>Active / Available For Purchase</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label style="display:flex; align-items:center; gap:8px; font-weight:600; cursor:pointer;">
                            <input type="checkbox" name="dot_required" value="1" {{ $product->dot_required ? 'checked' : '' }}>
                            <span style="color:#C1121F;">DOT Federal Regulated Test</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label style="display:flex; align-items:center; gap:8px; font-weight:600; cursor:pointer;">
                            <input type="checkbox" name="is_popular" value="1" {{ $product->is_popular ? 'checked' : '' }}>
                            <span>Feature in Homepage Estimator</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:12px; margin-top:12px;">
                        Save Product Changes
                    </button>
                </div>
            </div>

            <!-- Categories Assignment Card -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Assigned Categories</h2>
                </div>
                <div class="card-body">
                    @php
                        $assignedIds = $product->categories->pluck('id')->toArray();
                    @endphp
                    <div style="display:flex; flex-direction:column; gap:10px; max-height:300px; overflow-y:auto;">
                        @foreach($categories as $cat)
                        <label style="display:flex; align-items:center; gap:8px; font-size:13px; cursor:pointer;">
                            <input type="checkbox" name="categories[]" value="{{ $cat->id }}" {{ in_array($cat->id, $assignedIds) ? 'checked' : '' }}>
                            <span>{{ $cat->display_name ?: $cat->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
