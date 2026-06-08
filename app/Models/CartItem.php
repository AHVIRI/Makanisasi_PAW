<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';

    protected $fillable = [
        'user_id',
        'makanan_id',
        'minuman_id',
        'quantity',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Makanan (jika ada)
    public function makanan()
    {
        return $this->belongsTo(Makanan::class);
    }

    // Relasi ke Minuman (jika ada)
    public function minuman()
    {
        return $this->belongsTo(Minuman::class);
    }
}
