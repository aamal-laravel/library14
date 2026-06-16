<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Otp extends Model
{
    protected $fillable = [
        'user_id',
        'otp_hash',
        'expires_at',
    ];

    public $timestamps = false;
    
    protected function casts(): array
    {
        return [            
                'otp_hash' => 'hashed'
            ];
    }

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
