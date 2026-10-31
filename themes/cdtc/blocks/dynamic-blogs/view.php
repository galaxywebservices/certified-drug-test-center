<?php
$blockTenant = isset($tenantOrganization) && $tenantOrganization ? $tenantOrganization : (function_exists('get_active_tenant') ? get_active_tenant() : null);

$latestBlogs = [];
if (class_exists('\Modules\LMS\Models\Blog\Blog')) {
    $latestBlogs = \Modules\LMS\Models\Blog\Blog::where('status', 1)->take(3)->get();
} elseif (class_exists('\App\Models\Page')) {
    $latestBlogs = \App\Models\Page::where('is_published', true)->where('template', 'article')->orderBy('id', 'desc')->take(3)->get();
    if ($latestBlogs->isEmpty()) {
        $latestBlogs = \App\Models\Page::where('is_published', true)->orderBy('id', 'desc')->take(3)->get();
    }
}

$sectionLabel = $block->setting('section_label') ?: 'Our Insights';
$sectionTitle = $block->setting('section_title') ?: 'Check Out Our Latest Industry Insights';
$sectionSubtitle = $block->setting('section_subtitle') ?: 'Stay updated with the latest industry regulations, compliance standards, and workplace testing guides.';
$buttonText = $block->setting('button_text') ?: 'View All Articles →';

$blogListUrl = \Illuminate\Support\Facades\Route::has('blog.list') ? route('blog.list') : url('/pages');
$customButtonUrl = trim($block->setting('button_url') ?? '');
if (!empty($customButtonUrl) && $customButtonUrl !== '/blogs' && $customButtonUrl !== $blogListUrl) {
    $viewAllBlogsUrl = $customButtonUrl;
} elseif ($blockTenant) {
    $viewAllBlogsUrl = url("/tenant/{$blockTenant->slug}/blog");
} else {
    $viewAllBlogsUrl = $blogListUrl;
}
?>
<section class="section" id="blogs" style="background: #f8fafc; padding: 60px 24px;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="text-align: center; max-width: 750px; margin: 0 auto 48px;">
            <span style="display:inline-block; font-size:12px; font-weight:800; color:#f16001; letter-spacing:1px; text-transform:uppercase; margin-bottom:8px;"><?= htmlspecialchars($sectionLabel) ?></span>
            <h2 style="font-family:'Outfit',sans-serif; font-size:32px; font-weight:800; color:#002855; margin-bottom:12px;"><?= htmlspecialchars($sectionTitle) ?></h2>
            <p style="font-size:16px; color:#5b6f8a;"><?= nl2br(htmlspecialchars($sectionSubtitle)) ?></p>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;">
            <?php foreach($latestBlogs as $blog): ?>
                <?php
                    $title = $blog->title ?? $blog->name ?? '';
                    $desc = $blog->description ?? $blog->content ?? '';
                    $desc = trim(preg_replace('/\s+/', ' ', strip_tags((string) $desc)));
                    $blogDetailUrl = url('/' . ($blog->slug ?? $blog->id));
                ?>
                <article style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 4px 14px rgba(0,0,0,0.04); display:flex; flex-direction:column; justify-content:space-between;">
                    <div>
                        <div style="font-size:12px; color:#64748b; margin-bottom:8px; font-weight:600;">
                            <?= date('M d, Y', strtotime($blog->created_at ?? 'now')) ?> • Certified Drug Test Center
                        </div>
                        <h3 style="font-size: 18px; font-weight: 800; color: #0b2545; margin-bottom: 10px; line-height: 1.35;"><?= htmlspecialchars(\Illuminate\Support\Str::limit($title, 72)) ?></h3>
                        <p style="font-size: 14px; color: #64748b; line-height: 1.6; margin-bottom: 16px;"><?= htmlspecialchars(\Illuminate\Support\Str::limit($desc, 140)) ?></p>
                    </div>
                    <div style="border-top:1px solid #f1f5f9; padding-top:14px; margin-top:10px;">
                        <a href="<?= $blogDetailUrl ?>" style="color:#f16001; font-weight:700; font-size:14px; text-decoration:none;">Read Full Guide &rarr;</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <div style="text-align:center;margin-top:48px">
            <a href="<?= $viewAllBlogsUrl ?>" style="display:inline-block; background:#0b2545; color:#fff; font-size:16px; font-weight:700; padding:14px 36px; border-radius:50px; text-decoration:none;"><?= htmlspecialchars($buttonText) ?></a>
        </div>
    </div>
</section>
