<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class BookRequest extends Model
{
    protected $fillable = [
        'customer_id',
        'book_title',
        'author_name',
        'status',
        'admin_notes',
    ];
    public function customer(): BelongsTo
{
    
    return $this->belongsTo(Customer::class);
}
}
