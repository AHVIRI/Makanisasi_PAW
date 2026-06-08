@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10 px-4">
    
    <!-- Title -->
    <div class="flex flex-col items-center mb-10 text-center">
        <span class="material-icons text-amber-500 text-4xl mb-2 float-slow">local_shipping</span>
        <h1 class="text-3xl font-extrabold text-gray-800 font-title">Lacak Pengiriman</h1>
        <p class="text-sm text-gray-500 mt-1">Status real-time hidangan Anda sampai di lokasi tujuan</p>
    </div>

    @if(!$pengiriman)
        <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm">
            <span class="material-icons text-5xl text-gray-300 mb-4">info_outline</span>
            <p class="text-base font-bold text-gray-800">Belum Ada Data Pengiriman</p>
            <p class="text-xs text-gray-400 mt-1 mb-6">Data kurir dan perjalanan pesanan belum tersedia.</p>
            <a href="{{ route('pemesanan.history') }}" class="btn-premium px-6 py-2.5 rounded-full font-bold text-xs shadow">Kembali ke Riwayat</a>
        </div>
    @else
        <div class="space-y-6">
            <!-- Delivery Info Card -->
            <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm space-y-4">
                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-gray-400 block font-light">KURIR PENGIRIM</span>
                        <span class="font-bold text-gray-800 text-sm flex items-center gap-1 mt-0.5">
                            <span class="material-icons text-gray-400 text-sm">person</span> {{ $pengiriman->kurir ?? '-' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-400 block font-light">NOMOR RESI</span>
                        <span class="font-bold text-gray-800 text-sm flex items-center gap-1 mt-0.5">
                            <span class="material-icons text-gray-400 text-sm">tag</span> {{ $pengiriman->nomor_resi ?? '-' }}
                        </span>
                    </div>
                </div>

                <hr class="border-gray-50">

                <div class="text-xs">
                    <span class="text-gray-400 block font-light">ALAMAT PENGANTARAN</span>
                    <p class="font-bold text-gray-700 leading-relaxed mt-1 flex items-start gap-1.5">
                        <span class="material-icons text-amber-500 text-sm mt-0.5">location_on</span>
                        <span>{{ $pengiriman->alamat_pengiriman }}</span>
                    </p>
                </div>
            </div>

            <!-- Tracker Timeline Card -->
            <div class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm">
                <h3 class="text-sm font-bold uppercase tracking-wider text-gray-400 mb-8">Status Perjalanan</h3>
                
                @php
                    $status = $pengiriman->status_pengiriman;
                @endphp

                <!-- Vertical Timeline -->
                <div class="relative pl-8 space-y-8 before:content-[''] before:absolute before:left-3.5 before:top-2 before:bottom-2 before:w-[2px] before:bg-gray-100">
                    
                    <!-- Step 1: Menunggu Pembayaran -->
                    <div class="relative">
                        <!-- Bullet indicator -->
                        <span class="absolute -left-8 top-1.5 w-7 h-7 rounded-full flex items-center justify-center border-2 z-10 transition-colors
                            @if($status === 'menunggu_pembayaran') bg-yellow-500 border-yellow-500 text-white
                            @else bg-green-500 border-green-500 text-white @endif">
                            <span class="material-icons text-xs">payment</span>
                        </span>
                        <h4 class="text-xs font-bold @if($status === 'menunggu_pembayaran') text-yellow-600 @else text-green-600 @endif">
                            Menunggu Pembayaran
                        </h4>
                        <p class="text-[11px] text-gray-400 mt-0.5">Pesanan berhasil dibuat, menanti konfirmasi pembayaran.</p>
                    </div>

                    <!-- Step 2: Proses Memasak -->
                    <div class="relative">
                        <!-- Bullet indicator -->
                        <span class="absolute -left-8 top-1.5 w-7 h-7 rounded-full flex items-center justify-center border-2 z-10 transition-colors
                            @if($status === 'menunggu_pembayaran') bg-white border-gray-200 text-gray-400
                            @elseif($status === 'proses_memasak') bg-amber-500 border-amber-500 text-white float-slow
                            @else bg-green-500 border-green-500 text-white @endif">
                            <span class="material-icons text-xs">soup_kitchen</span>
                        </span>
                        <h4 class="text-xs font-bold 
                            @if($status === 'proses_memasak') text-amber-600
                            @elseif($status === 'dalam_perjalanan' || $status === 'sampai') text-green-600
                            @else text-gray-400 @endif">
                            Sedang Dimasak
                        </h4>
                        <p class="text-[11px] text-gray-400 mt-0.5">Chef andalan kami sedang mengolah hidangan segar pesanan Anda.</p>
                    </div>

                    <!-- Step 3: Dalam Perjalanan -->
                    <div class="relative">
                        <!-- Bullet indicator -->
                        <span class="absolute -left-8 top-1.5 w-7 h-7 rounded-full flex items-center justify-center border-2 z-10 transition-colors
                            @if($status === 'dalam_perjalanan') bg-blue-500 border-blue-500 text-white float-slow
                            @elseif($status === 'sampai') bg-green-500 border-green-500 text-white
                            @else bg-white border-gray-200 text-gray-400 @endif">
                            <span class="material-icons text-xs">delivery_dining</span>
                        </span>
                        <h4 class="text-xs font-bold 
                            @if($status === 'dalam_perjalanan') text-blue-600
                            @elseif($status === 'sampai') text-green-600
                            @else text-gray-400 @endif">
                            Dalam Perjalanan
                        </h4>
                        <p class="text-[11px] text-gray-400 mt-0.5">Kurir sedang membawa hidangan lezat Anda ke alamat pengiriman.</p>
                    </div>

                    <!-- Step 4: Sampai Tujuan -->
                    <div class="relative">
                        <!-- Bullet indicator -->
                        <span class="absolute -left-8 top-1.5 w-7 h-7 rounded-full flex items-center justify-center border-2 z-10 transition-colors
                            @if($status === 'sampai') bg-green-500 border-green-500 text-white
                            @else bg-white border-gray-200 text-gray-400 @endif">
                            <span class="material-icons text-xs">check_circle</span>
                        </span>
                        <h4 class="text-xs font-bold @if($status === 'sampai') text-green-600 @else text-gray-400 @endif">
                            Sampai Tujuan
                        </h4>
                        <p class="text-[11px] text-gray-400 mt-0.5">Pesanan telah sampai di lokasi tujuan Anda. Selamat menikmati!</p>
                    </div>

                </div>

                <div class="mt-10 pt-6 border-t border-gray-50 flex flex-col items-center justify-center gap-4">
                    @if($status != 'sampai')
                        <form method="GET" action="{{ route('pengiriman.tracking', $pengiriman->pemesanan_id) }}" class="m-0">
                            <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-full text-xs font-bold transition flex items-center gap-1">
                                <span class="material-icons text-sm">refresh</span> Perbarui Status
                            </button>
                        </form>
                    @else
                        <div class="text-center">
                            <p class="text-xs font-bold text-green-600 uppercase tracking-widest mb-3">Selamat Menikmati Hidangan Anda!</p>
                            <a href="{{ route('pemesanan.history') }}" class="btn-premium px-6 py-2.5 rounded-full font-bold text-xs shadow">Beri Rating Pesanan</a>
                        </div>
                    @endif
                </div>

            </div>
        </div>

        @if($status === 'proses_memasak' || $status === 'dalam_perjalanan')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    let status = "{{ $status }}";
                    let updatedAt = "{{ $pengiriman->status_updated_at }}";
                    let duration = status === 'proses_memasak' ? 5*60 : 20*60; // detik
                    let endTime = new Date(new Date(updatedAt).getTime() + duration * 1000);

                    function checkAutoRefresh() {
                        let now = new Date();
                        let diff = Math.max(0, Math.floor((endTime - now) / 1000));
                        if (diff <= 0) {
                            setTimeout(() => location.reload(), 1000);
                        }
                    }
                    checkAutoRefresh();
                    setInterval(checkAutoRefresh, 1000);
                });
            </script>
        @endif
    @endif
</div>
@endsection
