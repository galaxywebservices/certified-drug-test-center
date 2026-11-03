<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetiredRoute extends Model
{
    use HasFactory;

    protected $table = 'retired_routes';

    protected $fillable = [
        'legacy_url',
        'action',
        'target_url',
    ];
}
