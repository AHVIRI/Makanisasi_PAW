@extends('layouts.app')

@section('content')

<!-- Hero Section with Slideshow -->
<section class="relative rounded-3xl overflow-hidden shadow-2xl h-[85vh] min-h-[500px] mb-16 group">
    <!-- Slideshow Backgrounds -->
    <div id="hero-slideshow" class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 opacity-100 transform scale-100 group-hover:scale-105" style="background-image: url('/slide_1.jpg');"></div>
        <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 opacity-0 transform scale-100 group-hover:scale-105" style="background-image: url('/slide_2.jpg');"></div>
        <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 opacity-0 transform scale-100 group-hover:scale-105" style="background-image: url('/slide_3.jpg');"></div>
    </div>
    
    <!-- Dark Gradient Overlay -->
    <div class="absolute inset-0 bg-black/55 bg-gradient-to-r from-black/85 via-black/50 to-black/20 z-10"></div>
    
    <!-- Hero Content -->
    <div class="relative z-20 flex flex-col justify-center h-full max-w-2xl text-white pl-12 md:pl-24 pr-8 py-12 md:py-20">
        <span class="bg-amber-500 text-black px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-widest w-max mb-4 shadow">
            Cita Rasa Nusantara & Internasional
        </span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold mb-4 font-title leading-tight drop-shadow-md">
            Nikmati Kelezatan Kuliner Premium
        </h1>
        <p class="text-base md:text-lg mb-6 font-light text-gray-200 max-w-md drop-shadow-md">
            Pesan hidangan terlezat buatan chef ahli kami langsung ke pintu rumah Anda dengan pengiriman super cepat.
        </p>
        <div class="flex flex-wrap gap-4">
            <a href="#menu" class="btn-premium px-8 py-3.5 rounded-full font-bold text-center text-sm tracking-wide shadow-lg hover:shadow-yellow-500/25 transition">
                Jelajahi Menu Kami
            </a>
            <a href="#about" class="bg-black/30 hover:bg-black/50 backdrop-blur-md text-white border border-white/30 hover:border-white/60 px-8 py-3.5 rounded-full font-bold text-center text-sm transition shadow-sm">
                Tentang Kami
            </a>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-16 bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12 mb-16">
    <div class="grid md:grid-cols-2 gap-12 items-center">
        <div class="space-y-6">
            <div class="w-12 h-1 bg-amber-500 rounded"></div>
            <h2 class="text-3xl md:text-4xl font-extrabold font-title text-gray-800 leading-tight">
                Makanisasi: Solusi Cepat Lapar Anda
            </h2>
            <p class="text-gray-600 leading-relaxed text-justify">
                Makanisasi hadir sebagai platform e-commerce pemesanan kuliner modern dengan kualitas premium. Kami bekerja sama dengan restoran pilihan dan chef terbaik untuk menghidangkan masakan higienis yang diolah dengan bahan-bahan organik dan segar pilihan.
            </p>
            <p class="text-gray-600 leading-relaxed text-justify">
                Dengan sistem pengantaran terintegrasi, pesanan Anda akan tetap hangat dan segar sampai di meja makan Anda. Kenyamanan, kebersihan, dan cita rasa adalah janji kami kepada Anda.
            </p>
            
            <div class="grid grid-cols-3 gap-6 pt-4">
                <div class="text-center p-3 bg-amber-50 rounded-2xl">
                    <span class="block text-2xl font-bold text-amber-600">5★</span>
                    <span class="text-xs text-gray-500">Bintang Lima</span>
                </div>
                <div class="text-center p-3 bg-amber-50 rounded-2xl">
                    <span class="block text-2xl font-bold text-amber-600">100%</span>
                    <span class="text-xs text-gray-500">Bahan Higienis</span>
                </div>
                <div class="text-center p-3 bg-amber-50 rounded-2xl">
                    <span class="block text-2xl font-bold text-amber-600">&lt;30m</span>
                    <span class="text-xs text-gray-500">Pengiriman</span>
                </div>
            </div>
        </div>
        <div class="relative flex justify-center items-center">
            <div class="absolute -inset-4 bg-amber-400/20 rounded-3xl blur-xl"></div>
            <img src="/slide_2.jpg" alt="Tentang Makanisasi" class="relative z-10 w-full max-h-96 object-cover rounded-2xl shadow-xl transform rotate-1 hover:rotate-0 transition duration-500">
        </div>
    </div>
</section>

<!-- Menu & E-Commerce Section -->
<section id="menu" class="py-10 mb-16">
    <div class="text-center max-w-xl mx-auto mb-10">
        <h2 class="text-3xl md:text-4xl font-extrabold font-title text-gray-800 mb-3">Menu Istimewa Kami</h2>
        <p class="text-gray-500 text-sm">Pilih menu favorit Anda dan klik beli untuk memasukkan ke keranjang.</p>
    </div>

    <!-- Search & Filter Controls -->
    <div class="mb-10 max-w-4xl mx-auto">
        <div class="flex flex-col md:flex-row gap-4 justify-between items-center mb-6">
            <!-- Search Bar -->
            <div class="relative w-full md:max-w-md">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                    <span class="material-icons">search</span>
                </span>
                <input type="text" id="menu-search" placeholder="Cari nama makanan atau minuman..." class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 bg-white transition shadow-sm text-sm">
            </div>

            <!-- Main Type Switcher (All / Food / Drinks) -->
            <div class="flex bg-gray-100 p-1.5 rounded-2xl w-full md:w-auto overflow-x-auto">
                <button onclick="filterType('semua')" id="btn-type-semua" class="tab-type-btn bg-white text-gray-800 px-5 py-2 rounded-xl text-xs font-bold shadow-sm transition whitespace-nowrap">Semua</button>
                <button onclick="filterType('makanan')" id="btn-type-makanan" class="tab-type-btn text-gray-600 hover:text-gray-800 px-5 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap">Makanan</button>
                <button onclick="filterType('minuman')" id="btn-type-minuman" class="tab-type-btn text-gray-600 hover:text-gray-800 px-5 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap">Minuman</button>
            </div>
        </div>

        <!-- Sub Category Pills -->
        <div class="flex flex-wrap gap-2 justify-center" id="category-pills">
            <button onclick="filterCategory('semua')" class="cat-pill-btn px-4 py-1.5 rounded-full text-xs font-semibold active-amber-pill transition">Semua Kategori</button>
            <!-- Makanan categories -->
            <button onclick="filterCategory('Makanan Utama')" class="cat-pill-btn makanan-cat px-4 py-1.5 rounded-full text-xs font-semibold bg-white text-gray-600 border border-gray-100 hover:bg-gray-50 transition">Makanan Utama</button>
            <button onclick="filterCategory('Camilan')" class="cat-pill-btn makanan-cat px-4 py-1.5 rounded-full text-xs font-semibold bg-white text-gray-600 border border-gray-100 hover:bg-gray-50 transition">Camilan</button>
            <!-- Minuman categories -->
            <button onclick="filterCategory('Dingin')" class="cat-pill-btn minuman-cat px-4 py-1.5 rounded-full text-xs font-semibold bg-white text-gray-600 border border-gray-100 hover:bg-gray-50 transition">Dingin</button>
            <button onclick="filterCategory('Kopi')" class="cat-pill-btn minuman-cat px-4 py-1.5 rounded-full text-xs font-semibold bg-white text-gray-600 border border-gray-100 hover:bg-gray-50 transition">Kopi</button>
            <button onclick="filterCategory('Hangat')" class="cat-pill-btn minuman-cat px-4 py-1.5 rounded-full text-xs font-semibold bg-white text-gray-600 border border-gray-100 hover:bg-gray-50 transition">Hangat</button>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="menu-container">
        
        <!-- Foreach Makanan -->
        @foreach ($makanan as $item)
            <div class="product-card makanan-card bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transform hover:-translate-y-1.5 transition duration-300 flex flex-col" data-name="{{ strtolower($item->nama_makanan) }}" data-category="{{ $item->kategori }}" data-desc="{{ strtolower($item->deskripsi) }}">
                
                <!-- Product Image -->
                <div class="relative overflow-hidden h-48 bg-gray-50">
                    <img src="{{ $item->image }}" alt="{{ $item->nama_makanan }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    <span class="absolute top-4 left-4 bg-amber-500 text-white font-extrabold text-[10px] uppercase tracking-wider px-3 py-1 rounded-full shadow">
                        Makanan
                    </span>
                </div>

                <!-- Product Detail -->
                <div class="p-6 flex flex-col flex-1">
                    <!-- Category Eyebrow -->
                    <span class="text-[9px] font-extrabold text-amber-600 uppercase tracking-widest block mb-1">
                        {{ $item->kategori }}
                    </span>

                    <h3 class="text-base font-bold text-gray-900 mb-1 line-clamp-1 font-title">
                        {{ $item->nama_makanan }}
                    </h3>

                    <!-- Rating and Reviews -->
                    <div class="flex items-center gap-1 mb-3">
                        <span class="material-icons text-yellow-500 text-sm">star</span>
                        <span class="text-xs font-bold text-gray-800">{{ $item->average_rating }}</span>
                        <span class="text-xs text-gray-400">({{ $item->reviews->count() }} ulasan)</span>
                    </div>
                    
                    <p class="text-xs text-gray-400 line-clamp-2 mb-4 leading-relaxed">
                        {{ $item->deskripsi }}
                    </p>

                    <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-gray-400 block font-light uppercase tracking-wider">Harga</span>
                            <span class="text-base font-extrabold text-amber-600 font-title">
                                Rp {{ number_format((float) $item->price, 0, ',', '.') }}
                            </span>
                        </div>
                        
                        <!-- E-commerce Action buttons -->
                        <div class="flex items-center gap-1">
                            @auth
                                @if(Auth::user()->role === 'Customer')
                                    <!-- Wishlist Button -->
                                    <form action="{{ route('wishlist.add') }}" method="POST" class="m-0">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->id }}">
                                        <input type="hidden" name="product_type" value="makanan">
                                        <button type="submit" class="p-2 rounded-full border border-pink-100 hover:border-pink-500 text-pink-500 hover:bg-pink-50 transition-all" title="Tambah ke Wishlist">
                                            <span class="material-icons text-lg leading-none">favorite_border</span>
                                        </button>
                                    </form>
                                @endif
                            @endauth

                            <form action="{{ route('cart.store') }}" method="POST" class="m-0">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                                <input type="hidden" name="product_type" value="makanan">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="p-2 bg-amber-500 hover:bg-amber-600 text-white rounded-full transition shadow-sm hover:shadow-md flex items-center justify-center" title="Beli Sekarang">
                                    <span class="material-icons text-lg leading-none">add_shopping_cart</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Foreach Minuman -->
        @foreach ($minuman as $item)
            <div class="product-card minuman-card bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transform hover:-translate-y-1.5 transition duration-300 flex flex-col" data-name="{{ strtolower($item->nama_minuman) }}" data-category="{{ $item->kategori }}" data-desc="{{ strtolower($item->deskripsi) }}">
                
                <!-- Product Image -->
                <div class="relative overflow-hidden h-48 bg-gray-50">
                    <img src="{{ $item->image }}" alt="{{ $item->nama_minuman }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    <span class="absolute top-4 left-4 bg-blue-500 text-white font-extrabold text-[10px] uppercase tracking-wider px-3 py-1 rounded-full shadow">
                        Minuman
                    </span>
                </div>

                <!-- Product Detail -->
                <div class="p-6 flex flex-col flex-1">
                    <!-- Category Eyebrow -->
                    <span class="text-[9px] font-extrabold text-blue-600 uppercase tracking-widest block mb-1">
                        {{ $item->kategori }}
                    </span>

                    <h3 class="text-base font-bold text-gray-900 mb-1 line-clamp-1 font-title">
                        {{ $item->nama_minuman }}
                    </h3>

                    <!-- Rating and Reviews -->
                    <div class="flex items-center gap-1 mb-3">
                        <span class="material-icons text-yellow-500 text-sm">star</span>
                        <span class="text-xs font-bold text-gray-800">{{ $item->average_rating }}</span>
                        <span class="text-xs text-gray-400">({{ $item->reviews->count() }} ulasan)</span>
                    </div>
                    
                    <p class="text-xs text-gray-400 line-clamp-2 mb-4 leading-relaxed">
                        {{ $item->deskripsi }}
                    </p>

                    <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-gray-400 block font-light uppercase tracking-wider">Harga</span>
                            <span class="text-base font-extrabold text-blue-600 font-title">
                                Rp {{ number_format((float) $item->price, 0, ',', '.') }}
                            </span>
                        </div>
                        
                        <!-- E-commerce Action buttons -->
                        <div class="flex items-center gap-1">
                            @auth
                                @if(Auth::user()->role === 'Customer')
                                    <!-- Wishlist Button -->
                                    <form action="{{ route('wishlist.add') }}" method="POST" class="m-0">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->id }}">
                                        <input type="hidden" name="product_type" value="minuman">
                                        <button type="submit" class="p-2 rounded-full border border-pink-100 hover:border-pink-500 text-pink-500 hover:bg-pink-50 transition-all" title="Tambah ke Wishlist">
                                            <span class="material-icons text-lg leading-none">favorite_border</span>
                                        </button>
                                    </form>
                                @endif
                            @endauth

                            <form action="{{ route('cart.store') }}" method="POST" class="m-0">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                                <input type="hidden" name="product_type" value="minuman">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-full transition shadow-sm hover:shadow-md flex items-center justify-center" title="Beli Sekarang">
                                    <span class="material-icons text-lg leading-none">add_shopping_cart</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Empty State -->
        <div id="menu-empty" class="col-span-full py-16 text-center text-gray-400 hidden">
            <span class="material-icons text-6xl text-gray-300 mb-3">search_off</span>
            <p class="text-lg font-bold">Menu tidak ditemukan</p>
            <p class="text-sm mt-1">Coba gunakan kata kunci pencarian atau kategori lain.</p>
        </div>

    </div>
</section>

<!-- Slideshow Script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const slides = document.querySelectorAll('#hero-slideshow > div');
        let currentSlide = 0;

        if (slides.length > 0) {
            setInterval(() => {
                slides[currentSlide].classList.remove('opacity-100');
                slides[currentSlide].classList.add('opacity-0');

                currentSlide = (currentSlide + 1) % slides.length;

                slides[currentSlide].classList.remove('opacity-0');
                slides[currentSlide].classList.add('opacity-100');
            }, 6000); // Ganti background setiap 6 detik
        }
    });
</script>

<!-- Filter Script -->
<script>
    let activeType = 'semua';
    let activeCategory = 'semua';
    
    function filterType(type) {
        activeType = type;
        
        // Update type switcher UI
        document.querySelectorAll('.tab-type-btn').forEach(btn => {
            btn.className = 'tab-type-btn text-gray-600 hover:text-gray-800 px-5 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap';
        });
        const targetBtn = document.getElementById(`btn-type-${type}`);
        if(targetBtn) {
            targetBtn.className = 'tab-type-btn bg-white text-gray-800 px-5 py-2 rounded-xl text-xs font-bold shadow-sm transition whitespace-nowrap';
        }
        
        // Show/hide subcategory pills based on type
        const pills = document.querySelectorAll('.cat-pill-btn');
        pills.forEach(pill => {
            // Reset to unselected first
            pill.classList.remove('active-amber-pill', 'active-blue-pill');
            pill.classList.add('bg-white', 'text-gray-600', 'border', 'border-gray-100');
            
            if (type === 'semua') {
                pill.classList.remove('hidden');
            } else if (type === 'makanan') {
                if (pill.classList.contains('minuman-cat')) {
                    pill.classList.add('hidden');
                } else {
                    pill.classList.remove('hidden');
                }
            } else if (type === 'minuman') {
                if (pill.classList.contains('makanan-cat')) {
                    pill.classList.add('hidden');
                } else {
                    pill.classList.remove('hidden');
                }
            }
        });
        
        // Default subcategory to 'semua' when switching type
        filterCategory('semua');
    }

    function filterCategory(cat) {
        activeCategory = cat;

        // Update subcategory pills UI
        const pills = document.querySelectorAll('.cat-pill-btn');
        pills.forEach(pill => {
            pill.classList.remove('active-amber-pill', 'active-blue-pill');
            pill.classList.add('bg-white', 'text-gray-600', 'border', 'border-gray-100');
        });

        // Set selected style on target pill
        const targetPill = Array.from(pills).find(p => {
            if (cat === 'semua') {
                return p.textContent.trim().toLowerCase() === 'semua kategori';
            }
            return p.textContent.trim() === cat;
        });

        if (targetPill) {
            targetPill.classList.remove('bg-white', 'text-gray-600', 'border-gray-100');
            if (activeType === 'minuman') {
                targetPill.classList.add('active-blue-pill');
            } else {
                targetPill.classList.add('active-amber-pill');
            }
        }

        applyFilters();
    }

    function applyFilters() {
        const query = document.getElementById('menu-search').value.toLowerCase().trim();
        const cards = document.querySelectorAll('.product-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            const desc = card.getAttribute('data-desc');
            const category = card.getAttribute('data-category');
            
            // Check type (makanan / minuman)
            const matchesType = (activeType === 'semua') || 
                                (activeType === 'makanan' && card.classList.contains('makanan-card')) ||
                                (activeType === 'minuman' && card.classList.contains('minuman-card'));
            
            // Check subcategory
            const matchesCat = (activeCategory === 'semua') || (category === activeCategory);
            
            // Check search query
            const matchesSearch = !query || name.includes(query) || desc.includes(query);

            if (matchesType && matchesCat && matchesSearch) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        const emptyState = document.getElementById('menu-empty');
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }

    // Attach search event
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('menu-search');
        if(searchInput) {
            searchInput.addEventListener('input', applyFilters);
        }
    });
</script>

@endsection
