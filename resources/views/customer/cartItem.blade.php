@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4">
    <div class="flex items-center justify-between mb-10 pb-4 border-b border-gray-100">
        <h2 class="font-extrabold text-3xl text-gray-800 font-title flex items-center gap-2">
            <span class="material-icons text-amber-500 text-3xl">shopping_basket</span> Keranjang Belanja
        </h2>
        <span class="text-sm text-gray-500 font-medium bg-gray-100 px-3 py-1 rounded-full">
            {{ $cartItems->count() }} Tipe Menu
        </span>
    </div>

    @if($cartItems->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm max-w-2xl mx-auto">
            <div class="inline-flex items-center justify-center p-6 bg-amber-50 text-amber-600 rounded-full mb-6 float-slow">
                <span class="material-icons text-6xl">remove_shopping_cart</span>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Keranjang Anda Kosong</h3>
            <p class="text-gray-500 text-sm max-w-md mx-auto mb-8">
                Sepertinya Anda belum menambahkan makanan atau minuman ke keranjang belanja Anda. Mari jelajahi menu lezat kami!
            </p>
            <a href="{{ route('home') }}#menu" class="btn-premium px-8 py-3.5 rounded-full font-bold text-sm tracking-wide inline-block shadow">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="grid lg:grid-cols-3 gap-8 items-start">
            
            <!-- Cart Items List (Left Side) -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                    @php
                        $product = $item->makanan ?? $item->minuman;
                        $type = $item->makanan ? 'makanan' : 'minuman';
                        $price = $product ? (float) $product->price : 0;
                    @endphp
                    
                    <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition flex flex-col sm:flex-row items-center gap-5">
                        <!-- Product Thumbnail -->
                        <div class="w-24 h-24 rounded-2xl bg-gray-50 overflow-hidden flex-shrink-0">
                            @if($product && $product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nama_makanan ?? $product->nama_minuman }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <span class="material-icons text-3xl">image</span>
                                </div>
                            @endif
                        </div>

                        <!-- Product info -->
                        <div class="flex-1 text-center sm:text-left">
                            <span class="text-[10px] font-extrabold uppercase px-2.5 py-0.5 rounded-full inline-block mb-1.5
                                @if($type === 'makanan') bg-amber-50 text-amber-600 @else bg-blue-50 text-blue-600 @endif">
                                {{ ucfirst($type) }}
                            </span>
                            <h3 class="text-base font-bold text-gray-800 mb-1">
                                {{ $product->nama_makanan ?? $product->nama_minuman ?? 'Produk tidak ditemukan' }}
                            </h3>
                            <p class="text-sm font-extrabold text-amber-600">
                                Rp {{ number_format($price, 0, ',', '.') }} <span class="text-xs text-gray-400 font-normal">/ porsi</span>
                            </p>
                        </div>

                        <!-- Quantity control -->
                        <div class="flex items-center gap-2 bg-gray-50 border border-gray-100 rounded-full px-2.5 py-1">
                            <!-- Minus Button -->
                            <button onclick="decrementQty({{ $item->id }})" class="w-8 h-8 rounded-full bg-white hover:bg-gray-100 text-gray-600 font-bold transition flex items-center justify-center shadow-xs">
                                <span class="material-icons text-base">remove</span>
                            </button>
                            
                            <!-- Hidden update form -->
                            <form id="form-update-{{ $item->id }}" action="{{ route('cart.update', $item->id) }}" method="POST" class="m-0">
                                @csrf
                                @method('PUT')
                                <input type="number" id="qty-input-{{ $item->id }}" name="quantity" value="{{ $item->quantity }}" min="1" class="w-12 text-center bg-transparent border-0 font-bold text-gray-800 focus:outline-none focus:ring-0 text-sm">
                            </form>

                            <!-- Plus Button -->
                            <button onclick="incrementQty({{ $item->id }})" class="w-8 h-8 rounded-full bg-white hover:bg-gray-100 text-gray-600 font-bold transition flex items-center justify-center shadow-xs">
                                <span class="material-icons text-base">add</span>
                            </button>
                        </div>

                        <!-- Total price per item -->
                        <div class="text-center sm:text-right min-w-[100px]">
                            <span class="text-xs text-gray-400 block font-light">Subtotal</span>
                            <span class="text-base font-extrabold text-gray-800 font-title">
                                Rp {{ number_format($price * $item->quantity, 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Remove Button -->
                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus item ini?');" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-full transition-colors" title="Hapus dari keranjang">
                                <span class="material-icons text-xl leading-none">delete_outline</span>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <!-- Checkout Summary (Right Side) -->
            <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm space-y-6">
                <h3 class="text-lg font-bold text-gray-800 font-title border-b pb-4">Ringkasan Belanja</h3>
                
                @php
                    $subtotal = $cartItems->sum(function($item) {
                        $price = $item->makanan ? $item->makanan->price : ($item->minuman ? $item->minuman->price : 0);
                        return $price * $item->quantity;
                    });
                    $deliveryFee = 10000; // Simulasikan biaya pengantaran
                    $total = $subtotal + $deliveryFee;
                @endphp

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-gray-500">
                        <span>Total Harga ({{ $cartItems->sum('quantity') }} Item)</span>
                        <span class="font-bold text-gray-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-500">
                        <span>Biaya Pengantaran</span>
                        <span class="font-bold text-gray-800">Rp {{ number_format($deliveryFee, 0, ',', '.') }}</span>
                    </div>
                    
                    <hr class="border-gray-100 my-4">
                    
                    <div class="flex justify-between text-base">
                        <span class="font-bold text-gray-800">Total Belanja</span>
                        <span class="font-extrabold text-amber-600 text-lg font-title">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="pt-4 space-y-3">
                    <a href="{{ route('pemesanan.create') }}" class="btn-premium w-full py-3.5 rounded-full font-bold text-center text-sm shadow flex items-center justify-center gap-2">
                        <span class="material-icons text-sm">payment</span> Lanjut Ke Checkout
                    </a>
                    <a href="{{ route('home') }}#menu" class="bg-gray-100 hover:bg-gray-200 text-gray-700 w-full py-3 rounded-full font-bold text-center text-sm block transition">
                        Lanjut Belanja
                    </a>
                </div>
            </div>

        </div>
    @endif
</div>

<!-- Quantity adjustment helper script -->
<script>
    function incrementQty(itemId) {
        const input = document.getElementById(`qty-input-${itemId}`);
        const form = document.getElementById(`form-update-${itemId}`);
        if(input && form) {
            input.value = parseInt(input.value) + 1;
            form.submit();
        }
    }
    
    function decrementQty(itemId) {
        const input = document.getElementById(`qty-input-${itemId}`);
        const form = document.getElementById(`form-update-${itemId}`);
        if(input && form && parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            form.submit();
        }
    }
</script>
@endsection
