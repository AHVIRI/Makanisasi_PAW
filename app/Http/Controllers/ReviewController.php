<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $pemesananId)
    {
        $pemesanan = Pemesanan::findOrFail($pemesananId);

        // Pastikan order milik user yang login
        if ($pemesanan->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string|max:1000',
        ]);

        // Cek apakah sudah pernah direview
        $existingReview = Review::where('pemesanan_id', $pemesanan->id)->first();
        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'makanan_id' => $pemesanan->makanan_id,
            'minuman_id' => $pemesanan->minuman_id,
            'pemesanan_id' => $pemesanan->id,
            'rating' => $request->rating,
            'ulasan' => $request->ulasan,
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
