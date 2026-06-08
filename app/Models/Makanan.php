<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;

    protected $table = 'makanan';

    protected $fillable = [
        'nama_makanan',
        'deskripsi',
        'kategori',
        'price',
        'image',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class, 'makanan_id');
    }

    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating') ?? 5.0, 1);
    }
}
