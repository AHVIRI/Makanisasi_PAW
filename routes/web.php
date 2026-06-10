<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\MakananController;
use App\Http\Controllers\MinumanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\WishlistController;

// Rute publik: login, register
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Route home untuk semua user (boleh juga hanya untuk yang sudah login)
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:Customer'])->group(function() {
    Route::get('/cart', [CartItemController::class, 'index'])->name('cartItem');
    Route::post('/cart/store', [CartItemController::class, 'store'])->name('cart.store');
    Route::put('/cart/update/{id}', [CartItemController::class, 'update'])->name('cart.update');
    Route::delete('/cart/destroy/{id}', [CartItemController::class, 'destroy'])->name('cart.destroy');

   // Tampilkan halaman checkout
    Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pemesanan.index');

    Route::get('/pemesanan', [PemesananController::class, 'create'])->name('pemesanan.create');
    
    // Simpan pemesanan dari cart
    Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');
    
    // Pembayaran Simulator
    Route::get('/pemesanan/pembayaran', [PemesananController::class, 'pembayaranPage'])->name('pemesanan.pembayaran');
    Route::post('/pemesanan/pembayaran/konfirmasi', [PemesananController::class, 'konfirmasiPembayaran'])->name('pemesanan.konfirmasi');
    
    // Batalkan pemesanan
    Route::post('/pemesanan/{pemesanan}/batal', [PemesananController::class, 'destroy'])->name('pemesanan.batalkan');

    // Riwayat pesanan
    Route::get('/riwayat', [PemesananController::class, 'history'])->name('pemesanan.history');
    // Tracking pengiriman
    Route::get('/tracking/{pemesanan}', [PengirimanController::class, 'tracking'])->name('pengiriman.tracking');
    // Ulasan / Review
    Route::post('/pemesanan/{id}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    // ✅ Makanan
    Route::get('/makanan/create', [MakananController::class, 'create'])->name('admin.makanancreate');
    Route::post('/makanan', [MakananController::class, 'store'])->name('admin.makananstore');
    Route::get('/makanan/{makanan}/edit', [MakananController::class, 'edit'])->name('admin.makananedit');
    Route::put('/makanan/{makanan}', [MakananController::class, 'update'])->name('admin.makananupdate');
    Route::delete('/makanan/{makanan}', [MakananController::class, 'destroy'])->name('admin.makanandestroy');

    // ✅ Minuman
    Route::get('/minuman/create', [MinumanController::class, 'create'])->name('admin.minumancreate');
    Route::post('/minuman', [MinumanController::class, 'store'])->name('admin.minumanstore');
    Route::get('/minuman/{minuman}/edit', [MinumanController::class, 'edit'])->name('admin.minumanedit');
    Route::put('/minuman/{minuman}', [MinumanController::class, 'update'])->name('admin.minumanupdate');
    Route::delete('/minuman/{minuman}', [MinumanController::class, 'destroy'])->name('admin.minumandestroy');

    // Manajemen pengiriman
    Route::get('/pengiriman', [PengirimanController::class, 'adminIndex'])->name('admin.pengiriman');
    Route::post('/pengiriman/update/{pengiriman}', [PengirimanController::class, 'updateStatus'])->name('admin.pengiriman.update');
    // Wishlist monitoring
    Route::get('/wishlist', [WishlistController::class, 'adminIndex'])->name('admin.wishlist');
    // Melihat semua pesanan customer
    Route::get('/pesanan', [PemesananController::class, 'adminIndex'])->name('admin.pesanan');
    Route::get('/pesanan/{pemesanan}', [PemesananController::class, 'adminShow'])->name('admin.pesanan.show');
});
