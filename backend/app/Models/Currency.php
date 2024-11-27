<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'title',
        'ticker',
        'decimals',
        'name'
    ];
}
