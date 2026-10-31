<?php
$blockTenant = isset($tenantOrganization) && $tenantOrganization ? $tenantOrganization : (function_exists('get_active_tenant') ? get_active_tenant() : null);

$courseListUrl = \Illuminate\Support\Facades\Route::has('course.list') ? route('course.list') : url('/category/urine-drug-tests');
$contactPageUrl = \Illuminate\Support\Facades\Route::has('contact.page') ? route('contact.page') : url('/contact-us');

$primaryBtnUrl = trim($block->setting('primary_btn_url') ?? '');
if (empty($primaryBtnUrl) || $primaryBtnUrl === '/courses' || $primaryBtnUrl === $courseListUrl) {
    $primaryBtnUrl = $blockTenant ? url("/tenant/{$blockTenant->slug}/courses") : $courseListUrl;
}

$secondaryBtnUrl = trim($block->setting('secondary_btn_url') ?? '');
if (empty($secondaryBtnUrl) || $secondaryBtnUrl === '/contact-us' || $secondaryBtnUrl === $contactPageUrl) {
    $secondaryBtnUrl = $blockTenant ? url("/tenant/{$blockTenant->slug}/contact") : $contactPageUrl;
}
?>
<div class="cta-band" style="background:linear-gradient(135deg, #002855, #003c7d); padding:80px 24px; text-align:center; border-top:4px solid #f16001;">
    <div style="max-width:800px; margin:0 auto;">
        <h2 style="font-family:'Outfit',sans-serif; font-size:36px; font-weight:800; color:#fff; margin-bottom:16px;"><?= htmlspecialchars($block->setting('title')) ?></h2>
        <p style="color:rgba(255,255,255,0.8); font-size:17px; margin-bottom:32px; line-height:1.6;"><?= nl2br(htmlspecialchars($block->setting('subtitle'))) ?></p>
        <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
            <?php if ($block->setting('primary_btn_text')): ?>
                <a href="<?= $primaryBtnUrl ?>" style="background:#f16001; color:#fff; padding:14px 32px; border-radius:50px; font-size:16px; font-weight:700; text-decoration:none; box-shadow:0 4px 18px rgba(241,96,1,0.3);">
                    <?= htmlspecialchars($block->setting('primary_btn_text')) ?>
                </a>
            <?php endif; ?>
            <?php if ($block->setting('secondary_btn_text')): ?>
                <a href="<?= $secondaryBtnUrl ?>" style="background:transparent; color:#fff; border:2px solid rgba(255,255,255,0.4); padding:14px 32px; border-radius:50px; font-size:16px; font-weight:700; text-decoration:none;">
                    <?= htmlspecialchars($block->setting('secondary_btn_text')) ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
