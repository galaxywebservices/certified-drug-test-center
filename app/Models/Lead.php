<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'service_type',
        'message',
        'status',
        'ip_address',
    ];

    public static function serviceTypes(): array
    {
        return [
            'drug-testing' => 'Drug & Alcohol Testing',
            'background-checks' => 'Background Screening & MVR',
            'dot-compliance' => 'DOT Consortium & FMCSA Compliance',
            'mobile-testing' => 'On-Site / Mobile Collection',
            'general' => 'General Inquiry / Corporate Account',
        ];
    }
}
