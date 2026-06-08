@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10 px-4">
    
    <!-- Title -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10 pb-4 border-b border-gray-100">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800 font-title">Dashboard Admin</h1>
            <p class="text-sm text-gray-500 mt-0.5">Kelola menu makanan, minuman, pesanan, dan pengiriman pelanggan</p>
        </div>
        
        <!-- Navigation Buttons Toolbars -->
        <div class="flex flex-wrap gap-2.5">
            <a href="{{ route('admin.makanancreate') }}" class="btn-premium px-5 py-2.5 rounded-full text-xs font-bold shadow flex items-center gap-1">
                <span class="material-icons text-sm">add</span> Tambah Makanan
            </a>
            <a href="{{ route('admin.minumancreate') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-full text-xs font-bold shadow transition flex items-center gap-1">
                <span class="material-icons text-sm">add</span> Tambah Minuman
            </a>
            <a href="{{ route('admin.pesanan') }}" class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2.5 rounded-full text-xs font-bold shadow transition flex items-center gap-1">
                <span class="material-icons text-sm">receipt_long</span> Pesanan Customer
            </a>
            <a href="{{ route('admin.pengiriman') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-full text-xs font-bold shadow transition flex items-center gap-1">
                <span class="material-icons text-sm">local_shipping</span> Pengiriman
            </a>
            <a href="{{ route('admin.wishlist') }}" class="bg-pink-600 hover:bg-pink-700 text-white px-5 py-2.5 rounded-full text-xs font-bold shadow transition flex items-center gap-1">
                <span class="material-icons text-sm">favorite</span> Wishlist User
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Revenue Card -->
        <div class="bg-gradient-green rounded-3xl p-6 text-white shadow-lg flex items-center justify-between">
            <div>
                <span class="text-xs text-green-100 uppercase tracking-wider block font-light">Total Pendapatan</span>
                <span class="text-2xl font-extrabold font-title mt-1 block">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
            </div>
            <div class="bg-white/10 p-3.5 rounded-2xl">
                <span class="material-icons text-3xl">payments</span>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="bg-gradient-blue rounded-3xl p-6 text-white shadow-lg flex items-center justify-between">
            <div>
                <span class="text-xs text-blue-100 uppercase tracking-wider block font-light">Total Pesanan</span>
                <span class="text-2xl font-extrabold font-title mt-1 block">{{ $totalOrders }} Pesanan</span>
            </div>
            <div class="bg-white/10 p-3.5 rounded-2xl">
                <span class="material-icons text-3xl">shopping_cart</span>
            </div>
        </div>

        <!-- Customers Card -->
        <div class="bg-gradient-amber rounded-3xl p-6 text-white shadow-lg flex items-center justify-between">
            <div>
                <span class="text-xs text-amber-100 uppercase tracking-wider block font-light">Total Pelanggan</span>
                <span class="text-2xl font-extrabold font-title mt-1 block">{{ $totalCustomers }} Akun</span>
            </div>
            <div class="bg-white/10 p-3.5 rounded-2xl">
                <span class="material-icons text-3xl">people</span>
            </div>
        </div>

        <!-- Wishlists Card -->
        <div class="bg-gradient-pink rounded-3xl p-6 text-white shadow-lg flex items-center justify-between">
            <div>
                <span class="text-xs text-pink-100 uppercase tracking-wider block font-light">Total Favorit</span>
                <span class="text-2xl font-extrabold font-title mt-1 block">{{ $totalWishlists }} Item</span>
            </div>
            <div class="bg-white/10 p-3.5 rounded-2xl">
                <span class="material-icons text-3xl">favorite</span>
            </div>
        </div>
    </div>

    <!-- Makanan Grid Section -->
    <div class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800 font-title flex items-center gap-2">
                <span class="w-2.5 h-6 bg-amber-500 rounded"></span> Daftar Makanan
            </h2>
            <span class="text-xs font-semibold text-gray-400 bg-gray-100 px-3 py-1 rounded-full">{{ $makanan->count() }} Item</span>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse ($makanan as $item)
                <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-lg transition flex flex-col">
                    <!-- Image -->
                    <div class="relative overflow-hidden h-36 bg-gray-50">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->nama_makanan }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <span class="material-icons text-3xl">image</span>
                            </div>
                        @endif
                    </div>

                    <!-- Details -->
                    <div class="p-5 flex flex-col flex-grow">
                        <!-- Category Eyebrow -->
                        <span class="text-[9px] font-extrabold text-amber-600 uppercase tracking-widest block mb-1">
                            {{ $item->kategori }}
                        </span>
                        
                        <h3 class="text-sm font-bold text-gray-800 mb-1 line-clamp-1 font-title">{{ $item->nama_makanan }}</h3>
                        <p class="text-xs font-bold text-amber-600 mb-4 font-title">
                            Rp {{ number_format((float) $item->price, 0, ',', '.') }}
                        </p>
                        
                        <!-- Control Actions -->
                        <div class="mt-auto pt-3 border-t border-gray-50 flex items-center justify-between">
                            <a href="{{ route('admin.makananedit', $item) }}" class="text-xs font-bold text-blue-500 hover:text-blue-700 transition flex items-center gap-0.5">
                                <span class="material-icons text-xs">edit</span> Edit
                            </a>
                            <form action="{{ route('admin.makanandestroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus makanan ini?');" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-700 transition flex items-center gap-0.5">
                                    <span class="material-icons text-xs">delete</span> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-10 text-center text-gray-400 bg-white rounded-3xl border border-dashed border-gray-200">
                    <span class="material-icons text-4xl mb-2">flatware</span>
                    <p class="text-sm">Belum ada makanan yang ditambahkan.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Minuman Grid Section -->
    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800 font-title flex items-center gap-2">
                <span class="w-2.5 h-6 bg-blue-500 rounded"></span> Daftar Minuman
            </h2>
            <span class="text-xs font-semibold text-gray-400 bg-gray-100 px-3 py-1 rounded-full">{{ $minuman->count() }} Item</span>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse ($minuman as $item)
                <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-lg transition flex flex-col">
                    <!-- Image -->
                    <div class="relative overflow-hidden h-36 bg-gray-50">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->nama_minuman }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <span class="material-icons text-3xl">image</span>
                            </div>
                        @endif
                    </div>

                    <!-- Details -->
                    <div class="p-5 flex flex-col flex-grow">
                        <!-- Category Eyebrow -->
                        <span class="text-[9px] font-extrabold text-blue-600 uppercase tracking-widest block mb-1">
                            {{ $item->kategori }}
                        </span>
                        
                        <h3 class="text-sm font-bold text-gray-800 mb-1 line-clamp-1 font-title">{{ $item->nama_minuman }}</h3>
                        <p class="text-xs font-bold text-blue-600 mb-4 font-title">
                            Rp {{ number_format((float) $item->price, 0, ',', '.') }}
                        </p>
                        
                        <!-- Control Actions -->
                        <div class="mt-auto pt-3 border-t border-gray-50 flex items-center justify-between">
                            <a href="{{ route('admin.minumanedit', $item) }}" class="text-xs font-bold text-blue-500 hover:text-blue-700 transition flex items-center gap-0.5">
                                <span class="material-icons text-xs">edit</span> Edit
                            </a>
                            <form action="{{ route('admin.minumandestroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus minuman ini?');" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-700 transition flex items-center gap-0.5">
                                    <span class="material-icons text-xs">delete</span> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-10 text-center text-gray-400 bg-white rounded-3xl border border-dashed border-gray-200">
                    <span class="material-icons text-4xl mb-2">local_cafe</span>
                    <p class="text-sm">Belum ada minuman yang ditambahkan.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
