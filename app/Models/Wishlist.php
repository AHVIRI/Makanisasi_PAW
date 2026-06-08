<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlists';

    protected $fillable = [
        'user_id',
        'makanan_id',
        'minuman_id',
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
}
