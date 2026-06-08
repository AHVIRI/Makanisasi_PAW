@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">
    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-gray-800 to-gray-950 px-8 py-6 text-white flex justify-between items-center">
            <div>
                <h2 class="text-xl font-extrabold font-title">Detail Invoice Pesanan</h2>
                <p class="text-[10px] text-gray-400 mt-0.5">ID Transaksi: #MKS-{{ str_pad($pemesanan->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
            <span class="material-icons text-3xl opacity-50">receipt</span>
        </div>

        <div class="p-8 space-y-6">
            
            <!-- Customer Section -->
            <div class="space-y-2">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 flex items-center gap-1">
                    <span class="material-icons text-sm">person</span> Pelanggan
                </h3>
                <div class="bg-gray-50 rounded-2xl p-4">
                    <p class="font-bold text-gray-800 text-sm">{{ $pemesanan->user->name ?? '-' }}</p>
                    <p class="text-xs text-gray-500 font-light mt-0.5">{{ $pemesanan->user->email ?? '-' }}</p>
                </div>
            </div>

            <!-- Product Section -->
            <div class="space-y-2">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 flex items-center gap-1">
                    <span class="material-icons text-sm">restaurant_menu</span> Menu Hidangan
                </h3>
                <div class="bg-gray-50 rounded-2xl p-4 flex justify-between items-center">
                    <div>
                        @if($pemesanan->makanan)
                            <p class="font-bold text-gray-800 text-sm">{{ $pemesanan->makanan->nama_makanan }}</p>
                            <span class="px-2 py-0.5 bg-amber-50 text-amber-600 rounded text-[9px] font-bold uppercase mt-1 inline-block">Makanan</span>
                        @elseif($pemesanan->minuman)
                            <p class="font-bold text-gray-800 text-sm">{{ $pemesanan->minuman->nama_minuman }}</p>
                            <span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded text-[9px] font-bold uppercase mt-1 inline-block">Minuman</span>
                        @else
                            <p class="text-gray-400 font-light text-sm">Menu tidak ditemukan</p>
                        @endif
                    </div>
                    <span class="font-extrabold text-amber-600 text-sm font-title">
                        Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <!-- Details List -->
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-2xl p-4">
                    <span class="text-[10px] text-gray-400 uppercase font-light">Tanggal Pesan</span>
                    <p class="text-xs font-bold text-gray-800 mt-1">
                        {{ $pemesanan->tanggal_pemesanan ? \Carbon\Carbon::parse($pemesanan->tanggal_pemesanan)->format('d M Y H:i') : '-' }}
                    </p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-4">
                    <span class="text-[10px] text-gray-400 uppercase font-light">Metode & Status Bayar</span>
                    <p class="text-xs font-bold text-gray-800 mt-1 flex items-center gap-1.5">
                        <span>{{ $pemesanan->metode_pembayaran }}</span>
                        <span class="px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider
                            @if($pemesanan->status_pembayaran === 'sudah_bayar') bg-green-100 text-green-700 @else bg-yellow-100 text-yellow-700 @endif">
                            {{ $pemesanan->status_pembayaran === 'sudah_bayar' ? 'Lunas' : 'Belum Lunas' }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="space-y-2">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 flex items-center gap-1">
                    <span class="material-icons text-sm">location_on</span> Alamat Pengiriman
                </h3>
                <div class="bg-gray-50 rounded-2xl p-4">
                    <p class="text-xs text-gray-700 leading-relaxed">{{ $pemesanan->alamat_pengiriman }}</p>
                </div>
            </div>

            <!-- Footer Action Button -->
            <div class="pt-6 border-t border-gray-100 flex justify-end">
                <a href="{{ route('admin.pesanan') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-full text-xs font-bold transition flex items-center gap-1">
                    <span class="material-icons text-sm">arrow_back</span> Kembali Ke Daftar
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
