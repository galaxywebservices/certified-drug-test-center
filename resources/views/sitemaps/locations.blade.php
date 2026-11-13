{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Canonical State Hub Directories (51 Jurisdictions) -->
    @foreach($states as $state)
    <url>
        <loc>{{ url('/locations/' . $state->slug) }}</loc>
        <lastmod>{{ $state->updated_at ? $state->updated_at->toAtomString() : now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.85</priority>
    </url>
    @endforeach

    <!-- Gated Hierarchical Municipalities Passing >=1 Clinic Threshold -->
    @foreach($cities as $city)
    <url>
        <loc>{{ url('/locations/' . $city->state_slug . '/' . $city->city_slug) }}</loc>
        <lastmod>{{ $city->updated_at ? $city->updated_at->toAtomString() : now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.75</priority>
    </url>
    @endforeach
</urlset>

