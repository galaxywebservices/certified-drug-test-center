<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'donor_first_name',
        'donor_last_name',
        'donor_email',
        'donor_phone',
        'donor_dob',
        'donor_ssn_last4',
        'test_reason',
        'location_id',
        'subtotal',
        'discount',
        'total',
        'payment_status',
        'payment_gateway',
        'paytrace_transaction_id',
        'paytrace_approval_code',
        'donor_pass_token',
        'ccf_number',
        'status',
        'result_outcome',
        'specimen_collected_at',
        'mro_verified_at',
        'mro_notes',
        'notes',
    ];

    protected $casts = [
        'donor_dob' => 'date',
        'specimen_collected_at' => 'datetime',
        'mro_verified_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function getDonorFullNameAttribute(): string
    {
        return "{$this->donor_first_name} {$this->donor_last_name}";
    }
}
