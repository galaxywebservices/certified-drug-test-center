<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CorporateAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'account_code',
        'contact_name',
        'email',
        'phone',
        'industry',
        'billing_type',
        'credit_limit',
        'active_balance',
        'is_dot_regulated',
        'dot_agency',
        'access_pin',
        'access_token',
        'status',
        'settings',
    ];

    protected $casts = [
        'is_dot_regulated' => 'boolean',
        'credit_limit' => 'decimal:2',
        'active_balance' => 'decimal:2',
        'settings' => 'array',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getRemainingCreditAttribute(): float
    {
        return max(0.00, (float)$this->credit_limit - (float)$this->active_balance);
    }
}
