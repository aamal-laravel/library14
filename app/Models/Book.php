<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;


     public $guarded = ['authors'];
    
    // public $fillable = ['ISBN', 'title','rental_price', 'deposit','pages','default_borrow_days', 'total_copies','stock','published_at','cover','category_id'];

    function category() : BelongsTo{
        return $this->belongsTo(Category::class );
    }
    function authors():BelongsToMany{
        return $this->belongsToMany(Author::class);
    }

     public function removeStock():HasMany
    {
       return $this->hasMany(book_stock_operation::class, "book_id");
    }
}
