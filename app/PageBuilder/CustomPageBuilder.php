<?php

namespace App\PageBuilder;

use PHPageBuilder\Contracts\PageContract;
use PHPageBuilder\Modules\GrapesJS\PageBuilder as BasePageBuilder;

class CustomPageBuilder extends BasePageBuilder
{
    /**
     * Override handleRequest to ensure CustomPageRepository is used for resolving the page
     */
    public function handleRequest($route, $action, PageContract $page = null)
    {
        if (is_null($page)) {
            $pageId = $_GET['page'] ?? null;
            $pageRepository = new CustomPageRepository;
            $page = $pageRepository->findWithId($pageId);
        }

        return parent::handleRequest($route, $action, $page);
    }

    /**
     * Override updatePage to ensure CustomPageRepository is used and synced back to CDTC pages table
     */
    public function updatePage(PageContract $page, $data)
    {
        $pageRepository = new CustomPageRepository;
        return $pageRepository->updatePageData($page, $data);
    }

    /**
     * Return this page's components in the format passed to GrapesJS.
     * When components are empty, fallback to the page's HTML content so GrapesJS renders and parses it.
     */
    public function getPageComponents(PageContract $page)
    {
        $components = parent::getPageComponents($page);

        if (empty($components) || empty($components[0])) {
            $data = $page->getBuilderData();
            $html = null;

            if (!empty($data['html'])) {
                $html = is_array($data['html']) ? ($data['html'][0] ?? null) : $data['html'];
            }

            if (empty($html)) {
                $translations = (new \PHPageBuilder\Repositories\PageTranslationRepository)->findWhere('page_id', $page->getId());
                if (!empty($translations)) {
                    $slug = ltrim($translations[0]->route, '/');
                    $cdtcPage = \App\Models\Page::where('slug', $slug)->first();
                    if (!$cdtcPage && is_numeric($slug)) {
                        $cdtcPage = \App\Models\Page::find($slug);
                    }
                    if ($cdtcPage) {
                        $html = $cdtcPage->content;
                    }
                }
            }

            if (!empty($html)) {
                return [0 => $html];
            }
        }

        return $components;
    }
}
