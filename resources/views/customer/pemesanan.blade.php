@extends('layouts.app')

@section('content')
@php
    $cartItems = $cartItems ?? collect();
    $totalHarga = $totalHarga ?? 0;
    $deliveryFee = 10000;
@endphp

<div class="max-w-6xl mx-auto py-10 px-4">
    
    <!-- Title -->
    <div class="flex flex-col items-center mb-10 text-center">
        <span class="material-icons text-amber-500 text-4xl mb-2 float-slow">shopping_cart_checkout</span>
        <h1 class="text-3xl font-extrabold text-gray-800 font-title">Checkout Pesanan</h1>
        <p class="text-sm text-gray-500 mt-1 max-w-md">Lengkapi detail pengiriman dan selesaikan transaksi Anda</p>
    </div>

    @if ($cartItems->isNotEmpty())
        <div class="grid lg:grid-cols-3 gap-8 items-start">
            
            <!-- Shipping Form (Left Side) -->
            <form action="{{ route('pemesanan.store') }}" method="POST" class="lg:col-span-2 space-y-6 bg-white rounded-3xl border border-gray-100 p-8 shadow-sm">
                @csrf
                
                <h3 class="text-lg font-bold text-gray-800 font-title flex items-center gap-2 border-b pb-4 mb-2">
                    <span class="material-icons text-amber-500">local_shipping</span> Informasi Pengiriman
                </h3>

                <!-- Delivery Address -->
                <div class="space-y-2">
                    <label for="alamat_pengiriman" class="block text-sm font-semibold text-gray-700">Alamat Pengiriman Lengkap</label>
                    <textarea name="alamat_pengiriman" id="alamat_pengiriman" rows="3" required placeholder="Tuliskan nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, dan detail petunjuk..." 
                        class="w-full p-4 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 bg-gray-50/50 text-sm transition leading-relaxed">{{ old('alamat_pengiriman') }}</textarea>
                </div>

                <div class="grid sm:grid-cols-2 gap-6">
                    <!-- Courier Selection -->
                    <div class="space-y-2">
                        <label for="kurir" class="block text-sm font-semibold text-gray-700">Pilih Jasa Pengiriman</label>
                        <div class="relative">
                            <select name="kurir" id="kurir" required 
                                class="w-full p-4 pr-10 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 bg-gray-50/50 text-sm transition appearance-none">
                                <option value="">-- Pilih Kurir --</option>
                                @foreach($kurirList as $kurir)
                                    <option value="{{ $kurir }}" {{ old('kurir') == $kurir ? 'selected' : '' }}>{{ $kurir }}</option>
                                @endforeach
                            </select>
                            <span class="material-icons absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">expand_more</span>
                        </div>
                    </div>

                    <!-- Payment Method Selection -->
                    <div class="space-y-2">
                        <label for="metode_pembayaran" class="block text-sm font-semibold text-gray-700">Metode Pembayaran</label>
                        <div class="relative">
                            <select name="metode_pembayaran" id="metode_pembayaran" required 
                                class="w-full p-4 pr-10 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 bg-gray-50/50 text-sm transition appearance-none">
                                <option value="">-- Pilih Metode --</option>
                                <option value="Transfer Bank">Transfer Bank (Virtual Account BCA)</option>
                                <option value="E-Wallet">E-Wallet (QRIS)</option>
                                <option value="COD">COD (Bayar di Tempat)</option>
                            </select>
                            <span class="material-icons absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">expand_more</span>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
                    <a href="{{ route('cartItem') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition flex items-center gap-1">
                        <span class="material-icons text-base">arrow_back</span> Kembali ke Keranjang
                    </a>
                    
                    <button type="submit" class="btn-premium px-8 py-3.5 rounded-full font-bold text-sm shadow-md hover:shadow-lg transition">
                        Konfirmasi & Lanjut
                    </button>
                </div>
            </form>

            <!-- Order Summary Sidebar (Right Side) -->
            <div class="space-y-6">
                <!-- Summary Card -->
                <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm space-y-6">
                    <h3 class="text-lg font-bold text-gray-800 font-title border-b pb-4">Ringkasan Pesanan</h3>
                    
                    <div class="max-h-[300px] overflow-y-auto pr-2 space-y-4">
                        @foreach ($cartItems as $item)
                            @php
                                $product = $item->makanan ?? $item->minuman;
                                $price = $product ? (float) $product->price : 0;
                            @endphp
                            <div class="flex justify-between items-start text-sm gap-4">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-800 line-clamp-1">
                                        {{ $product->nama_makanan ?? $product->nama_minuman ?? 'Produk tidak tersedia' }}
                                    </h4>
                                    <span class="text-xs text-gray-400">Qty: {{ $item->quantity }} x Rp {{ number_format($price, 0, ',', '.') }}</span>
                                </div>
                                <span class="font-bold text-gray-700 text-xs">
                                    Rp {{ number_format($price * $item->quantity, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <hr class="border-gray-100">

                    <div class="space-y-3.5 text-sm">
                        <div class="flex justify-between text-gray-500">
                            <span>Subtotal Menu</span>
                            <span class="font-bold text-gray-800">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-500">
                            <span>Biaya Pengantaran</span>
                            <span class="font-bold text-gray-800">Rp {{ number_format($deliveryFee, 0, ',', '.') }}</span>
                        </div>
                        
                        <hr class="border-gray-100 my-4">
                        
                        <div class="flex justify-between items-center text-base">
                            <span class="font-bold text-gray-800">Total Pembayaran</span>
                            <span class="font-extrabold text-amber-600 text-lg font-title">Rp {{ number_format($totalHarga + $deliveryFee, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Notice Banner -->
                <div class="bg-blue-50/50 border border-blue-100 rounded-3xl p-5 flex items-start gap-3">
                    <span class="material-icons text-blue-500 mt-0.5">info</span>
                    <div>
                        <h4 class="text-xs font-bold text-blue-900 mb-1">Informasi Penting</h4>
                        <p class="text-[11px] text-blue-700/80 leading-relaxed">
                            Pesanan Transfer Bank & E-Wallet memerlukan konfirmasi pembayaran setelah checkout agar makanan dapat mulai dimasak oleh dapur.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    @else
        <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm max-w-md mx-auto">
            <span class="material-icons text-6xl text-gray-300 mb-4">remove_shopping_cart</span>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Keranjang Anda Kosong</h3>
            <p class="text-xs text-gray-500 mb-6">Silakan pilih makanan atau minuman dari menu kami terlebih dahulu.</p>
            <a href="{{ route('home') }}#menu" class="btn-premium px-6 py-2.5 rounded-full font-bold text-xs shadow">Lihat Menu</a>
        </div>
    @endif
</div>
@endsection
