<div class="image-banner-block" style="padding: 24px 0;">
    <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
        <?php if ($block->setting('link_url')): ?>
            <a href="<?= $block->setting('link_url') ?>">
                <img src="<?= $block->setting('image_url') ?>" alt="<?= htmlspecialchars($block->setting('alt_text')) ?>" style="max-width: 100%; height: auto; border-radius: 12px; display: inline-block;">
            </a>
        <?php else: ?>
            <img src="<?= $block->setting('image_url') ?>" alt="<?= htmlspecialchars($block->setting('alt_text')) ?>" style="max-width: 100%; height: auto; border-radius: 12px; display: inline-block;">
        <?php endif; ?>
    </div>
</div>
