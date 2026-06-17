<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class waitingList extends Model
{

protected $fillable = [
        'customer_id',
        'book_id',
    ];

    public function customer(): BelongsTo
{
    return $this->belongsTo(Customer::class);
}

public function book(): BelongsTo
{
    return $this->belongsTo(Book::class);
}

}
