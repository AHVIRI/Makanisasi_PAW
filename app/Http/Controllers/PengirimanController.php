<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    public function index()
    {
        $pengiriman = Pengiriman::with('pemesanan')->get();
        return view('customer.pengiriman',  compact('pemesanan'));
    }

    // Tracking pengiriman untuk customer
    public function tracking($pemesananId)
    {
        $pengiriman = \App\Models\Pengiriman::with('pemesanan')->where('pemesanan_id', $pemesananId)->first();

        // Update status otomatis jika perlu
        if ($pengiriman) {
            $autoStatus = $pengiriman->getAutoStatus();
            if ($autoStatus !== $pengiriman->status_pengiriman) {
                $pengiriman->status_pengiriman = $autoStatus;
                $pengiriman->status_updated_at = now();
                $pengiriman->save();
            }
        }

        return view('customer.tracking', compact('pengiriman'));
    }

    // Saat admin membuat pengiriman, set status awal ke proses_memasak
    public function store(Request $request)
    {
        $request->validate([
            'pemesanan_id' => 'required|exists:pemesanan,id',
            'kurir' => 'required|string|max:255',
            'nomor_kontak_kurir' => 'nullable|string|max:255',
            'alamat_pengiriman' => 'required|string|max:255',
            'nomor_resi' => 'nullable|string|max:255|unique:pengiriman,nomor_resi',
            'tanggal_kirim' => 'nullable|date',
            // status_pengiriman tidak perlu diinput user, set otomatis
        ]);

        $pengiriman = Pengiriman::create([
            'pemesanan_id' => $request->pemesanan_id,
            'kurir' => $request->kurir,
            'nomor_kontak_kurir' => $request->nomor_kontak_kurir,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'nomor_resi' => $request->nomor_resi,
            'tanggal_kirim' => $request->tanggal_kirim,
            'status_pengiriman' => 'proses_memasak',
            'status_updated_at' => now(),
        ]);

        return redirect()->route('customer.pengiriman')->with('success', 'Pengiriman berhasil dibuat.');
    }

    // Manajemen pengiriman untuk admin
    public function adminIndex()
    {
        $pengiriman = \App\Models\Pengiriman::with('pemesanan')->orderBy('created_at', 'desc')->get();
        return view('admin.pengiriman', compact('pengiriman'));
    }

    // Update status pengiriman (admin)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pengiriman' => 'required|in:proses_memasak,dalam_perjalanan,sampai,gagal',
        ]);
        $pengiriman = \App\Models\Pengiriman::findOrFail($id);
        $pengiriman->status_pengiriman = $request->status_pengiriman;
        $pengiriman->status_updated_at = now();
        $pengiriman->save();

        return redirect()->route('admin.pengiriman')->with('success', 'Status pengiriman diperbarui.');
    }
}
