<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'subtitle',
        'sku',
        'retail_price',
        'price',
        'specimen_type',
        'dot_required',
        'turnaround_time',
        'short_description',
        'details',
        'preparation_instructions',
        'included_panels',
        'is_popular',
        'is_active',
        'position',
        'meta_title',
        'meta_description',
        'canonical_url',
        'schema_markup',
    ];

    protected $casts = [
        'retail_price' => 'decimal:2',
        'price' => 'decimal:2',
        'dot_required' => 'boolean',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'included_panels' => 'array',
        'schema_markup' => 'array',
        'position' => 'integer',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product')
            ->withPivot('position')
            ->orderByPivot('position');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get clean filter category slugs for checkout and homepage panel selection:
     * 'urine', 'dot', 'hair', 'alcohol', 'oral', 'occupational', 'clinical', 'dna'
     */
    public function getFilterCategoriesAttribute(): array
    {
        $cats = $this->categories->pluck('slug')->toArray();
        $name = strtolower($this->name);
        $filterCats = [];

        $isBg = in_array('background-checks', $cats) || str_contains($name, 'background check');
        $isOcc = in_array('occupational-health', $cats) || str_contains($name, 'physical') || str_contains($name, 'respirator') || str_contains($name, 'vision') || str_contains($name, 'osha') || str_contains($name, 'audiogram') || str_contains($name, 'lift test') || str_contains($name, 'fit-for-duty') || str_contains($name, 'tb skin');
        $isConsortium = in_array('std-testing', $cats) || in_array('dot-consortium', $cats) || str_contains($name, 'consortium') || str_contains($name, 'clearinghouse') || str_contains($name, 'compliance package') || str_contains($name, 'mvr') || str_contains($name, 'der reporting') || str_contains($name, 'policy') || str_contains($name, 'queries');
        $isHair = in_array('hair', $cats) || str_contains($name, 'hair') || $this->specimen_type === 'hair';
        $isOral = in_array('oral-fluid-testing', $cats) || str_contains($name, 'oral') || str_contains($name, 'saliva') || $this->specimen_type === 'oral' || $this->specimen_type === 'saliva';
        $isDna = in_array('dna-testing', $cats) || str_contains($name, 'dna') || str_contains($name, 'paternity');
        $isBlood = in_array('lab-blood', $cats) || in_array('labblood-testing', $cats) || str_contains($name, 'blood') || str_contains($name, 'std') || str_contains($name, 'hiv') || str_contains($name, 'herpes') || str_contains($name, 'syphilis') || str_contains($name, 'chlamydia') || str_contains($name, 'peth');
        $isAlcohol = in_array('alcohol', $cats) || str_contains($name, 'alcohol') || str_contains($name, 'etg') || str_contains($name, 'breath');

        $hasNonDot = str_contains($name, 'non-dot') || str_contains($name, 'nondot');
        $isDot = !$hasNonDot && (in_array('dot', $cats) || $this->dot_required || str_contains($name, 'dot') || str_contains($name, 'fmcsa') || str_contains($name, 'uscg') || str_contains($name, 'faa') || str_contains($name, 'clearinghouse') || str_contains($name, 'return to duty'));

        if ($isBg || $isOcc) {
            $filterCats[] = 'occupational';
        }

        if ($isHair) {
            $filterCats[] = 'hair';
        }

        if ($isOral) {
            $filterCats[] = 'oral';
        }

        if ($isDna) {
            $filterCats[] = 'dna';
        }

        if ($isBlood) {
            $filterCats[] = 'clinical';
        }

        if ($isAlcohol) {
            $filterCats[] = 'alcohol';
        }

        if ($isDot) {
            $filterCats[] = 'dot';
        }

        // Urine Drug Tests:
        // Must NOT be a pure background check, pure occupational health exam/physical/vision/respirator, pure consortium, hair, oral, DNA, or blood/clinical test.
        if (!$isBg && !$isOcc && !$isConsortium && !$isHair && !$isOral && !$isDna && !$isBlood) {
            if (in_array('urine', $cats) || str_contains($name, 'urine') || str_contains($name, 'panel') || str_contains($name, 'nursing') || str_contains($name, 'sports') || str_contains($name, 'observed') || $this->specimen_type === 'urine') {
                $filterCats[] = 'urine';
            }
        }

        return array_values(array_unique($filterCats));
    }
}
