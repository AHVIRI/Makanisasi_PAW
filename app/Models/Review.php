<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'makanan_id',
        'minuman_id',
        'pemesanan_id', // Review linked to a specific order
        'rating',
        'ulasan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function makanan()
    {
        return $this->belongsTo(Makanan::class);
    }

    public function minuman()
    {
        return $this->belongsTo(Minuman::class);
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }
}
