<?php
$modalId = 'heroVideoModal_' . uniqid();
$videoUrl = $block->setting('video_url') ?: 'https://www.youtube.com/embed/dQw4w9WgXcQ';
$imageUrl = $block->setting('image_url') ?: asset('assets/images/hero-banner-preview.png');
$bgColor = $block->setting('bg_color') ?: '#FFF6F0';
?>

<div class="hero-video-banner-block" style="background-color: <?= $bgColor ?>; padding: 60px 24px; font-family: 'Inter', sans-serif;">
    <div style="max-width: 1240px; margin: 0 auto; display: flex; flex-wrap: wrap; align-items: center; gap: 40px;">
        
        <?php /* LEFT COLUMN */ ?>
        <div style="flex: 1 1 500px; min-width: 300px;">
            <h1 phpb-editable="true" style="font-family: 'Outfit', sans-serif; font-size: 38px; font-weight: 800; color: #002855; line-height: 1.25; margin-bottom: 20px;">
                <?= $block->setting('title') ?>
            </h1>
            <p phpb-editable="true" style="font-size: 16px; color: #334e68; line-height: 1.65; margin-bottom: 28px;">
                <?= nl2br($block->setting('description')) ?>
            </p>
            <?php if ($block->setting('button_text')): ?>
                <button type="button" onclick="document.getElementById('<?= $modalId ?>').style.display='flex'" style="display: inline-flex; align-items: center; gap: 10px; background: #f16001; color: #ffffff; border: none; padding: 14px 28px; border-radius: 50px; font-size: 16px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 18px rgba(241,96,1,.3); transition: transform 0.2s ease, background 0.2s ease;">
                    <i class="ri-play-circle-fill" style="font-size: 22px;"></i>
                    <span phpb-editable="true"><?= $block->setting('button_text') ?></span>
                </button>
            <?php endif; ?>
        </div>

        <?php /* RIGHT COLUMN (IMAGE & PLAY OVERLAY) */ ?>
        <div style="flex: 1 1 500px; min-width: 300px; position: relative;">
            <div style="position: relative; border-radius: 16px; overflow: hidden; box-shadow: 0 12px 36px rgba(0,40,85,0.12); cursor: pointer;" onclick="document.getElementById('<?= $modalId ?>').style.display='flex'">
                <img src="<?= $imageUrl ?>" alt="Informational Banner Preview" style="width: 100%; height: auto; display: block; object-fit: cover; min-height: 280px;" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800&auto=format&fit=crop&q=80';">
                
                <?php /* PLAY OVERLAY BUTTON */ ?>
                <div style="position: absolute; inset: 0; background: rgba(0,40,85,0.25); display: flex; align-items: center; justify-content: center; transition: background 0.2s ease;">
                    <div style="width: 68px; height: 68px; background: #ffffff; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 24px rgba(0,0,0,0.3);">
                        <i class="ri-play-fill" style="font-size: 36px; color: #f16001; margin-left: 4px;"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php /* VIDEO MODAL POPUP */ ?>
<div id="<?= $modalId ?>" style="display: none; position: fixed; inset: 0; z-index: 999999; background: rgba(0, 40, 85, 0.85); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;" onclick="if(event.target===this){this.style.display='none'; document.getElementById('iframe_<?= $modalId ?>').src=''; document.getElementById('iframe_<?= $modalId ?>').src='<?= $videoUrl ?>';}">
    <div style="position: relative; max-width: 900px; width: 100%; background: #000; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.5);">
        <button type="button" onclick="document.getElementById('<?= $modalId ?>').style.display='none'; document.getElementById('iframe_<?= $modalId ?>').src=''; document.getElementById('iframe_<?= $modalId ?>').src='<?= $videoUrl ?>';" style="position: absolute; top: 12px; right: 12px; z-index: 10; background: rgba(255,255,255,0.85); border: none; border-radius: 50%; width: 36px; height: 36px; font-size: 22px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #000;">&times;</button>
        <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
            <iframe id="iframe_<?= $modalId ?>" src="<?= $videoUrl ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
</div>
