<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Makanan;
use App\Models\Minuman;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with(['makanan', 'minuman'])
            ->where('user_id', Auth::id())
            ->get();
        return view('customer.wishlist', compact('wishlists'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'product_type' => 'required|in:makanan,minuman',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'makanan_id' => $request->product_type === 'makanan' ? $request->product_id : null,
            'minuman_id' => $request->product_type === 'minuman' ? $request->product_id : null,
        ];

        Wishlist::firstOrCreate($data);

        return back()->with('success', 'Ditambahkan ke wishlist!');
    }

    public function remove($id)
    {
        $item = Wishlist::where('user_id', Auth::id())->findOrFail($id);
        $item->delete();
        return back()->with('success', 'Dihapus dari wishlist!');
    }

    // Fitur admin: lihat semua wishlist user
    public function adminIndex()
    {
        $wishlists = Wishlist::with(['user', 'makanan', 'minuman'])->orderBy('created_at', 'desc')->get();
        return view('admin.wishlist', compact('wishlists'));
    }
}
