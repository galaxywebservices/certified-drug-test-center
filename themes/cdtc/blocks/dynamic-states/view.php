<?php
$badge = $block->setting('section_badge') ?: 'Nationwide Walk-In Network';
$title = $block->setting('section_title') ?: 'Find Drug Testing Locations in All 50 States';
$subtitle = $block->setting('section_subtitle') ?: 'Over 20,000 certified walk-in collection sites nationwide partnering with Quest Diagnostics and Labcorp. Select your state below to find local collection centers near you.';

try {
    $states = \App\Models\State::where('is_active', true)->orderBy('name')->get();
    if ($states->isEmpty()) {
        $states = \App\Models\State::orderBy('name')->get();
    }
} catch (\Throwable $e) {
    $states = collect();
}
?>

<section class="dynamic-states-section" style="padding: 40px 0; background: #ffffff; width: 100%; clear: both;">
    <style>
        .dynamic-states-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 16px;
        }
        .dynamic-states-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .dynamic-states-badge {
            display: inline-block;
            background: #e0f2fe;
            color: #0369a1;
            padding: 4px 14px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 12px;
        }
        .dynamic-states-title {
            font-family: 'Outfit', -apple-system, sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: #0B2545;
            margin: 0 0 10px;
            line-height: 1.3;
        }
        .dynamic-states-subtitle {
            font-size: 15px;
            color: #64748B;
            max-width: 750px;
            margin: 0 auto;
            line-height: 1.6;
        }
        .dynamic-states-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-top: 24px;
        }
        @media (max-width: 1024px) {
            .dynamic-states-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        @media (max-width: 640px) {
            .dynamic-states-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }
            .dynamic-states-title {
                font-size: 20px;
            }
        }
        .state-chip-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 10px 14px;
            text-decoration: none;
            color: #1E293B;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }
        .state-chip-card:hover {
            border-color: #C1121F;
            background: #FEF2F2;
            color: #C1121F;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(193, 18, 31, 0.1);
        }
        .state-chip-badge {
            background: #F1F5F9;
            color: #475569;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 4px;
            letter-spacing: 0.5px;
            transition: all 0.2s ease;
        }
        .state-chip-card:hover .state-chip-badge {
            background: #C1121F;
            color: #ffffff;
        }
    </style>

    <div class="dynamic-states-container">
        <div class="dynamic-states-header">
            <span class="dynamic-states-badge"><?= htmlspecialchars($badge) ?></span>
            <h3 class="dynamic-states-title"><?= htmlspecialchars($title) ?></h3>
            <p class="dynamic-states-subtitle"><?= htmlspecialchars($subtitle) ?></p>
        </div>

        <div class="dynamic-states-grid">
            <?php foreach ($states as $state): ?>
                <a href="<?= url('/locations/' . $state->slug) ?>" class="state-chip-card">
                    <span><?= htmlspecialchars($state->name) ?></span>
                    <span class="state-chip-badge"><?= htmlspecialchars($state->abbr) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
