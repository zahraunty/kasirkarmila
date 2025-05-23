<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'final_price', 'stock', 'diskon'];
    protected $table = 'items';
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function orderTemps()
    {
        return $this->hasMany(OrderTemp::class);
    }
}
