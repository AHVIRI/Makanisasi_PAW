@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-10 pb-4 border-b border-gray-100">
        <div>
            <h2 class="font-extrabold text-3xl text-gray-800 font-title flex items-center gap-2">
                <span class="material-icons text-amber-500 text-3xl">favorite</span> Data Wishlist Pengguna
            </h2>
            <p class="text-sm text-gray-500 mt-0.5">Analisis tren menu makanan dan minuman terpopuler bagi pelanggan</p>
        </div>
        <a href="{{ route('admin.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-full text-xs font-bold transition flex items-center gap-1">
            <span class="material-icons text-sm">arrow_back</span> Kembali ke Dashboard
        </a>
    </div>

    @if($wishlists->isEmpty())
        <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm">
            <span class="material-icons text-5xl text-gray-300 mb-4">favorite_border</span>
            <p class="text-base font-bold text-gray-800">Belum Ada Wishlist</p>
            <p class="text-xs text-gray-400 mt-1">Pelanggan belum memasukkan menu apa pun ke daftar favorit.</p>
        </div>
    @else
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">User / Pelanggan</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Produk Favorit</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tipe Produk</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Ditambahkan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($wishlists as $item)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-800">{{ $item->user->name ?? '-' }}</div>
                                    <div class="text-xs text-gray-400 font-light mt-0.5">{{ $item->user->email ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-800">
                                        {{ $item->makanan->nama_makanan ?? $item->minuman->nama_minuman ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                        @if($item->makanan) bg-amber-50 text-amber-600 @else bg-blue-50 text-blue-600 @endif">
                                        {{ $item->makanan ? 'Makanan' : ($item->minuman ? 'Minuman' : '-') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap text-xs text-gray-500">
                                    {{ $item->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
