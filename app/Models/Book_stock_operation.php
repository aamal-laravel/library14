<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class book_stock_operation extends Model
{
   protected $table = "book_stock_operation";
    protected $fillable = ["quantity", "type", "remove_from_remaining", "book_id"];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
