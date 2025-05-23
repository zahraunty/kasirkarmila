<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'item_id',
        'quantity',
        'final_price',
        'total_price',
        'status',

    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            $order->status = 'pending';

            $item = Item::find($order->item_id);
            if ($item) {
                $order->total_price = $item->final_price * $order->quantity;
                $order->final_price = $order->total_price;
            }
        });
    }
}
