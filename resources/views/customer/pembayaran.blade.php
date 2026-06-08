@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10 px-4">
    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gradient-amber px-8 py-8 text-white text-center">
            <span class="material-icons text-5xl mb-2 float-slow">account_balance_wallet</span>
            <h2 class="text-2xl font-extrabold font-title">Portal Pembayaran Makanisasi</h2>
            <p class="text-sm text-amber-100 mt-1">Selesaikan pembayaran Anda untuk memproses pesanan</p>
        </div>

        <!-- Timer Banner -->
        <div class="bg-amber-50 py-3 px-6 text-center text-xs font-bold text-amber-800 border-b border-amber-100 flex items-center justify-center gap-1.5">
            <span class="material-icons text-base">schedule</span>
            <span>Batas waktu pembayaran: </span>
            <span id="payment-timer" class="font-mono text-sm">15:00</span>
        </div>

        <div class="p-8 space-y-6">
            
            <!-- Invoice Details -->
            <div class="space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400">Ringkasan Invoice</h3>
                <div class="bg-gray-50 rounded-2xl p-5 space-y-3.5">
                    @foreach($pemesanans as $pesanan)
                        <div class="flex justify-between text-xs text-gray-600">
                            <span>{{ $pesanan->makanan->nama_makanan ?? $pesanan->minuman->nama_minuman ?? 'Item' }}</span>
                            <span class="font-bold">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                    
                    <hr class="border-gray-200">
                    
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-bold text-gray-800">Total Tagihan</span>
                        <span class="font-extrabold text-amber-600 text-lg font-title">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment instructions -->
            <div class="space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400">Metode Pembayaran: {{ $metodePembayaran }}</h3>
                
                @if($metodePembayaran === 'Transfer Bank')
                    <!-- Virtual Account simulation -->
                    <div class="border border-gray-100 rounded-2xl p-5 space-y-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-[10px] text-gray-400 uppercase font-light">Nama Bank</span>
                                <p class="text-sm font-bold text-gray-800">Makanisasi Virtual Account (BCA)</p>
                            </div>
                            <span class="px-2.5 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-bold">BCA</span>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3 flex justify-between items-center">
                            <div>
                                <span class="text-[10px] text-gray-400 block font-light">Nomor VA</span>
                                <span id="va-number" class="text-base font-bold font-mono tracking-wider text-gray-800">8839081234567890</span>
                            </div>
                            <button onclick="copyVA()" class="text-xs text-amber-600 font-bold hover:text-amber-800 transition">Copy</button>
                        </div>
                        <ol class="list-decimal pl-4 text-xs text-gray-500 space-y-1">
                            <li>Buka aplikasi Mobile Banking atau ATM terdekat Anda.</li>
                            <li>Pilih menu <strong class="text-gray-700">Transfer</strong> &gt; <strong class="text-gray-700">Virtual Account</strong>.</li>
                            <li>Masukkan nomor VA di atas dan masukkan nominal yang sesuai.</li>
                            <li>Konfirmasi transaksi Anda.</li>
                        </ol>
                    </div>
                @else
                    <!-- E-wallet (QRIS code) simulation -->
                    <div class="border border-gray-100 rounded-2xl p-5 flex flex-col items-center space-y-4 text-center">
                        <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-[10px] font-bold uppercase tracking-wider">QRIS STANDAR NASIONAL</span>
                        
                        <!-- Simulated QR Code Box -->
                        <div class="w-48 h-48 border-4 border-gray-100 rounded-2xl bg-white p-3 flex flex-col justify-between items-center relative shadow-sm">
                            <div class="absolute inset-0 bg-cover bg-center opacity-85" style="background-image: url('https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=MakanisasiTotalPay{{$totalHarga}}');"></div>
                            <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center text-white z-10 font-bold text-[10px] shadow border border-white">M</div>
                        </div>

                        <p class="text-xs text-gray-500 max-w-xs leading-relaxed">
                            Pindai kode QRIS di atas menggunakan GoPay, OVO, Dana, LinkAja, atau aplikasi m-banking Anda untuk menyelesaikan pembayaran.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Confirmation form -->
            <form action="{{ route('pemesanan.konfirmasi') }}" method="POST" class="pt-4 border-t border-gray-100 m-0">
                @csrf
                <input type="hidden" name="ids" value="{{ $idsString }}">
                
                <button type="submit" class="btn-premium w-full py-4 rounded-full font-bold text-center text-sm shadow-lg hover:shadow-amber-500/20 flex items-center justify-center gap-2">
                    <span class="material-icons text-sm">verified_user</span> Simulasikan Pembayaran Berhasil
                </button>
                
                <a href="{{ route('home') }}" class="block text-center text-xs text-gray-400 mt-4 hover:text-gray-600 transition">
                    Batalkan & Kembali ke Menu Utama
                </a>
            </form>

        </div>
    </div>
</div>

<!-- Scripts for Timer and Copying -->
<script>
    // Copy VA number
    function copyVA() {
        const vaNum = document.getElementById('va-number').textContent;
        navigator.clipboard.writeText(vaNum).then(() => {
            alert('Nomor Virtual Account disalin ke clipboard!');
        });
    }

    // 15 Minutes Countdown Timer
    document.addEventListener('DOMContentLoaded', () => {
        let timeRemaining = 15 * 60; // 15 minutes in seconds
        const timerDisplay = document.getElementById('payment-timer');

        function updateTimer() {
            if (timeRemaining <= 0) {
                timerDisplay.textContent = "00:00";
                timerDisplay.parentElement.className = "bg-red-50 py-3 px-6 text-center text-xs font-bold text-red-800 border-b border-red-100 flex items-center justify-center gap-1.5";
                timerDisplay.previousElementSibling.textContent = "error";
                timerDisplay.previousElementSibling.nextSibling.textContent = "Waktu Pembayaran Telah Habis!";
                return;
            }

            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            
            const minutesStr = String(minutes).padStart(2, '0');
            const secondsStr = String(seconds).padStart(2, '0');
            
            timerDisplay.textContent = `${minutesStr}:${secondsStr}`;
            timeRemaining--;
        }

        updateTimer();
        setInterval(updateTimer, 1000);
    });
</script>
@endsection
