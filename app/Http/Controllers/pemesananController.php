<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\CartItem;
use App\Models\Makanan;
use App\Models\Minuman;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    // Menampilkan halaman checkout dengan isi cart
    public function create()
    {
        $cartItems = CartItem::with(['makanan', 'minuman'])
            ->where('user_id', Auth::id())
            ->get();

        $totalHarga = $cartItems->sum(function($item) {
            $price = $item->makanan ? $item->makanan->price : ($item->minuman ? $item->minuman->price : 0);
            return $price * $item->quantity;
        });

        // Daftar kurir (bisa diambil dari DB jika dinamis)
        $kurirList = ['GoFood', 'ShoopeFood', 'GrabFood'];

        return view('customer.pemesanan', [
            'cartItems' => $cartItems,
            'totalHarga' => $totalHarga,
            'kurirList' => $kurirList,
        ]);
    }

    // Menyimpan pesanan dari cart
    public function store(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required|string',
            'metode_pembayaran' => 'required|string',
            'kurir' => 'required|string',
        ]);

        $cartItems = CartItem::with(['makanan', 'minuman'])
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Keranjang kosong.');
        }

        $pemesananIds = [];

        foreach ($cartItems as $item) {
            $isCOD = ($request->metode_pembayaran === 'COD');

            $pemesanan = Pemesanan::create([
                'user_id' => Auth::id(),
                'makanan_id' => $item->makanan?->id,
                'minuman_id' => $item->minuman?->id,
                'tanggal_pemesanan' => now(),
                'total_harga' => ($item->makanan ? $item->makanan->price : $item->minuman->price) * $item->quantity,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => $isCOD ? 'sudah_bayar' : 'belum_bayar',
            ]);

            $pemesananIds[] = $pemesanan->id;

            // Generate nomor resi 8 digit acak
            $nomorResi = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);

            // Buat data pengiriman otomatis
            Pengiriman::create([
                'pemesanan_id' => $pemesanan->id,
                'kurir' => $request->kurir,
                'nomor_kontak_kurir' => null,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'nomor_resi' => $nomorResi,
                'tanggal_kirim' => now(),
                'status_pengiriman' => $isCOD ? 'proses_memasak' : 'menunggu_pembayaran',
                'status_updated_at' => now(),
            ]);
        }

        // Kosongkan cart setelah checkout
        CartItem::where('user_id', Auth::id())->delete();

        if ($request->metode_pembayaran === 'COD') {
            return redirect()->route('home')->with('success', 'Pesanan berhasil dibuat! Makanan Anda sedang diproses oleh dapur.');
        }

        return redirect()->route('pemesanan.pembayaran', ['ids' => implode(',', $pemesananIds)]);
    }

    // Tampilkan halaman pembayaran simulator
    public function pembayaranPage(Request $request)
    {
        $idsString = $request->query('ids');
        if (!$idsString) {
            return redirect()->route('home')->with('error', 'Pesanan tidak ditemukan.');
        }

        $ids = explode(',', $idsString);
        $pemesanans = Pemesanan::with(['makanan', 'minuman'])
            ->whereIn('id', $ids)
            ->where('user_id', Auth::id())
            ->get();

        if ($pemesanans->isEmpty()) {
            return redirect()->route('home')->with('error', 'Pesanan tidak ditemukan.');
        }

        $totalHarga = $pemesanans->sum('total_harga');
        $metodePembayaran = $pemesanans->first()->metode_pembayaran;

        return view('customer.pembayaran', [
            'pemesanans' => $pemesanans,
            'totalHarga' => $totalHarga,
            'metodePembayaran' => $metodePembayaran,
            'idsString' => $idsString,
        ]);
    }

    // Konfirmasi Pembayaran
    public function konfirmasiPembayaran(Request $request)
    {
        $idsString = $request->input('ids');
        if (!$idsString) {
            return redirect()->route('home')->with('error', 'Pesanan tidak ditemukan.');
        }

        $ids = explode(',', $idsString);
        
        // Update status pembayaran
        Pemesanan::whereIn('id', $ids)
            ->where('user_id', Auth::id())
            ->update(['status_pembayaran' => 'sudah_bayar']);

        // Update status pengiriman
        Pengiriman::whereIn('pemesanan_id', $ids)
            ->update([
                'status_pengiriman' => 'proses_memasak',
                'status_updated_at' => now(),
            ]);

        return redirect()->route('home')->with('success', 'Pembayaran berhasil dikonfirmasi! Pesanan Anda sedang diproses oleh dapur.');
    }

    // Menampilkan daftar pesanan
    public function index()
    {
        $pemesanans = Pemesanan::with(['user', 'makanan', 'minuman'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.pemesanan', compact('pemesanans'));
    }

    // Menampilkan detail pesanan
    public function show(Pemesanan $pemesanan)
    {
        if ($pemesanan->user_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.pemesanan_detail', compact('pemesanan'));
    }

    // Batalkan pesanan
    public function destroy(Pemesanan $pemesanan)
    {
        if ($pemesanan->user_id !== Auth::id()) {
            abort(403);
        }

        $pemesanan->delete();

        return redirect()->route('pemesanan.batalkan')->with('success', 'Pesanan berhasil dibatalkan.');
    }

    // Riwayat pesanan untuk customer
    public function history()
    {
        $pemesanans = Pemesanan::with(['makanan', 'minuman', 'pengiriman', 'review'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.riwayat', compact('pemesanans'));
    }

    // ADMIN: Melihat semua pesanan customer
    public function adminIndex()
    {
        $pemesanans = \App\Models\Pemesanan::with(['user', 'makanan', 'minuman'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.pesanan', compact('pemesanans'));
    }

    // ADMIN: Melihat detail pesanan customer
    public function adminShow($id)
    {
        $pemesanan = \App\Models\Pemesanan::with(['user', 'makanan', 'minuman'])->findOrFail($id);
        return view('admin.pesanan_detail', compact('pemesanan'));
    }
}
