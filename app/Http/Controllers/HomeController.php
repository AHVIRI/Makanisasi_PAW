<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Makanan;
use App\Models\Minuman;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman home setelah login.
     */
    public function index()
    {
        // Ambil data makanan dan minuman dari model Makanan dan Minuman
        $makanan = Makanan::all();
        $minuman = Minuman::all();
        return view('home', compact('makanan', 'minuman'));
    }
}
