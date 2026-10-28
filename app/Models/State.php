<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'abbr',
        'name',
        'slug',
        'is_active',
        'content',
        'statute_code',
        'medical_marijuana_status',
        'recreational_marijuana_status',
        'employer_rights_summary',
        'worker_comp_rules',
        'faqs_json',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'faqs_json' => 'array',
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
