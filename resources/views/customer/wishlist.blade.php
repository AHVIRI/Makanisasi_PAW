@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4">
    <div class="flex items-center justify-between mb-10 pb-4 border-b border-gray-100">
        <h2 class="font-extrabold text-3xl text-gray-800 font-title flex items-center gap-2">
            <span class="material-icons text-amber-500 text-3xl">favorite</span> Wishlist Saya
        </h2>
        <span class="text-sm text-gray-500 font-medium bg-gray-100 px-3 py-1 rounded-full">
            {{ $wishlists->count() }} Menu Favorit
        </span>
    </div>

    @if($wishlists->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm max-w-2xl mx-auto">
            <div class="inline-flex items-center justify-center p-6 bg-pink-50 text-pink-500 rounded-full mb-6 float-slow">
                <span class="material-icons text-6xl">favorite_border</span>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Wishlist Anda Kosong</h3>
            <p class="text-gray-500 text-sm max-w-md mx-auto mb-8">
                Tandai hidangan makanan atau minuman favorit Anda agar dapat memesannya kembali dengan mudah kapan saja.
            </p>
            <a href="{{ route('home') }}#menu" class="btn-premium px-8 py-3.5 rounded-full font-bold text-sm tracking-wide inline-block shadow">
                Jelajahi Menu
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($wishlists as $item)
                @php
                    $product = $item->makanan ?? $item->minuman;
                    $type = $item->makanan ? 'makanan' : 'minuman';
                    $price = $product ? (float) $product->price : 0;
                @endphp
                
                @if($product)
                    <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transform hover:-translate-y-1.5 transition duration-300 flex flex-col">
                        
                        <!-- Thumbnail -->
                        <div class="relative overflow-hidden h-48 bg-gray-50">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nama_makanan ?? $product->nama_minuman }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <span class="material-icons text-4xl">image</span>
                                </div>
                            @endif
                            <span class="absolute top-4 left-4 font-extrabold text-[10px] uppercase tracking-wider px-3 py-1 rounded-full shadow
                                @if($type === 'makanan') bg-amber-500 text-black @else bg-blue-500 text-white @endif">
                                {{ ucfirst($type) }}
                            </span>
                        </div>

                        <!-- Info -->
                        <div class="p-6 flex flex-col flex-1">
                            <!-- rating -->
                            <div class="flex items-center gap-1.5 mb-2">
                                <span class="material-icons text-yellow-500 text-sm">star</span>
                                <span class="text-xs font-bold text-gray-800">{{ $product->average_rating }}</span>
                                <span class="text-xs text-gray-400">({{ $product->reviews->count() }} ulasan)</span>
                            </div>

                            <h3 class="text-base font-bold text-gray-900 mb-1.5 line-clamp-1 font-title">
                                {{ $product->nama_makanan ?? $product->nama_minuman }}
                            </h3>
                            
                            <p class="text-xs text-gray-400 line-clamp-2 mb-4 leading-relaxed">
                                {{ $product->deskripsi }}
                            </p>

                            <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-gray-400 block font-light uppercase tracking-wider">Harga</span>
                                    <span class="text-base font-extrabold font-title @if($type === 'makanan') text-amber-600 @else text-blue-600 @endif">
                                        Rp {{ number_format($price, 0, ',', '.') }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center gap-1">
                                    <!-- Remove Button -->
                                    <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="m-0" onsubmit="return confirm('Hapus dari wishlist?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-full border border-red-100 hover:border-red-500 text-red-500 hover:bg-red-50 transition-all" title="Hapus dari Wishlist">
                                            <span class="material-icons text-lg leading-none">favorite</span>
                                        </button>
                                    </form>

                                    <!-- Add to Cart Button -->
                                    <form action="{{ route('cart.store') }}" method="POST" class="m-0">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="product_type" value="{{ $type }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="p-2 rounded-full text-white transition shadow-sm hover:shadow-md flex items-center justify-center
                                            @if($type === 'makanan') bg-amber-500 hover:bg-amber-600 @else bg-blue-500 hover:bg-blue-600 @endif" title="Masukkan Keranjang">
                                            <span class="material-icons text-lg leading-none">add_shopping_cart</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection
