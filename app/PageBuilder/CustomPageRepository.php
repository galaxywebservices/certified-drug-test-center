<?php

namespace App\PageBuilder;

use PHPageBuilder\Repositories\PageRepository;
use App\Models\Page;
use PHPageBuilder\Repositories\PageTranslationRepository;
use PHPageBuilder\Modules\GrapesJS\PageRenderer;

class CustomPageRepository extends PageRepository
{
    public function updatePageData($page, array $data)
    {
        $updateResult = parent::updatePageData($page, $data);

        // Sync back to CDTC pages table
        $pbPageId = $page->getId();
        $translations = (new PageTranslationRepository)->findWhere('page_id', $pbPageId);

        if (!empty($translations)) {
            $route = $translations[0]->route;
            $slug = ltrim($route, '/');

            $cdtcPage = Page::where('slug', $slug)->first();
            if (!$cdtcPage && is_numeric($slug)) {
                $cdtcPage = Page::find($slug);
            }
            if (!$cdtcPage) {
                $cdtcPage = Page::where('title', $translations[0]->title)->first();
            }

            if ($cdtcPage) {
                // Render the body HTML from the saved pagebuilder data
                $theme = phpb_instance('theme', [
                    phpb_config('theme'),
                    phpb_config('theme.active_theme')
                ]);
                $renderer = new PageRenderer($theme, $page);
                $renderedContent = $renderer->renderBody();

                $cdtcPage->content = $renderedContent;
                $cdtcPage->save();
            }
        }

        return $updateResult;
    }
}
