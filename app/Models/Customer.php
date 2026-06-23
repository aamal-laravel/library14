<?php

namespace App\Models;
use App\Models\WaitingList;
use App\Models\Bill;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // 
    protected $fillable = [
        'gender',
        'DOB',
        'phone',
        'avatar',
        'lang',
        'user_id'
    ];
    public function user(){
            return $this->belongsTo(User::class);
    }
    public function WaitingList(): HasMany
{
    return $this->hasMany(waitingList::class);
}
public function bills(): HasMany
{
    return $this->hasMany(Bill::class);
}

}
