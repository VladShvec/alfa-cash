<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pair extends Model
{
    protected $fillable = [
        'source_name',
        'destination_name',
        'source_min',
        'source_max',
        'destination_min',
        'destination_max',
        'rate',
        'source_name',
        'destination_name'
    ];
}
