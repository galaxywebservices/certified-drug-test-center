<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PseoCityContent extends Model
{
    use HasFactory;

    protected $table = 'pseo_city_contents';

    protected $fillable = [
        'city_id',
        'county',
        'population',
        'gpt_5panel',
        'gpt_10panel',
        'gpt_dot',
        'gpt_hair',
        'gpt_alcohol',
        'gpt_services',
        'gpt_consortium',
        'gpt_physical',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
