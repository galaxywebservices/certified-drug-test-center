<?php
$blockTenant = isset($tenantOrganization) && $tenantOrganization ? $tenantOrganization : (function_exists('get_active_tenant') ? get_active_tenant() : null);

$heroImageCandidates = [
    public_path('assets/images/banner/ndasa-hero-lab.jpg'),
    base_path('public/assets/images/banner/ndasa-hero-lab.jpg'),
    base_path('Modules/LMS/resources/assets/images/ndasa-hero-lab.jpg'),
    public_path('theme/assets/images/ndasa-hero-lab.jpg'),
];
$heroBgImage = $block->setting('bg_image') ?: asset('assets/images/banner/ndasa-hero-lab.jpg');
foreach ($heroImageCandidates as $cand) {
    if (file_exists($cand)) {
        $heroBgImage = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($cand));
        break;
    }
}

$topTitle = $block->setting('top_title') ?: ($blockTenant ? strtoupper($blockTenant->name) : 'NDASA UNIVERSITY');
$mainTitle = html_entity_decode($block->setting('main_title') ?: "DRUG & ALCOHOL<br>SCREENING TRAINING", ENT_QUOTES | ENT_HTML5, 'UTF-8');
if (!str_contains($mainTitle, '<br>')) {
    $mainTitle = nl2br($mainTitle);
}

$rawVideoUrl = $block->setting('video_url') ?: 'https://drive.google.com/file/d/1LjD40vcwEJ-0QdIJKdiMkJMSU1Wuf5J0/view';
$videoButtonText = $block->setting('video_button_text') ?: 'Watch Informational Video';

// Normalize video embed URL
$embedVideoUrl = $rawVideoUrl;
if (str_contains($embedVideoUrl, 'drive.google.com/file/d/')) {
    $embedVideoUrl = preg_replace('/\/view(\?.*)?$/', '/preview', $embedVideoUrl);
    if (!str_contains($embedVideoUrl, '/preview')) {
        $embedVideoUrl = rtrim($embedVideoUrl, '/') . '/preview';
    }
} elseif (str_contains($embedVideoUrl, 'youtube.com/watch') || str_contains($embedVideoUrl, 'youtu.be/')) {
    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $embedVideoUrl, $match)) {
        $embedVideoUrl = 'https://www.youtube.com/embed/' . $match[1] . '?autoplay=1&rel=0';
    }
} elseif (str_contains($embedVideoUrl, 'vimeo.com/')) {
    if (preg_match('/vimeo\.com\/([0-9]+)/', $embedVideoUrl, $match)) {
        $embedVideoUrl = 'https://player.vimeo.com/video/' . $match[1] . '?autoplay=1';
    }
}

$feature1Title = $block->setting('feature_1_title') ?: 'Drug & Alcohol Collections Training';
$feature1Sub = $block->setting('feature_1_subtitle') ?: 'Online Courses & Instructor Led Classes';
$feature2Title = $block->setting('feature_2_title');
if (!$feature2Title || stripos($feature2Title, 'Qualified & Certified') !== false) {
    $feature2Title = 'Built to 49 CFR Part 40 Requirements';
}
$feature2Sub = $block->setting('feature_2_subtitle') ?: 'DOT: FAA, FRA, FTA, FMCSA, PHMSA & USCG';
$feature3Title = $block->setting('feature_3_title') ?: 'Expert Support Desk';
$feature3Sub = $block->setting('feature_3_subtitle') ?: 'Staffed by Industry Professionals';
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">

<style>
    .page-hero {
        background: linear-gradient(to right, rgba(15, 23, 42, 0.92) 0%, rgba(15, 23, 42, 0.75) 45%, rgba(15, 23, 42, 0.35) 100%), 
                    url("<?= $heroBgImage ?>") center right / cover no-repeat;
        position: relative;
        overflow: hidden;
        min-height: 500px;
        display: flex;
        align-items: center;
        width: 100%;
    }
    .page-hero-container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 60px 24px 70px;
        position: relative;
        z-index: 2;
    }
    .page-hero-content {
        max-width: 650px;
        text-align: left;
    }
    .hero-top-title {
        font-family: 'Outfit', sans-serif;
        font-size: clamp(26px, 3.8vw, 40px);
        font-weight: 900;
        color: #ffffff;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 6px;
        line-height: 1.15;
    }
    .hero-main-title {
        font-family: 'Outfit', sans-serif;
        font-size: clamp(30px, 4.4vw, 46px);
        font-weight: 900;
        color: #ffffff;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        margin-bottom: 22px;
        line-height: 1.15;
    }

    /* Video CTA Button */
    .hero-video-cta {
        margin-bottom: 30px;
    }
    .btn-hero-watch-video {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: linear-gradient(135deg, #e65a00 0%, #ff7a1a 100%);
        color: #ffffff !important;
        font-family: 'Outfit', sans-serif;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 0.3px;
        padding: 10px 24px 10px 14px;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 8px 24px rgba(230, 90, 0, 0.4);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-hero-watch-video:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(230, 90, 0, 0.55);
        background: linear-gradient(135deg, #f0640a 0%, #ff8a33 100%);
    }
    .btn-hero-watch-video .play-icon-circle {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #ffffff;
        color: #e65a00;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }
    .btn-hero-watch-video:hover .play-icon-circle {
        transform: scale(1.1);
    }

    .hero-features {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .hero-feature-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }
    .hero-feature-icon {
        font-size: 28px;
        color: #ffffff;
        line-height: 1;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .hero-feature-text strong {
        display: block;
        font-size: 17px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 3px;
        font-family: 'Outfit', sans-serif;
        letter-spacing: 0.3px;
    }
    .hero-feature-text span {
        display: block;
        font-size: 13.5px;
        color: rgba(255, 255, 255, 0.85);
        font-weight: 400;
        line-height: 1.4;
    }

    /* Video Modal */
    .hero-video-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(10, 15, 30, 0.88);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 999999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }
    .hero-video-modal-backdrop.active {
        opacity: 1;
        pointer-events: auto;
    }
    .hero-video-modal-dialog {
        position: relative;
        width: 100%;
        max-width: 920px;
        background: #0b1120;
        border-radius: 16px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.15);
        overflow: hidden;
        transform: scale(0.95);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .hero-video-modal-backdrop.active .hero-video-modal-dialog {
        transform: scale(1);
    }
    .hero-video-modal-close {
        position: absolute;
        top: -44px;
        right: 0;
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 20px;
        transition: all 0.2s ease;
    }
    .hero-video-modal-close:hover {
        background: #e65a00;
        transform: rotate(90deg);
    }
    .hero-video-modal-body {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
        height: 0;
        overflow: hidden;
        background: #000;
    }
    .hero-video-modal-body iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }

    @media (max-width: 768px) {
        .page-hero {
            min-height: auto;
            background-position: center;
        }
        .page-hero-container {
            padding: 45px 16px 50px;
        }
        .hero-main-title {
            margin-bottom: 18px;
        }
        .hero-video-cta {
            margin-bottom: 24px;
        }
        .hero-features {
            gap: 16px;
        }
        .hero-video-modal-close {
            top: 8px;
            right: 8px;
            z-index: 10;
            background: rgba(0,0,0,0.6);
        }
    }
</style>

<section class="page-hero">
    <div class="page-hero-container">
        <div class="page-hero-content">
            <h2 class="hero-top-title"><?= strtoupper($topTitle) ?></h2>
            <h1 class="hero-main-title"><?= $mainTitle ?></h1>

            <div class="hero-video-cta">
                <button type="button" class="btn-hero-watch-video" onclick="openHeroVideoModal('<?= htmlspecialchars($embedVideoUrl, ENT_QUOTES) ?>')">
                    <span class="play-icon-circle"><i class="ri-play-fill"></i></span>
                    <span><?= htmlspecialchars($videoButtonText) ?></span>
                </button>
            </div>
            
            <div class="hero-features">
                <div class="hero-feature-item">
                    <div class="hero-feature-icon">
                        <i class="ri-book-open-fill"></i>
                    </div>
                    <div class="hero-feature-text">
                        <strong><?= $feature1Title ?></strong>
                        <span><?= $feature1Sub ?></span>
                    </div>
                </div>
                <div class="hero-feature-item">
                    <div class="hero-feature-icon">
                        <i class="ri-bus-fill"></i>
                    </div>
                    <div class="hero-feature-text">
                        <strong><?= $feature2Title ?></strong>
                        <span><?= $feature2Sub ?></span>
                    </div>
                </div>
                <div class="hero-feature-item">
                    <div class="hero-feature-icon">
                        <i class="ri-customer-service-2-fill"></i>
                    </div>
                    <div class="hero-feature-text">
                        <strong><?= $feature3Title ?></strong>
                        <span><?= $feature3Sub ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Video Modal Popup -->
<div id="heroVideoModal" class="hero-video-modal-backdrop" onclick="handleHeroVideoModalClick(event)">
    <div class="hero-video-modal-dialog">
        <button type="button" class="hero-video-modal-close" onclick="closeHeroVideoModal()" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
        <div class="hero-video-modal-body">
            <iframe id="heroVideoIframe" src="about:blank" allow="autoplay; fullscreen; encrypted-media" allowfullscreen></iframe>
        </div>
    </div>
</div>

<script>
    function openHeroVideoModal(videoUrl) {
        var modal = document.getElementById('heroVideoModal');
        var iframe = document.getElementById('heroVideoIframe');
        if (modal && iframe) {
            iframe.src = videoUrl;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeHeroVideoModal() {
        var modal = document.getElementById('heroVideoModal');
        var iframe = document.getElementById('heroVideoIframe');
        if (modal && iframe) {
            modal.classList.remove('active');
            iframe.src = 'about:blank';
            document.body.style.overflow = '';
        }
    }

    function handleHeroVideoModalClick(e) {
        if (e.target.id === 'heroVideoModal') {
            closeHeroVideoModal();
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' || e.key === 'Esc') {
            closeHeroVideoModal();
        }
    });
</script>
