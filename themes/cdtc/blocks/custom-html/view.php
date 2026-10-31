<?php
$rawHtml = $block->setting('raw_html', true);
if ($rawHtml !== null && $rawHtml !== '') {
    $rawHtml = html_entity_decode(stripslashes($rawHtml), ENT_QUOTES | ENT_HTML5, 'UTF-8');
}
$isEditMode = function_exists('phpb_in_editmode') ? phpb_in_editmode() : false;
?>
<div class="custom-html-block-wrapper" style="width: 100%; position: relative; clear: both;">
    <?php if (empty(trim($rawHtml ?? ''))): ?>
        <?php if ($isEditMode): ?>
            <div class="custom-html-empty-placeholder" style="padding: 30px 20px; text-align: center; border: 2px dashed #93c5fd; border-radius: 10px; background: #eff6ff; color: #1e40af; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; margin: 12px auto; max-width: 800px; cursor: pointer;">
                <div style="font-size: 24px; margin-bottom: 6px;">&lt; / &gt;</div>
                <h4 style="margin: 0 0 4px 0; font-size: 15px; font-weight: 700; color: #1e3a8a;">Custom HTML Block (Empty)</h4>
                <p style="margin: 0 auto; font-size: 13px; color: #3b82f6;">Click this block to select it, then paste your raw HTML or embed code in the settings panel on the right.</p>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <?= $rawHtml ?>
    <?php endif; ?>
</div>
