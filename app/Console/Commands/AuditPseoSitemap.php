<?php

namespace App\Console\Commands;

use App\Http\Controllers\PseoSitemapController;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AuditPseoSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pseo:audit-sitemap {chain=1 : Chain ID (1-9)} {--sample=25 : Number of URLs to audit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Audit and validate XML sitemap for 200 OK, strict trailing slashes, canonical tags, and sub-300ms latency';

    /**
     * Execute the console command.
     */
    public function handle(PseoSitemapController $sitemapController): int
    {
        $chainId = (int) $this->argument('chain');
        if ($chainId < 1 || $chainId > 9) {
            $this->error("Chain ID must be between 1 and 9.");
            return Command::FAILURE;
        }

        $this->info("Auditing sitemap-chain{$chainId}.xml...");

        // 1. Generate XML
        $response = $sitemapController->chain($chainId);
        if ($response->getStatusCode() !== 200) {
            $this->error("Sitemap generation returned status {$response->getStatusCode()}");
            return Command::FAILURE;
        }

        $xmlContent = $response->getContent();
        $xml = simplexml_load_string($xmlContent);
        if (!$xml) {
            $this->error("Sitemap is not valid XML!");
            return Command::FAILURE;
        }

        $totalUrls = count($xml->url);
        $this->info("Total URLs in sitemap: {$totalUrls}");

        if ($totalUrls > 50000) {
            $this->error("CRITICAL: Sitemap exceeds Google's 50,000 URL limit!");
            return Command::FAILURE;
        }

        // 2. Trailing Slash Audit
        $slashErrors = 0;
        $locs = [];
        foreach ($xml->url as $urlNode) {
            $loc = (string) $urlNode->loc;
            $locs[] = $loc;
            if (!str_ends_with($loc, '/')) {
                $slashErrors++;
            }
        }

        $this->line(" - Trailing Slash Check: " . ($slashErrors === 0 ? "PASSED (100% contain trailing slash)" : "FAILED ({$slashErrors} URLs missing slash)"));

        // 3. Sample Verification (Status Code, Latency, Canonical, Structured Data)
        $sampleSize = min((int) $this->option('sample'), $totalUrls);
        $sampleIndices = array_rand($locs, $sampleSize);
        if (!is_array($sampleIndices)) {
            $sampleIndices = [$sampleIndices];
        }

        $this->info("Sampling {$sampleSize} URLs for HTTP status, canonical match, JSON-LD, and TTFB latency...");

        $results = [];
        $passCount = 0;
        $failCount = 0;
        $latencies = [];

        foreach ($sampleIndices as $idx) {
            $targetUrl = $locs[$idx];
            $parsed = parse_url($targetUrl);
            $path = $parsed['path'] ?? '/';

            // Simulate internal request
            $subRequest = Request::create($path, 'GET');
            $start = microtime(true);
            $res = app()->handle($subRequest);
            $latency = round((microtime(true) - $start) * 1000, 1);
            $latencies[] = $latency;

            $status = $res->getStatusCode();
            $body = $res->getContent();

            // Check canonical tag in response
            $hasCanonical = preg_match('/<link\s+rel=["\']canonical["\']\s+href=["\']([^"\']+)["\']/i', $body, $canonicalMatch);
            $canonicalHref = $hasCanonical ? $canonicalMatch[1] : '';
            $canonicalPath = parse_url($canonicalHref, PHP_URL_PATH) ?? '';
            $targetPath = parse_url($targetUrl, PHP_URL_PATH) ?? '';
            $canonicalPass = $hasCanonical && ($canonicalPath === $targetPath) && str_ends_with($canonicalPath, '/');

            // Check JSON-LD
            $hasJsonLd = str_contains($body, 'application/ld+json');

            $isSuccess = ($status === 200 && $canonicalPass && $hasJsonLd);
            if ($isSuccess) {
                $passCount++;
            } else {
                $failCount++;
            }

            $results[] = [
                'path' => strlen($path) > 45 ? substr($path, 0, 42) . '...' : $path,
                'status' => $status === 200 ? '200 OK' : "ERR: {$status}",
                'canonical' => $canonicalPass ? 'MATCH' : 'MISMATCH',
                'json_ld' => $hasJsonLd ? 'YES' : 'NO',
                'latency' => "{$latency} ms",
            ];
        }

        $this->table(['Sample Path', 'Status', 'Canonical', 'JSON-LD', 'Latency'], $results);

        $avgLatency = round(array_sum($latencies) / count($latencies), 1);

        $this->newLine();
        $this->table(['Checklist Item', 'Result', 'Threshold'], [
            ['Total URL Volume', number_format($totalUrls), '≤ 50,000 URLs'],
            ['Trailing Slash Consistency', $slashErrors === 0 ? '100% Valid' : "{$slashErrors} Missing", '0 Missing'],
            ['Sample HTTP 200 Status', "{$passCount}/{$sampleSize} Passed", '100% 200 OK'],
            ['Canonical Self-Reference', $failCount === 0 ? '100% Match' : "{$failCount} Mismatches", '100% Exact Match'],
            ['Average Response Latency', "{$avgLatency} ms", '< 300 ms TTFB'],
        ]);

        if ($slashErrors === 0 && $failCount === 0 && $avgLatency < 300) {
            $this->info("READY FOR DEPLOYMENT: sitemap-chain{$chainId}.xml meets all search engine gate requirements!");
            return Command::SUCCESS;
        }

        $this->warn("Audit finished with warnings or issues. Please review table above before submitting to GSC.");
        return Command::FAILURE;
    }
}
