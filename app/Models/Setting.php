<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'name',
        'value',
    ];

    public static function getValue(string $name, $default = null)//used in service 
    {
        return static::where('name', $name)->value('value') ?? $default;
    }
}