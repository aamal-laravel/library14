<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\WaitingList;


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
    public function billItems(): HasMany
{
    return $this->hasMany(BillItem::class);
}
public function WaitingList()
{
    return $this->hasMany(waitingList::class);
}
public function scopeAvailable($query)
{
    return $query->where('stock', '>', 0);
}
}
