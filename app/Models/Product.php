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
}
