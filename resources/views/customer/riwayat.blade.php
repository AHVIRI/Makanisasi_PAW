@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4">
    <div class="flex items-center justify-between mb-10 pb-4 border-b border-gray-100">
        <h2 class="font-extrabold text-3xl text-gray-800 font-title flex items-center gap-2">
            <span class="material-icons text-amber-500 text-3xl font-normal">receipt_long</span> Riwayat Pesanan Saya
        </h2>
        <span class="text-sm text-gray-500 font-medium bg-gray-100 px-3 py-1 rounded-full">
            Total {{ $pemesanans->count() }} Pesanan
        </span>
    </div>

    @if($pemesanans->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm max-w-2xl mx-auto">
            <div class="inline-flex items-center justify-center p-6 bg-amber-50 text-amber-600 rounded-full mb-6">
                <span class="material-icons text-6xl">receipt</span>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Riwayat Pesanan</h3>
            <p class="text-gray-500 text-sm max-w-md mx-auto mb-8">
                Anda belum pernah memesan makanan atau minuman dari Makanisasi. Mari pesan hidangan favorit Anda sekarang!
            </p>
            <a href="{{ route('home') }}#menu" class="btn-premium px-8 py-3.5 rounded-full font-bold text-sm tracking-wide inline-block shadow">
                Pesan Sekarang
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($pemesanans as $pesanan)
                @php
                    $product = $pesanan->makanan ?? $pesanan->minuman;
                    $type = $pesanan->makanan ? 'makanan' : 'minuman';
                    $statusPengiriman = $pesanan->pengiriman?->status_pengiriman ?? 'menunggu_pembayaran';
                @endphp
                
                <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition">
                    <!-- Top Info Row -->
                    <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-50 pb-4 mb-4 text-xs">
                        <div class="flex items-center gap-4 text-gray-500">
                            <div>
                                <span class="block font-light text-[10px] uppercase">Tanggal Pemesanan</span>
                                <span class="font-bold text-gray-700">{{ $pesanan->tanggal_pemesanan ? \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d M Y') : '-' }}</span>
                            </div>
                            <div class="border-l pl-4 border-gray-200">
                                <span class="block font-light text-[10px] uppercase">Metode Pembayaran</span>
                                <span class="font-bold text-gray-700">{{ $pesanan->metode_pembayaran }}</span>
                            </div>
                        </div>

                        <!-- Status Badges -->
                        <div class="flex items-center gap-2">
                            <!-- Payment Status Badge -->
                            <span class="px-3 py-1 rounded-full font-bold text-[10px] uppercase tracking-wider
                                @if($pesanan->status_pembayaran === 'sudah_bayar') bg-green-50 text-green-600 @else bg-yellow-50 text-yellow-600 @endif">
                                {{ $pesanan->status_pembayaran === 'sudah_bayar' ? 'Lunas (Paid)' : 'Belum Bayar (Unpaid)' }}
                            </span>

                            <!-- Shipping Status Badge -->
                            <span class="px-3 py-1 rounded-full font-bold text-[10px] uppercase tracking-wider
                                @if($statusPengiriman === 'sampai') bg-green-100 text-green-800
                                @elseif($statusPengiriman === 'dalam_perjalanan') bg-yellow-100 text-yellow-800
                                @elseif($statusPengiriman === 'proses_memasak') bg-blue-100 text-blue-800
                                @elseif($statusPengiriman === 'menunggu_pembayaran') bg-gray-100 text-gray-600
                                @else bg-red-100 text-red-800 @endif">
                                @if($statusPengiriman === 'proses_memasak') Proses Memasak
                                @elseif($statusPengiriman === 'dalam_perjalanan') Dalam Perjalanan
                                @elseif($statusPengiriman === 'sampai') Selesai (Sampai)
                                @elseif($statusPengiriman === 'menunggu_pembayaran') Menunggu Pembayaran
                                @else Gagal / Batal @endif
                            </span>
                        </div>
                    </div>

                    <!-- Item Detail & Actions Row -->
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <!-- Thumbnail -->
                            <div class="w-16 h-16 rounded-2xl bg-gray-50 overflow-hidden flex-shrink-0">
                                @if($product && $product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nama_makanan ?? $product->nama_minuman }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <span class="material-icons">image</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Name & Price info -->
                            <div>
                                <span class="text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-full inline-block mb-1
                                    @if($type === 'makanan') bg-amber-50 text-amber-600 @else bg-blue-50 text-blue-600 @endif">
                                    {{ ucfirst($type) }}
                                </span>
                                <h4 class="text-base font-bold text-gray-800 leading-tight">
                                    {{ $product->nama_makanan ?? $product->nama_minuman ?? 'Produk tidak tersedia' }}
                                </h4>
                                <span class="text-sm font-extrabold text-amber-600 block mt-1 font-title">
                                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-2 w-full md:w-auto justify-end">
                            
                            <!-- Unpaid check out redirect -->
                            @if($pesanan->status_pembayaran === 'belum_bayar' && $pesanan->metode_pembayaran !== 'COD')
                                <a href="{{ route('pemesanan.pembayaran', ['ids' => $pesanan->id]) }}" class="btn-premium px-5 py-2.5 rounded-full text-xs font-bold shadow flex items-center gap-1">
                                    <span class="material-icons text-sm">payment</span> Bayar Sekarang
                                </a>
                            @endif

                            <!-- Tracking Info Button -->
                            @if($statusPengiriman === 'proses_memasak' || $statusPengiriman === 'dalam_perjalanan' || $statusPengiriman === 'sampai')
                                <a href="{{ route('pengiriman.tracking', $pesanan->id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-full text-xs font-bold transition flex items-center gap-1">
                                    <span class="material-icons text-sm">local_shipping</span> Lacak Pengiriman
                                </a>
                            @endif

                            <!-- Write Review Button -->
                            @if($statusPengiriman === 'sampai')
                                @if($pesanan->review)
                                    <!-- Reviewed State -->
                                    <div class="px-4 py-2 border border-gray-100 bg-gray-50 rounded-full text-xs text-gray-500 font-semibold flex items-center gap-1.5">
                                        <span class="material-icons text-yellow-500 text-sm">star</span>
                                        <span>Ulasan diberikan ({{ $pesanan->review->rating }}★)</span>
                                    </div>
                                @else
                                    <!-- Give Review trigger button -->
                                    <button onclick="openReviewModal({{ $pesanan->id }}, '{{ $product->nama_makanan ?? $product->nama_minuman }}')" class="bg-amber-100 hover:bg-amber-200 text-amber-700 px-5 py-2.5 rounded-full text-xs font-bold transition flex items-center gap-1">
                                        <span class="material-icons text-sm">rate_review</span> Beri Ulasan
                                    </button>
                                @endif
                            @endif

                            <!-- Cancellation button -->
                            @if($statusPengiriman === 'menunggu_pembayaran' || $statusPengiriman === 'proses_memasak')
                                <form action="{{ route('pemesanan.batalkan', $pesanan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');" class="m-0">
                                    @csrf
                                    <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-500 px-5 py-2.5 rounded-full text-xs font-bold transition">
                                        Batalkan Pesanan
                                    </button>
                                </form>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Review Modal Backdrop & Form -->
<div id="review-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden justify-center items-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl overflow-hidden transform scale-95 transition-all duration-300">
        
        <div class="bg-amber-500 px-6 py-5 text-white flex justify-between items-center">
            <h3 class="font-extrabold text-lg font-title flex items-center gap-1">
                <span class="material-icons">rate_review</span> Tulis Ulasan Menu
            </h3>
            <button onclick="closeReviewModal()" class="text-white hover:opacity-75">
                <span class="material-icons">close</span>
            </button>
        </div>

        <form id="review-form" method="POST" action="" class="p-6 space-y-5 m-0">
            @csrf
            
            <div>
                <span class="text-xs text-gray-400 block mb-1">Menu yang Dipesan</span>
                <p id="modal-product-name" class="font-bold text-gray-800 text-sm">Product Name</p>
            </div>

            <!-- Star Selection -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Rating Bintang</label>
                <div class="flex items-center gap-1.5" id="star-selector">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" onclick="setRating({{ $i }})" class="text-gray-300 hover:text-yellow-400 transition" data-star="{{ $i }}">
                            <span class="material-icons text-3xl">star</span>
                        </button>
                    @endfor
                </div>
                <!-- Hidden input for rating -->
                <input type="hidden" name="rating" id="rating-value" value="5" required>
            </div>

            <!-- Review text -->
            <div class="space-y-2">
                <label for="ulasan" class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Tulis Ulasan Anda</label>
                <textarea name="ulasan" id="ulasan" rows="4" placeholder="Bagikan pendapat Anda tentang rasa, kebersihan, porsi, dan pengantaran makanan ini..." 
                    class="w-full p-4 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm bg-gray-50/50 transition leading-relaxed"></textarea>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="closeReviewModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-2.5 rounded-full text-xs font-bold transition">Batal</button>
                <button type="submit" class="btn-premium px-6 py-2.5 rounded-full text-xs font-bold shadow-md hover:shadow-lg transition">Kirim Ulasan</button>
            </div>
        </form>

    </div>
</div>

<!-- Modal Control Logic -->
<script>
    const modal = document.getElementById('review-modal');
    const form = document.getElementById('review-form');
    const productNameDisp = document.getElementById('modal-product-name');
    const ratingInput = document.getElementById('rating-value');
    
    function openReviewModal(orderId, productName) {
        if (modal && form && productNameDisp) {
            // Set action URL dynamically
            form.action = `/pemesanan/${orderId}/review`;
            productNameDisp.textContent = productName;
            
            // Reset rating to 5 stars
            setRating(5);
            document.getElementById('ulasan').value = '';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Animate scale up
            setTimeout(() => {
                modal.firstElementChild.classList.remove('scale-95');
                modal.firstElementChild.classList.add('scale-100');
            }, 10);
        }
    }

    function closeReviewModal() {
        if (modal) {
            modal.firstElementChild.classList.remove('scale-100');
            modal.firstElementChild.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }
    }

    function setRating(val) {
        if(ratingInput) {
            ratingInput.value = val;
            
            // Highlight stars up to selected value
            const stars = document.querySelectorAll('#star-selector button');
            stars.forEach((star, index) => {
                const icon = star.firstElementChild;
                if (index < val) {
                    icon.classList.remove('text-gray-300');
                    icon.classList.add('text-yellow-400');
                } else {
                    icon.classList.remove('text-yellow-400');
                    icon.classList.add('text-gray-300');
                }
            });
        }
    }

    // Close on clicking outside modal content
    if(modal) {
        modal.addEventListener('click', (e) => {
            if(e.target === modal) {
                closeReviewModal();
            }
        });
    }
</script>

@endsection
