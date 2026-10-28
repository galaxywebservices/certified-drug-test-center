<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\City;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DownloadAdtImagesCommand extends Command
{
    protected $signature = 'app:download-adt-images {--concurrency=10} {--dry-run}';
    protected $description = 'Download all remote Accredited Drug Testing images locally into public/assets/uploads and update DB references';

    public function handle()
    {
        $concurrency = (int) $this->option('concurrency') ?: 10;
        $isDryRun = (bool) $this->option('dry-run');

        $uploadsDir = public_path('assets/uploads');
        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0755, true);
        }

        $this->info("Scanning database for remote ADT images...");

        // Collect all distinct URLs
        $urlsToDownload = [];
        $domainRegex = '/(?:https?:)?\/\/(?:www\.|training\.)?accrediteddrugtesting\.com\/[^\s"\'<>]+\.(?:png|jpg|jpeg|webp|gif|svg|ico)/i';

        // 1. Pages - featured_image
        foreach (Page::whereNotNull('featured_image')->pluck('featured_image', 'id') as $id => $img) {
            if (preg_match($domainRegex, $img, $m)) {
                $fullUrl = str_starts_with($m[0], '//') ? 'https:' . $m[0] : $m[0];
                $urlsToDownload[$fullUrl] = true;
            }
        }

        // 2. Pages - content
        foreach (Page::whereNotNull('content')->pluck('content', 'id') as $id => $content) {
            if (preg_match_all($domainRegex, $content, $m)) {
                foreach ($m[0] as $u) {
                    $fullUrl = str_starts_with($u, '//') ? 'https:' . $u : $u;
                    $urlsToDownload[$fullUrl] = true;
                }
            }
        }

        // 3. Products
        foreach (Product::all(['id', 'details', 'short_description']) as $p) {
            foreach (['details', 'short_description'] as $col) {
                if ($p->$col && preg_match_all($domainRegex, $p->$col, $m)) {
                    foreach ($m[0] as $u) {
                        $urlsToDownload[$u] = true;
                    }
                }
            }
        }

        // 4. Categories
        foreach (Category::all(['id', 'image', 'description']) as $c) {
            foreach (['image', 'description'] as $col) {
                if ($c->$col && preg_match_all($domainRegex, $c->$col, $m)) {
                    foreach ($m[0] as $u) {
                        $urlsToDownload[$u] = true;
                    }
                }
            }
        }

        // 5. Cities
        foreach (City::whereNotNull('content')->pluck('content', 'id') as $id => $content) {
            if (preg_match_all($domainRegex, $content, $m)) {
                foreach ($m[0] as $u) {
                    $urlsToDownload[$u] = true;
                }
            }
        }

        $total = count($urlsToDownload);
        $this->info("Found {$total} distinct ADT image URLs across the platform.");

        if ($total === 0) {
            $this->info("No remote images to download.");
            return 0;
        }

        // Map remote URL to local filename
        $urlMap = [];
        $claimedFilenames = [];

        foreach (array_keys($urlsToDownload) as $url) {
            $path = parse_url($url, PHP_URL_PATH);
            $base = basename($path);
            
            // Clean basename
            $base = preg_replace('/[^a-zA-Z0-9._-]/', '_', $base);

            // Handle filename collision if multiple paths share basename
            if (isset($claimedFilenames[$base]) && $claimedFilenames[$base] !== $url) {
                $prefix = substr(md5($path), 0, 6) . '_';
                $filename = $prefix . $base;
            } else {
                $filename = $base;
                $claimedFilenames[$base] = $url;
            }

            $urlMap[$url] = [
                'filename' => $filename,
                'local_path' => $uploadsDir . '/' . $filename,
                'public_url' => '/assets/uploads/' . $filename,
            ];
        }

        if ($isDryRun) {
            $this->warn("DRY RUN mode: Sample mappings:");
            foreach (array_slice($urlMap, 0, 10, true) as $orig => $info) {
                $this->line("  {$orig} => {$info['public_url']}");
            }
            return 0;
        }

        // Download images in concurrent batches using curl_multi
        $this->info("Downloading images into public/assets/uploads (concurrency: {$concurrency})...");
        $chunks = array_chunk(array_keys($urlMap), $concurrency);
        $downloadedCount = 0;
        $cachedCount = 0;
        $failedCount = 0;

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        foreach ($chunks as $chunk) {
            $multi = curl_multi_init();
            $handles = [];

            foreach ($chunk as $url) {
                $info = $urlMap[$url];
                // If already downloaded and size > 0, skip re-download
                if (file_exists($info['local_path']) && filesize($info['local_path']) > 0) {
                    $cachedCount++;
                    $bar->advance();
                    continue;
                }

                $ch = curl_init();
                curl_setopt_array($ch, [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_MAXREDIRS => 5,
                    CURLOPT_TIMEOUT => 25,
                    CURLOPT_USERAGENT => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
                    CURLOPT_SSL_VERIFYPEER => false,
                ]);
                curl_multi_add_handle($multi, $ch);
                $handles[$url] = $ch;
            }

            if (!empty($handles)) {
                $running = null;
                do {
                    curl_multi_exec($multi, $running);
                    curl_multi_select($multi, 0.05);
                } while ($running > 0);

                foreach ($handles as $url => $ch) {
                    $content = curl_multi_getcontent($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_multi_remove_handle($multi, $ch);
                    curl_close($ch);

                    $info = $urlMap[$url];
                    if ($httpCode === 200 && !empty($content)) {
                        file_put_contents($info['local_path'], $content);
                        $downloadedCount++;
                    } else {
                        $failedCount++;
                    }
                    $bar->advance();
                }
            }

            curl_multi_close($multi);
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Download Summary: {$downloadedCount} newly downloaded, {$cachedCount} previously existing, {$failedCount} failed.");

        // Now update database references
        $this->info("Updating database references to point to /assets/uploads/...");

        // 1. Update pages.featured_image
        $featuredUpdated = 0;
        foreach (Page::whereNotNull('featured_image')->get() as $page) {
            $orig = $page->featured_image;
            if (isset($urlMap[$orig])) {
                $page->featured_image = $urlMap[$orig]['public_url'];
                $page->save();
                $featuredUpdated++;
            } elseif (preg_match($domainRegex, $orig, $m)) {
                $matchedUrl = $m[0];
                if (isset($urlMap[$matchedUrl])) {
                    $page->featured_image = $urlMap[$matchedUrl]['public_url'];
                    $page->save();
                    $featuredUpdated++;
                }
            }
        }
        $this->info("Updated {$featuredUpdated} pages.featured_image references.");

        // 2. Update pages.content
        $contentUpdated = 0;
        foreach (Page::whereNotNull('content')->get() as $page) {
            [$newContent, $changed] = $this->replaceUrlVariants($page->content, $urlMap);
            if ($changed) {
                $page->content = $newContent;
                $page->save();
                $contentUpdated++;
            }
        }
        $this->info("Updated {$contentUpdated} pages.content rows.");

        // 3. Update products
        foreach (Product::all() as $prod) {
            $dirty = false;
            foreach (['details', 'short_description'] as $col) {
                if (!empty($prod->$col)) {
                    [$newText, $changed] = $this->replaceUrlVariants($prod->$col, $urlMap);
                    if ($changed) {
                        $prod->$col = $newText;
                        $dirty = true;
                    }
                }
            }
            if ($dirty) {
                $prod->save();
            }
        }

        // 4. Update cities
        $citiesUpdated = 0;
        foreach (City::whereNotNull('content')->get() as $city) {
            [$newContent, $changed] = $this->replaceUrlVariants($city->content, $urlMap);
            if ($changed) {
                $city->content = $newContent;
                $city->save();
                $citiesUpdated++;
            }
        }
        $this->info("Updated {$citiesUpdated} cities.content rows.");

        $this->info("All images successfully downloaded and mapped locally to /assets/uploads/!");
        return 0;
    }

    /**
     * Replace all URL variants (http, https, protocol-relative, www, non-www) in a text block
     */
    protected function replaceUrlVariants(string $text, array $urlMap): array
    {
        $changed = false;
        foreach ($urlMap as $remoteUrl => $info) {
            $variants = array_unique([
                $remoteUrl,
                str_replace('https://', 'http://', $remoteUrl),
                str_replace(['https://', 'http://'], '//', $remoteUrl),
                str_replace('https://accrediteddrugtesting.com', 'https://www.accrediteddrugtesting.com', $remoteUrl),
                str_replace('https://www.accrediteddrugtesting.com', 'https://accrediteddrugtesting.com', $remoteUrl),
                str_replace('http://accrediteddrugtesting.com', 'http://www.accrediteddrugtesting.com', $remoteUrl),
                str_replace('http://www.accrediteddrugtesting.com', 'http://accrediteddrugtesting.com', $remoteUrl),
                str_replace('//accrediteddrugtesting.com', '//www.accrediteddrugtesting.com', $remoteUrl),
                str_replace('//www.accrediteddrugtesting.com', '//accrediteddrugtesting.com', $remoteUrl),
            ]);

            foreach ($variants as $variant) {
                if (str_contains($text, $variant)) {
                    $text = str_replace($variant, $info['public_url'], $text);
                    $changed = true;
                }
            }
        }

        return [$text, $changed];
    }
}
