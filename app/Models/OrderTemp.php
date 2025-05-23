<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTemp extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'jumlah', 'harga_setelah_diskon'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
