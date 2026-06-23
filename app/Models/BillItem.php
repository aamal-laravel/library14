<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BillItem extends Model
{
  protected $fillable = [
    'bill_id',
    'book_id',
    'rental_price',
    'deposit_amount',
    'fine_amount',
    'added_amount',
    'extension_count',
    'due_at',
    'status',
    'return_at',
    'customer_return_amount',
];
    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
