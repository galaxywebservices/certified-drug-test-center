<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class NavigationItem extends Model
{
    use HasFactory;

    protected $table = 'navigation_items';

    protected $fillable = [
        'parent_id',
        'title',
        'url',
        'target',
        'order',
        'is_active',
        'page_id',
        'css_class',
        'badge',
        'is_cta',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_cta' => 'boolean',
        'order' => 'integer',
        'parent_id' => 'integer',
        'page_id' => 'integer',
    ];

    public const CACHE_KEY = 'global_navigation_menu_tree';

    protected static function booted(): void
    {
        static::saved(function () {
            Cache::forget(self::CACHE_KEY);
        });

        static::deleted(function () {
            Cache::forget(self::CACHE_KEY);
        });
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order')->orderBy('id');
    }

    public function activeChildren(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('id');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('id');
    }

    /**
     * Resolves the final href URL for display.
     */
    public function getHrefAttribute(): string
    {
        if ($this->page && $this->page->slug) {
            return url('/' . ltrim($this->page->slug, '/'));
        }

        if (empty($this->url)) {
            return '#';
        }

        if (str_starts_with($this->url, 'http://') || str_starts_with($this->url, 'https://') || str_starts_with($this->url, 'tel:') || str_starts_with($this->url, 'mailto:')) {
            return $this->url;
        }

        return url('/' . ltrim($this->url, '/'));
    }

    /**
     * Retrieve hierarchical tree of navigation items (cached for active front-end menu).
     */
    public static function getTree(bool $onlyActive = true)
    {
        if ($onlyActive) {
            return Cache::remember(self::CACHE_KEY, 86400, function () {
                return self::topLevel()
                    ->where('is_active', true)
                    ->with(['activeChildren' => function ($q) {
                        $q->with('page');
                    }, 'page'])
                    ->orderBy('order')
                    ->orderBy('id')
                    ->get();
            });
        }

        return self::topLevel()
            ->with(['children' => function ($q) {
                $q->with('page')->orderBy('order')->orderBy('id');
            }, 'page'])
            ->orderBy('order')
            ->orderBy('id')
            ->get();
    }

    /**
     * Clear the navigation cache manually.
     */
    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Seeds or resets default navigation items matching the certified site menu.
     * Automatically attaches any client-created CMS pages marked for navigation.
     */
    public static function seedDefaultNavigation(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        self::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 1. Urine Tests Dropdown
        $urinePage = Page::where('id', 816)
            ->orWhere('slug', 'urine-drug-test-near-you-from-8999')
            ->orWhere('slug', 'like', '%urine-drug-test-near-you%')
            ->first();

        $urineChildren = [];
        $order = 1;

        if ($urinePage) {
            $urineChildren[] = [
                'title' => 'Urine Drug Test Near You – From $89.99',
                'url' => '/' . ltrim($urinePage->slug, '/'),
                'page_id' => $urinePage->id,
                'order' => $order++,
            ];
        }

        $urineChildren = array_merge($urineChildren, [
            ['title' => '5 Panel NON-DOT ($89.99)', 'url' => '/product/5-panel-nondot', 'order' => $order++],
            ['title' => '5 Panel + Exp Opiates ($99.99)', 'url' => '/product/5-panel-exp-opiates', 'order' => $order++],
            ['title' => '10 Panel Drug Test ($109.99)', 'url' => '/product/10-panel', 'order' => $order++],
            ['title' => '10 Panel + Exp Opiates ($119.99)', 'url' => '/product/10-panel-exp-opiates', 'order' => $order++],
            ['title' => '12 Panel Comprehensive ($139.99)', 'url' => '/product/12-panel-comprehensive', 'order' => $order++],
            ['title' => 'View All Urine Tests →', 'url' => '/category/urine', 'css_class' => 'nav-dropdown-viewall', 'order' => $order++],
        ]);

        // 2. DOT Tests/Services Dropdown
        $dotChildren = [
            ['title' => '5 Panel DOT Drug Screen ($99.99)', 'url' => '/product/5-panel-dot', 'order' => 1],
            ['title' => 'DOT Breath Alcohol Test ($89.99)', 'url' => '/product/dot-breath-alcohol', 'order' => 2],
            ['title' => 'DOT Physical Exam ($159.99)', 'url' => '/product/dot-physical', 'order' => 3],
            ['title' => 'DOT Random Consortium ($99.99)', 'url' => '/product/1-year-consortium-membership-dot-drug-test', 'order' => 4],
            ['title' => 'FMCSA Return to Duty (RTD)', 'url' => '/product/5-panel-return-to-duty', 'order' => 5],
            ['title' => 'View All DOT Services →', 'url' => '/category/dot', 'css_class' => 'nav-dropdown-viewall', 'order' => 6],
        ];

        // 3. Hair Tests
        $fingernailPage = Page::whereRaw('LOWER(slug) = ?', ['fingernail-drug-testing'])->first();
        $hairChildren = [];
        if ($fingernailPage) {
            $hairChildren[] = [
                'title' => 'Fingernail Drug Testing',
                'url' => '/' . strtolower(ltrim($fingernailPage->slug, '/')),
                'page_id' => $fingernailPage->id,
                'order' => 1,
            ];
            $hairChildren[] = [
                'title' => 'View All Hair Tests →',
                'url' => '/category/hair',
                'css_class' => 'nav-dropdown-viewall',
                'order' => 2,
            ];
        }

        // 4. Occupational Health Tests
        $occChildren = [];
        $occOrder = 1;
        $respiratorPage = Page::whereRaw('LOWER(slug) = ?', ['respirator-fit-testing'])->first();
        if ($respiratorPage) {
            $occChildren[] = ['title' => 'Respirator Fit Testing', 'url' => '/' . strtolower(ltrim($respiratorPage->slug, '/')), 'page_id' => $respiratorPage->id, 'order' => $occOrder++];
        }
        $liftPage = Page::whereRaw('LOWER(slug) = ?', ['lift-test'])->first();
        if ($liftPage) {
            $occChildren[] = ['title' => 'Lift Tests', 'url' => '/' . strtolower(ltrim($liftPage->slug, '/')), 'page_id' => $liftPage->id, 'order' => $occOrder++];
        }
        $tbPage = Page::whereRaw('LOWER(slug) = ?', ['tb-testing'])->first();
        if ($tbPage) {
            $occChildren[] = ['title' => 'TB Testing', 'url' => '/' . strtolower(ltrim($tbPage->slug, '/')), 'page_id' => $tbPage->id, 'order' => $occOrder++];
        }
        if (!empty($occChildren)) {
            $occChildren[] = ['title' => 'View All Occupational Tests →', 'url' => '/category/occupational-health', 'css_class' => 'nav-dropdown-viewall', 'order' => $occOrder++];
        }

        $defaults = [
            [
                'title' => 'Urine Tests',
                'url' => '/category/urine',
                'order' => 1,
                'slug_key' => 'urine',
                'children' => $urineChildren,
            ],
            [
                'title' => 'DOT Tests/Services',
                'url' => '/category/dot',
                'order' => 2,
                'slug_key' => 'dot',
                'children' => $dotChildren,
            ],
            [
                'title' => 'Hair Tests',
                'url' => '/category/hair',
                'order' => 3,
                'slug_key' => 'hair',
                'children' => $hairChildren,
            ],
            [
                'title' => 'Alcohol/EtG Tests',
                'url' => '/category/alcohol',
                'order' => 4,
                'slug_key' => 'alcohol',
            ],
            [
                'title' => 'Oral Fluid Tests',
                'url' => '/category/oral-fluid-testing',
                'order' => 5,
                'slug_key' => 'oral-fluid',
            ],
            [
                'title' => 'Occupational (OCC) Tests',
                'url' => '/category/occupational-health',
                'order' => 6,
                'slug_key' => 'occupational',
                'children' => $occChildren,
            ],
            [
                'title' => 'Clinical Tests',
                'url' => '/category/lab-blood',
                'order' => 7,
                'slug_key' => 'clinical',
            ],
            [
                'title' => 'DNA Tests',
                'url' => '/category/dna-testing',
                'order' => 8,
                'slug_key' => 'dna',
            ],
            [
                'title' => 'MOBILE TESTING',
                'url' => '/category/on-site-mobile',
                'order' => 9,
                'slug_key' => 'mobile',
            ],
            [
                'title' => 'LOCATIONS',
                'url' => '/locations',
                'order' => 10,
                'css_class' => 'nav-locations-special',
                'children' => [
                    ['title' => '★ Certified Drug Test Centers (All 50 States)', 'url' => '/certified-drug-test-centers', 'css_class' => 'nav-dropdown-red-highlight', 'order' => 1],
                    ['title' => 'Browse All Testing Locations →', 'url' => '/locations', 'css_class' => 'nav-dropdown-bold-divider', 'order' => 2],
                ],
            ],
            [
                'title' => 'EMPLOYER SERVICES',
                'url' => '/employers',
                'order' => 11,
                'css_class' => 'nav-item-employer',
            ],
        ];

        $createdTopItems = [];

        foreach ($defaults as $top) {
            $children = $top['children'] ?? [];
            $slugKey = $top['slug_key'] ?? null;
            unset($top['children'], $top['slug_key']);

            $topItem = self::create($top);
            if ($slugKey) {
                $createdTopItems[$slugKey] = $topItem;
            }

            foreach ($children as $child) {
                $child['parent_id'] = $topItem->id;
                $pageId = $child['page_id'] ?? null;
                $createdChild = self::create($child);

                if ($pageId && \Illuminate\Support\Facades\Schema::hasColumn('pages', 'menu_parent_id')) {
                    Page::where('id', $pageId)->update([
                        'menu_parent_id' => $topItem->id,
                        'show_in_menu' => true,
                        'menu_order' => $createdChild->order,
                    ]);
                }
            }
        }

        $slugMap = [
            'urine' => 'urine',
            'dot' => 'dot',
            'hair' => 'hair',
            'alcohol' => 'alcohol',
            'oral' => 'oral-fluid',
            'oral-fluid' => 'oral-fluid',
            'occupational' => 'occupational',
            'occupational-health' => 'occupational',
            'clinical' => 'clinical',
            'dna' => 'dna',
            'mobile' => 'mobile',
            'locations' => 'locations',
            'employers' => 'employers',
            'employer' => 'employers',
        ];

        // Also sync any other published pages that have parent_menu explicitly specified
        $extraPages = Page::where('is_published', true)
            ->whereNotNull('parent_menu')
            ->get();

        foreach ($extraPages as $page) {
            // If already attached, skip
            if (self::where('page_id', $page->id)->exists()) {
                continue;
            }

            $raw = strtolower(trim($page->parent_menu));
            $parentKey = $slugMap[$raw] ?? $raw;

            if ($parentKey && isset($createdTopItems[$parentKey])) {
                $targetParent = $createdTopItems[$parentKey];
                $maxOrder = self::where('parent_id', $targetParent->id)->max('order') ?? 0;
                $order = $page->menu_order ?: ($maxOrder + 1);

                $item = self::create([
                    'parent_id' => $targetParent->id,
                    'page_id' => $page->id,
                    'title' => $page->menu_name ?: $page->title,
                    'url' => '/' . ltrim($page->slug, '/'),
                    'order' => $order,
                    'is_active' => true,
                ]);

                if (\Illuminate\Support\Facades\Schema::hasColumn('pages', 'menu_parent_id')) {
                    $page->update([
                        'menu_parent_id' => $targetParent->id,
                        'show_in_menu' => true,
                        'menu_order' => $item->order,
                    ]);
                }
            }
        }

        self::clearCache();
    }
}
