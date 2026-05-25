<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;


     
    
    public $fillable = ['ISBN', 'title','rental_price', 'deposit','pages','default_borrow_days', 'total_copies','stock','published_at','cover','category_id'];
}
