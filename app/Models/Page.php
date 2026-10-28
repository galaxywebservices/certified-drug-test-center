<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'page_heading',
        'template',
        'featured_image',
        'content',
        'blocks_json',
        'is_published',
        'show_in_menu',
        'menu_name',
        'menu_order',
        'meta_title',
        'meta_description',
        'canonical_url',
        'robots_index',
        'robots_follow',
        'schema_json',
    ];

    protected $casts = [
        'blocks_json' => 'array',
        'schema_json' => 'array',
        'is_published' => 'boolean',
        'show_in_menu' => 'boolean',
        'robots_index' => 'boolean',
        'robots_follow' => 'boolean',
        'menu_order' => 'integer',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
