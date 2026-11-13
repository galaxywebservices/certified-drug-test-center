{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <sitemap>
    <loc>{{ url('/sitemap-core.xml') }}</loc>
    <lastmod>{{ $lastmod }}</lastmod>
  </sitemap>
  <sitemap>
    <loc>{{ url('/sitemap-products.xml') }}</loc>
    <lastmod>{{ $lastmod }}</lastmod>
  </sitemap>
  <sitemap>
    <loc>{{ url('/sitemap-locations.xml') }}</loc>
    <lastmod>{{ $lastmod }}</lastmod>
  </sitemap>
</sitemapindex>

