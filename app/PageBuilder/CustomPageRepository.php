<?php

namespace App\PageBuilder;

use PHPageBuilder\Repositories\PageRepository;
use App\Models\Page;
use PHPageBuilder\Repositories\PageTranslationRepository;
use PHPageBuilder\Modules\GrapesJS\PageRenderer;

class CustomPageRepository extends PageRepository
{
    /**
     * Resiliently resolve a page: checks pagebuilder__pages, or auto-syncs from CDTC Page model
     */
    public function findWithId($id)
    {
        $page = parent::findWithId($id);
        if ($page) {
            return $page;
        }

        // Fallback: Check if $id corresponds to a CDTC Page model by ID or slug
        if (!empty($id)) {
            $cdtcPage = is_numeric($id) ? Page::find($id) : Page::where('slug', $id)->first();
            if ($cdtcPage) {
                $pbRoute = '/' . ltrim($cdtcPage->slug, '/');
                $translation = \Illuminate\Support\Facades\DB::table('pagebuilder__page_translations')
                    ->where('route', $pbRoute)
                    ->first();

                if ($translation) {
                    $page = parent::findWithId($translation->page_id);
                    if ($page) {
                        return $page;
                    }
                }

                // If not provisioned yet, provision on the fly
                $pbPageId = \Illuminate\Support\Facades\DB::table('pagebuilder__pages')->insertGetId([
                    'name' => $cdtcPage->title,
                    'layout' => 'master',
                    'data' => json_encode([
                        'html' => [$cdtcPage->content ?: ''],
                        'css' => '',
                        'components' => [],
                        'assets' => [],
                        'styles' => [],
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                \Illuminate\Support\Facades\DB::table('pagebuilder__page_translations')->insert([
                    'page_id' => $pbPageId,
                    'locale' => 'en',
                    'title' => \Illuminate\Support\Str::limit($cdtcPage->title, 250, ''),
                    'route' => $pbRoute,
                    'meta_title' => \Illuminate\Support\Str::limit($cdtcPage->meta_title ?: $cdtcPage->title, 250, ''),
                    'meta_description' => $cdtcPage->meta_description ?: '',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return parent::findWithId($pbPageId);
            }
        }

        // If still not found, fallback to first available page
        $firstPbPage = \Illuminate\Support\Facades\DB::table('pagebuilder__pages')->first();
        if ($firstPbPage) {
            return parent::findWithId($firstPbPage->id);
        }

        return null;
    }

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
