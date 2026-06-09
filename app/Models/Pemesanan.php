<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';

    protected $fillable = [
        'user_id',
        'makanan_id',
        'minuman_id',
        'tanggal_pemesanan',
        'total_harga',
        'alamat_pengiriman',
        'metode_pembayaran',
        'status_pembayaran',
    ];

    protected $casts = [
        'tanggal_pemesanan' => 'date',
        'total_harga' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function makanan()
    {
        return $this->belongsTo(Makanan::class);
    }

    // Relasi ke Minuman (jika ada)
    public function minuman()
    {
        return $this->belongsTo(Minuman::class);
    }

    // Relasi ke Pengiriman (satu pesanan memiliki satu data pengiriman)
    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'pemesanan_id');
    }

    // Relasi ke Review (satu pesanan memiliki satu review)
    public function review()
    {
        return $this->hasOne(Review::class, 'pemesanan_id');
    }
}
