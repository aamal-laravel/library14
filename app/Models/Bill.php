<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bill extends Model
{
   protected $fillable = [
    'customer_id',
    'total_amount',
    'payment_method',
    'status',
];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
{
    return $this->hasMany(BillItem::class);
}
public function payments(): HasMany
{
    return $this->hasMany(Payment::class);
}
}
