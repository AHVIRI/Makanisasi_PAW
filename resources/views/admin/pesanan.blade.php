@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-10 pb-4 border-b border-gray-100">
        <div>
            <h2 class="font-extrabold text-3xl text-gray-800 font-title flex items-center gap-2">
                <span class="material-icons text-amber-500 text-3xl">receipt_long</span> Daftar Pesanan Customer
            </h2>
            <p class="text-sm text-gray-500 mt-0.5">Pantau dan verifikasi pesanan makanan/minuman masuk</p>
        </div>
        <a href="{{ route('admin.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-full text-xs font-bold transition flex items-center gap-1">
            <span class="material-icons text-sm">arrow_back</span> Kembali ke Dashboard
        </a>
    </div>

    @if($pemesanans->isEmpty())
        <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm">
            <span class="material-icons text-5xl text-gray-300 mb-4">receipt</span>
            <p class="text-base font-bold text-gray-800">Belum Ada Pesanan Masuk</p>
            <p class="text-xs text-gray-400 mt-1">Belum ada transaksi pemesanan dari pelanggan.</p>
        </div>
    @else
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Produk Yang Dipesan</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Metode & Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($pemesanans as $pesanan)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-800">{{ $pesanan->user->name ?? '-' }}</div>
                                    <div class="text-xs text-gray-400 font-light mt-0.5">{{ $pesanan->user->email ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($pesanan->makanan)
                                        <div class="font-bold text-gray-800">{{ $pesanan->makanan->nama_makanan }}</div>
                                        <span class="px-2 py-0.5 bg-amber-50 text-amber-600 rounded text-[9px] font-bold uppercase mt-1 inline-block">Makanan</span>
                                    @elseif($pesanan->minuman)
                                        <div class="font-bold text-gray-800">{{ $pesanan->minuman->nama_minuman }}</div>
                                        <span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded text-[9px] font-bold uppercase mt-1 inline-block">Minuman</span>
                                    @else
                                        <span class="text-gray-400 font-light">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap text-xs text-gray-600">
                                    {{ $pesanan->tanggal_pemesanan ? \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap font-extrabold text-amber-600 font-title">
                                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap space-y-1">
                                    <div class="text-xs font-bold text-gray-700">{{ $pesanan->metode_pembayaran }}</div>
                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider inline-block
                                        @if($pesanan->status_pembayaran === 'sudah_bayar') bg-green-50 text-green-600 @else bg-yellow-50 text-yellow-600 @endif">
                                        {{ $pesanan->status_pembayaran === 'sudah_bayar' ? 'Lunas' : 'Belum Bayar' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <a href="{{ route('admin.pesanan.show', $pesanan->id) }}" class="inline-flex items-center gap-0.5 bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2 rounded-full text-xs font-bold transition">
                                        <span class="material-icons text-xs">info</span> Detail
                                    </a>
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
