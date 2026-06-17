<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    //
}
<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{

protected $fillable = [
        'cart_id',
        'book_id',
        'rental_price',
        'deposit',
    ];
     public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

}
