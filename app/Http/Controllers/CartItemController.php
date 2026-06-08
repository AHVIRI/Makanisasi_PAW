<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with(['makanan', 'minuman'])->where('user_id', Auth::id())->get();
        return view('customer.cartItem', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'product_type' => 'required|in:makanan,minuman',
            'quantity' => 'required|integer|min:1',
        ]);

        $query = CartItem::where('user_id', auth()->id());

        if ($request->product_type === 'makanan') {
            $query->where('makanan_id', $request->product_id);
        } else {
            $query->where('minuman_id', $request->product_id);
        }

        $existingItem = $query->first();

        if ($existingItem) {
            $existingItem->quantity += $request->quantity;
            $existingItem->save();
        } else {
            $cartItem = new CartItem();
            $cartItem->user_id = auth()->id();
            $cartItem->quantity = $request->quantity;

            if ($request->product_type === 'makanan') {
                $cartItem->makanan_id = $request->product_id;
            } else {
                $cartItem->minuman_id = $request->product_id;
            }

            $cartItem->save();
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $item = CartItem::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item->update([
            'quantity' => $request->input('quantity'),
        ]);

        return redirect()->route('cartItem')->with('success', 'Item berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = CartItem::where('user_id', Auth::id())->findOrFail($id);
        $item->delete();

        return redirect()->route('cartItem')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
