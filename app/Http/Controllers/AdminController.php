<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use App\Models\Minuman;

use App\Models\Pemesanan;
use App\Models\User;
use App\Models\Wishlist;

class AdminController extends Controller
{
    public function index()
    {
        $makanan = Makanan::all();
        $minuman = Minuman::all();

        // Calculate statistics
        $totalOrders = Pemesanan::count();
        $totalRevenue = Pemesanan::sum('total_harga');
        $totalCustomers = User::where('role', 'Customer')->count();
        $totalWishlists = Wishlist::count();

        return view('admin.index', compact(
            'makanan', 
            'minuman', 
            'totalOrders', 
            'totalRevenue', 
            'totalCustomers', 
            'totalWishlists'
        ));
    }
}
