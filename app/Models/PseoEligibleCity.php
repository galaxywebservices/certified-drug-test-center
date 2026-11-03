<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PseoEligibleCity extends Model
{
    use HasFactory;

    protected $table = 'pseo_eligible_cities';

    protected $fillable = [
        'city_id',
        'state_id',
        'active_centers_count',
        'nearest_distance',
        'is_eligible',
    ];

    protected $casts = [
        'is_eligible' => 'boolean',
        'active_centers_count' => 'integer',
        'nearest_distance' => 'decimal:2',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
