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
}
