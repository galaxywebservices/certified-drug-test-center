{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Active Canonical Products -->
    @foreach($products as $product)
    <url>
        <loc>{{ url('/product/' . $product->slug) }}</loc>
        <lastmod>{{ $product->updated_at ? $product->updated_at->toAtomString() : now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.85</priority>
    </url>
    @endforeach
</urlset>

