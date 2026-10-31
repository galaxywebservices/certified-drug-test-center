<div class="top-banner py-16 text-center" style="background-color: <?= $block->setting('bg_color') ?: '#002855' ?>; color: <?= $block->setting('text_color') ?: '#ffffff' ?>; padding: 64px 24px;">
    <div class="container mx-auto" style="max-width: 1000px;">
        <h1 class="text-4xl font-bold mb-3" phpb-editable="true" style="font-family: 'Outfit', sans-serif; font-size: 36px; font-weight: 800; margin-bottom: 12px;"><?= $block->setting('title') ?></h1>
        <p class="text-xl opacity-90" phpb-editable="true" style="font-size: 18px; line-height: 1.6; opacity: 0.9; max-width: 750px; margin: 0 auto;"><?= nl2br($block->setting('subtitle')) ?></p>
    </div>
</div>
