<?php
$blockTenant = isset($tenantOrganization) && $tenantOrganization ? $tenantOrganization : (function_exists('get_active_tenant') ? get_active_tenant() : null);

$bannerImg = $block->setting('banner_image') ?: asset('assets/images/leadership-conference-banner-final.png');
$buttonText = $block->setting('button_text') ?: 'Register for Conference';

$courseListUrl = \Illuminate\Support\Facades\Route::has('course.list') ? route('course.list') : url('/category/urine-drug-tests');
$buttonUrl = trim($block->setting('button_url') ?? '');
if (empty($buttonUrl) || $buttonUrl === '/courses' || $buttonUrl === $courseListUrl) {
    $buttonUrl = $blockTenant ? url("/tenant/{$blockTenant->slug}/courses") : $courseListUrl;
}
?>

<section class="conference-banner" style="background:#eef2f7; padding:24px 0 36px; border-bottom:1px solid #d0d7e2;">
    <div style="max-width:1100px; margin:0 auto; padding:0 16px; text-align:center;">
        <div style="background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 8px 30px rgba(0,40,85,0.08); border:1px solid #dce3ed;">
            <a href="<?= $buttonUrl ?>">
                <img src="<?= $bannerImg ?>" alt="National Drug Testing Leadership Conference" style="width:100%; height:auto; display:block;" onerror="this.onerror=null; this.style.display='none';">
            </a>
            <?php if ($buttonText): ?>
                <div style="padding:16px 20px; background:#f8fafc; border-top:1px solid #eef2f7; display:flex; justify-content:center; align-items:center;">
                    <a href="<?= $buttonUrl ?>" style="display:inline-flex; align-items:center; gap:8px; background:#f16001; color:#fff; font-size:16px; font-weight:700; padding:12px 32px; border-radius:50px; text-decoration:none; box-shadow:0 4px 14px rgba(241,96,1,0.25); transition:all .2s;">
                        <span><?= htmlspecialchars($buttonText) ?></span>
                        <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
