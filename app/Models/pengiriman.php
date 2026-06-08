<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengiriman';

    protected $fillable = [
        'pemesanan_id',
        'kurir',
        'nomor_kontak_kurir',
        'alamat_pengiriman',
        'nomor_resi',
        'tanggal_kirim',
        'status_pengiriman',
        'status_updated_at',
    ];

    protected $casts = [
        'tanggal_kirim' => 'datetime',
        'status_updated_at' => 'datetime',
    ];

    // Mendapatkan status otomatis berdasarkan timer
    public function getAutoStatus()
    {
        if (!$this->status_updated_at) {
            return $this->status_pengiriman;
        }
        $now = now();
        $start = $this->status_updated_at;

        if ($this->status_pengiriman === 'proses_memasak') {
            if ($now->diffInMinutes($start) >= 5) {
                return 'dalam_perjalanan';
            }
            return 'proses_memasak';
        } elseif ($this->status_pengiriman === 'dalam_perjalanan') {
            if ($now->diffInMinutes($start) >= 20) {
                return 'sampai';
            }
            return 'dalam_perjalanan';
        } elseif ($this->status_pengiriman === 'sampai') {
            return 'sampai';
        }
        return $this->status_pengiriman;
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }
}
