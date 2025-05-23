<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_code',
        'item_name',
        'quantity',
        'total_price',
        'transaction_date',
    ];

    public $timestamps = true;
}
