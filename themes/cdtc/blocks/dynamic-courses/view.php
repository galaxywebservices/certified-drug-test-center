<?php
$blockTenant = isset($tenantOrganization) && $tenantOrganization ? $tenantOrganization : (function_exists('get_active_tenant') ? get_active_tenant() : null);

$products = [];
if (class_exists('\Modules\LMS\Models\Courses\Course')) {
    $products = \Modules\LMS\Models\Courses\Course::where('status', 'Approved')->take(12)->get();
} elseif (class_exists('\App\Models\Product')) {
    $products = \App\Models\Product::where('is_active', true)->orderBy('is_popular', 'desc')->take(8)->get();
}

$sectionLabel = html_entity_decode(stripslashes($block->setting('section_label') ?: 'Featured Substance Tests'), ENT_QUOTES | ENT_HTML5, 'UTF-8');
$sectionTitle = html_entity_decode(stripslashes($block->setting('section_title') ?: 'Certified Lab Drug & Alcohol Tests'), ENT_QUOTES | ENT_HTML5, 'UTF-8');
$sectionSubtitle = html_entity_decode(stripslashes($block->setting('section_subtitle') ?: "SAMHSA accredited laboratory testing with nationwide same-day donor authorization passes."), ENT_QUOTES | ENT_HTML5, 'UTF-8');
$buttonText = html_entity_decode(stripslashes($block->setting('button_text') ?: 'View All Drug Tests →'), ENT_QUOTES | ENT_HTML5, 'UTF-8');

$courseListUrl = \Illuminate\Support\Facades\Route::has('course.list') ? route('course.list') : url('/category/urine-drug-tests');
$customButtonUrl = trim($block->setting('button_url') ?? '');
if (!empty($customButtonUrl) && $customButtonUrl !== '/courses' && $customButtonUrl !== $courseListUrl) {
    $viewAllCoursesUrl = $customButtonUrl;
} elseif ($blockTenant) {
    $viewAllCoursesUrl = url("/tenant/{$blockTenant->slug}/courses");
} else {
    $viewAllCoursesUrl = $courseListUrl;
}
?>
<section class="section" id="courses" style="padding:60px 24px; background:#f8fafc;">
    <div style="max-width:1200px; margin:0 auto;">
        <div style="text-align:center; max-width:750px; margin:0 auto 48px;">
            <span style="display:inline-block; font-size:12px; font-weight:800; color:#f16001; letter-spacing:1px; text-transform:uppercase; margin-bottom:8px;"><?= htmlspecialchars($sectionLabel, ENT_QUOTES, 'UTF-8') ?></span>
            <h2 style="font-family:'Outfit',sans-serif; font-size:32px; font-weight:800; color:#002855; margin-bottom:12px;"><?= htmlspecialchars($sectionTitle, ENT_QUOTES, 'UTF-8') ?></h2>
            <p style="font-size:16px; color:#5b6f8a;"><?= nl2br(htmlspecialchars($sectionSubtitle, ENT_QUOTES, 'UTF-8')) ?></p>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:24px;">
            <?php foreach($products as $item): ?>
                <?php
                    $isCourse = $item instanceof \Illuminate\Database\Eloquent\Model && isset($item->title);
                    $title = $isCourse ? $item->title : ($item->name ?? '');
                    $desc = $isCourse ? ($item->short_description ?? '') : ($item->description ?? '');
                    $price = $isCourse ? ($item->coursePrice->price ?? 0) : ($item->price ?? 0);
                    $detailUrl = $isCourse ? url("/courses/{$item->slug}") : url("/product/{$item->slug}");
                ?>
                <article style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:24px; box-shadow:0 4px 14px rgba(0,0,0,0.04); display:flex; flex-direction:column; justify-content:space-between;">
                    <div>
                        <div style="font-size:12px; font-weight:700; color:#c1121f; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Accredited Test</div>
                        <h3 style="font-size:18px; font-weight:800; color:#0b2545; margin-bottom:10px; line-height:1.35;"><?= htmlspecialchars($title) ?></h3>
                        <p style="font-size:14px; color:#64748b; line-height:1.6; margin-bottom:16px;"><?= htmlspecialchars(\Illuminate\Support\Str::limit(strip_tags((string)$desc), 120)) ?></p>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid #f1f5f9; padding-top:16px; margin-top:12px;">
                        <span style="font-size:20px; font-weight:800; color:#0b2545;">$<?= number_format($price, 2) ?></span>
                        <a href="<?= $detailUrl ?>" style="background:#0b2545; color:#fff; font-size:13px; font-weight:700; padding:8px 18px; border-radius:6px; text-decoration:none;">Learn More &rarr;</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div style="text-align:center; margin-top:48px;">
            <a href="<?= $viewAllCoursesUrl ?>" style="display:inline-block; background:#f16001; color:#fff; font-size:16px; font-weight:700; padding:14px 36px; border-radius:50px; text-decoration:none; box-shadow:0 4px 18px rgba(241,96,1,0.25);"><?= htmlspecialchars($buttonText) ?></a>
        </div>
    </div>
</section>
