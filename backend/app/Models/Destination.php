<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'ticker',
        'title',
        'network',
        'deposit_enabled',
        'withdrawal_enabled',
        'deposit_fee',
        'withdrawal_fee',
        'withdrawal_min',
        'withdrawal_max',
        'memo',
        'decimals',
        'explorer_address_link',
        'explorer_tx_link'
    ];
}
