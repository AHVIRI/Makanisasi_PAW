@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-10 pb-4 border-b border-gray-100">
        <div>
            <h2 class="font-extrabold text-3xl text-gray-800 font-title flex items-center gap-2">
                <span class="material-icons text-amber-500 text-3xl">local_shipping</span> Manajemen Pengiriman
            </h2>
            <p class="text-sm text-gray-500 mt-0.5">Kelola kurir, nomor resi, dan status pengantaran pesanan</p>
        </div>
        <a href="{{ route('admin.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-full text-xs font-bold transition flex items-center gap-1">
            <span class="material-icons text-sm">arrow_back</span> Kembali ke Dashboard
        </a>
    </div>

    @if($pengiriman->isEmpty())
        <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm">
            <span class="material-icons text-5xl text-gray-300 mb-4">local_shipping</span>
            <p class="text-base font-bold text-gray-800">Belum Ada Data Pengiriman</p>
            <p class="text-xs text-gray-400 mt-1">Data kurir dan perjalanan pesanan belum tersedia.</p>
        </div>
    @else
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pesanan & Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kurir</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Nomor Resi</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status Pengiriman</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Kirim</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($pengiriman as $item)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800">
                                        {{ $item->pemesanan->makanan->nama_makanan ?? $item->pemesanan->minuman->nama_minuman ?? '-' }}
                                    </div>
                                    <div class="text-xs text-gray-400 font-light mt-0.5">
                                        Pelanggan: <span class="font-semibold text-gray-600">{{ $item->pemesanan->user->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-bold text-gray-700 flex items-center gap-1">
                                        <span class="material-icons text-gray-400 text-sm">person</span> {{ $item->kurir ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <span class="font-mono text-xs font-bold text-gray-600 bg-gray-50 border px-2.5 py-1 rounded-lg">
                                        {{ $item->nomor_resi ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <form action="{{ route('admin.pengiriman.update', $item->id) }}" method="POST" class="flex items-center gap-2 justify-center m-0">
                                        @csrf
                                        <div class="relative">
                                            <select name="status_pengiriman" class="pl-3 pr-8 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 text-xs bg-gray-50/50 font-semibold text-gray-700 appearance-none">
                                                <option value="menunggu_pembayaran" @if($item->status_pengiriman=='menunggu_pembayaran') selected @endif>Menunggu Pembayaran</option>
                                                <option value="proses_memasak" @if($item->status_pengiriman=='proses_memasak') selected @endif>Proses Memasak</option>
                                                <option value="dalam_perjalanan" @if($item->status_pengiriman=='dalam_perjalanan') selected @endif>Dalam Perjalanan</option>
                                                <option value="sampai" @if($item->status_pengiriman=='sampai') selected @endif>Sampai (Selesai)</option>
                                                <option value="gagal" @if($item->status_pengiriman=='gagal') selected @endif>Gagal</option>
                                            </select>
                                            <span class="material-icons absolute right-2.5 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm pointer-events-none">expand_more</span>
                                        </div>
                                        <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-2 rounded-xl text-xs font-bold transition flex items-center justify-center">
                                            Update
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap text-xs text-gray-500">
                                    {{ $item->tanggal_kirim ? $item->tanggal_kirim->format('d M Y') : '-' }}
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
