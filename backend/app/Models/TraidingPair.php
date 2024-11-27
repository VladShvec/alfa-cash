<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TraidingPair extends Model
{
    protected $fillable = [
        'base',
        'quote',
        'last'
    ];
}
