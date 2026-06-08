<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makanisasi - E-Commerce Pemesanan Kuliner Premium</title>
    <link rel="shortcut icon" href="{{ asset('/logo.png') }}" type="image/png">
    
    <!-- Tailwind CSS (V2) & Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8fafc;
        }
        .font-title { 
            font-family: 'Outfit', sans-serif; 
        }
        
        /* Glassmorphism utility */
        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.25);
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-b: 1px solid rgba(241, 245, 249, 1);
        }

        /* Hover & Animation effects */
        .nav-link-custom {
            position: relative;
            transition: all 0.3s ease;
        }
        .nav-link-custom::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #f59e0b, #eef2f6);
            transition: width 0.3s ease;
        }
        .nav-link-custom:hover::after {
            width: 100%;
        }
        .nav-link-custom:hover {
            color: #f59e0b;
        }
        
        .btn-premium {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 14px 0 rgba(245, 158, 11, 0.3);
        }
        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px 0 rgba(245, 158, 11, 0.45);
        }
        .btn-premium:active {
            transform: translateY(0);
        }

        .btn-premium-secondary {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 14px 0 rgba(79, 70, 229, 0.3);
        }
        .btn-premium-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px 0 rgba(79, 70, 229, 0.45);
        }

        /* Toast notifications */
        .toast-notification {
            animation: slideIn 0.3s ease forwards, fadeOut 0.5s ease 4.5s forwards;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; pointer-events: none; }
        }
        
        /* Floating animations */
        .float-slow {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        /* Custom Cross-Browser Gradients */
        .bg-gradient-amber {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        }
        .bg-gradient-blue {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
        }
        .bg-gradient-green {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%) !important;
        }
        .bg-gradient-pink {
            background: linear-gradient(135deg, #ec4899 0%, #be185d 100%) !important;
        }

        /* Custom Amber Color Utilities */
        .bg-amber-50 { background-color: #fffbeb !important; }
        .bg-amber-100 { background-color: #fef3c7 !important; }
        .bg-amber-500 { background-color: #f59e0b !important; }
        .bg-amber-600 { background-color: #d97706 !important; }
        .hover\:bg-amber-600:hover { background-color: #d97706 !important; }
        .text-amber-100 { color: #fef3c7 !important; }
        .text-amber-500 { color: #f59e0b !important; }
        .text-amber-600 { color: #d97706 !important; }
        .text-amber-700 { color: #b45309 !important; }
        .text-amber-800 { color: #92400e !important; }
        .text-amber-900 { color: #78350f !important; }
        .border-amber-100 { border-color: #fef3c7 !important; }
        .border-amber-200 { border-color: #fde68a !important; }
        .border-amber-500 { border-color: #f59e0b !important; }
        .focus\:ring-amber-500:focus { --tw-ring-color: #f59e0b !important; }
        .focus\:border-amber-500:focus { border-color: #f59e0b !important; }

        /* Custom Active Pills */
        .active-amber-pill {
            background-color: #f59e0b !important;
            color: #ffffff !important;
            border-color: #f59e0b !important;
        }
        .active-blue-pill {
            background-color: #3b82f6 !important;
            color: #ffffff !important;
            border-color: #3b82f6 !important;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased selection:bg-yellow-200">

    @php
        // Mengambil jumlah item di keranjang belanja secara dinamis
        $cartCount = 0;
        if (Auth::check() && Auth::user()->role === 'Customer') {
            $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity');
        }
    @endphp

    <!-- Header / Navbar -->
    <header class="fixed w-full z-40 top-0 left-0 glass-nav transition-all duration-300 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="relative overflow-hidden rounded-xl border border-amber-500/25 shadow-sm transition-transform duration-300 group-hover:scale-105 bg-white p-1">
                            <img src="/logo.png" alt="Logo" class="h-9 w-9 object-contain filter contrast-[1.4] brightness-[0.75] saturate-[1.6]">
                        </div>
                        <span class="text-2xl font-bold font-title tracking-tight text-gray-800 bg-gradient-to-r from-gray-900 via-amber-700 to-amber-900 bg-clip-text text-transparent">
                            Makanisasi
                        </span>
                    </a>
                </div>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-gray-600">
                    <a href="{{ route('home') }}" class="nav-link-custom {{ Request::is('/') ? 'text-amber-500' : '' }}">Home</a>
                    <a href="{{ route('home') }}#about" class="nav-link-custom">Tentang Kami</a>
                    <a href="{{ route('home') }}#menu" class="nav-link-custom">Menu</a>
                    
                    @auth
                        @if(Auth::user()->role === 'Customer')
                            <a href="{{ route('wishlist.index') }}" class="nav-link-custom {{ Request::is('wishlist*') ? 'text-amber-500' : '' }} flex items-center gap-1">
                                <span class="material-icons text-lg">favorite_border</span> Wishlist
                            </a>
                            <a href="{{ route('pemesanan.history') }}" class="nav-link-custom {{ Request::is('riwayat*') ? 'text-amber-500' : '' }} flex items-center gap-1">
                                <span class="material-icons text-lg">receipt_long</span> Pesanan
                            </a>
                        @endif
                    @endauth
                </nav>

                <!-- Right Nav Elements -->
                <div class="hidden md:flex items-center space-x-5">
                    @auth
                        @if(Auth::user()->role === 'Customer')
                            <!-- Shopping Cart Button with Count Badge -->
                            <a href="{{ route('cartItem') }}" class="relative p-2.5 text-gray-600 hover:text-amber-500 transition-colors rounded-full hover:bg-gray-50">
                                <span class="material-icons text-2xl">shopping_cart</span>
                                @if($cartCount > 0)
                                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/3 -translate-y-1/3 bg-red-500 rounded-full">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        @endif

                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.index') }}" class="btn-premium-secondary px-5 py-2 rounded-full text-sm font-semibold tracking-wide shadow flex items-center gap-1">
                                <span class="material-icons text-sm">dashboard</span> Panel Admin
                            </a>
                        @endif

                        <!-- Profile Tag -->
                        <div class="flex items-center space-x-3 border-l pl-5 border-gray-200">
                            <div class="text-right">
                                <p class="text-xs font-bold text-gray-800 leading-tight">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-400 font-light">{{ ucfirst(Auth::user()->role) }}</p>
                            </div>
                            <span class="material-icons text-gray-400 text-3xl select-none">account_circle</span>
                        </div>

                        <!-- Logout Form -->
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-full transition-colors" title="Keluar">
                                <span class="material-icons text-2xl">logout</span>
                            </button>
                        </form>
                    @else
                        <!-- Guest Buttons -->
                        <a href="/login" class="text-sm font-bold text-gray-600 hover:text-amber-500 transition-colors">Masuk</a>
                        <a href="/register" class="btn-premium px-6 py-2.5 rounded-full text-sm font-semibold tracking-wide">Daftar</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex md:hidden items-center space-x-3">
                    @auth
                        @if(Auth::user()->role === 'Customer')
                            <a href="{{ route('cartItem') }}" class="relative p-2 text-gray-600">
                                <span class="material-icons text-2xl">shopping_cart</span>
                                @if($cartCount > 0)
                                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-500 rounded-full">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        @endif
                    @endauth
                    
                    <button id="mobile-menu-btn" class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 focus:outline-none">
                        <span class="material-icons text-3xl">menu</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div id="mobile-menu" class="fixed inset-0 z-50 bg-white/95 backdrop-blur-md hidden flex-col items-center justify-center transition-all duration-300">
            <button id="close-mobile-menu" class="absolute top-6 right-6 p-2 rounded-full hover:bg-gray-100 text-gray-600">
                <span class="material-icons text-3xl">close</span>
            </button>
            <nav class="flex flex-col space-y-6 text-center text-xl font-bold text-gray-800">
                <a href="{{ route('home') }}" onclick="closeMobileMenu()" class="hover:text-amber-500">Home</a>
                <a href="{{ route('home') }}#about" onclick="closeMobileMenu()" class="hover:text-amber-500">Tentang Kami</a>
                <a href="{{ route('home') }}#menu" onclick="closeMobileMenu()" class="hover:text-amber-500">Menu</a>
                
                @auth
                    @if(Auth::user()->role === 'Customer')
                        <a href="{{ route('cartItem') }}" onclick="closeMobileMenu()" class="hover:text-amber-500">Keranjang ({{ $cartCount }})</a>
                        <a href="{{ route('wishlist.index') }}" onclick="closeMobileMenu()" class="hover:text-amber-500">Wishlist Saya</a>
                        <a href="{{ route('pemesanan.history') }}" onclick="closeMobileMenu()" class="hover:text-amber-500">Riwayat Pesanan</a>
                    @endif
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.index') }}" onclick="closeMobileMenu()" class="text-indigo-600 hover:text-indigo-800">Dashboard Admin</a>
                    @endif
                    
                    <hr class="w-24 mx-auto border-gray-200">
                    <div class="text-sm font-semibold text-gray-500">
                        Masuk sebagai: <span class="text-gray-800 font-bold">{{ Auth::user()->name }}</span>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}" class="pt-2">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-8 py-2.5 rounded-full text-base font-semibold shadow hover:bg-red-600 transition">
                            Logout
                        </button>
                    </form>
                @else
                    <hr class="w-24 mx-auto border-gray-200">
                    <a href="/login" onclick="closeMobileMenu()" class="text-gray-600 hover:text-amber-500">Masuk</a>
                    <a href="/register" onclick="closeMobileMenu()" class="btn-premium px-8 py-2.5 rounded-full text-base font-semibold">Daftar Sekarang</a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow pt-28 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <!-- Floating Global Toast Alerts -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col space-y-3 max-w-sm w-full">
        @if(session('success'))
            <div id="toast-success" class="toast-notification flex items-center p-4 bg-green-600 text-white rounded-xl shadow-2xl space-x-3 border border-green-500">
                <span class="material-icons">check_circle</span>
                <div class="text-sm font-medium flex-1">{{ session('success') }}</div>
                <button onclick="document.getElementById('toast-success').remove()" class="text-white hover:opacity-75">
                    <span class="material-icons text-base">close</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div id="toast-error" class="toast-notification flex items-center p-4 bg-red-600 text-white rounded-xl shadow-2xl space-x-3 border border-red-500">
                <span class="material-icons">error</span>
                <div class="text-sm font-medium flex-1">{{ session('error') }}</div>
                <button onclick="document.getElementById('toast-error').remove()" class="text-white hover:opacity-75">
                    <span class="material-icons text-base">close</span>
                </button>
            </div>
        @endif
        
        @if($errors->any())
            <div id="toast-errors" class="toast-notification flex items-start p-4 bg-red-600 text-white rounded-xl shadow-2xl space-x-3 border border-red-500">
                <span class="material-icons mt-0.5">warning</span>
                <div class="text-sm font-medium flex-1">
                    <p class="font-bold">Error:</p>
                    <ul class="list-disc pl-4 text-xs mt-1 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="document.getElementById('toast-errors').remove()" class="text-white hover:opacity-75">
                    <span class="material-icons text-base">close</span>
                </button>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 mt-auto border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Info Brand -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="relative overflow-hidden rounded-xl border border-white/10 shadow-sm bg-white/5 p-1">
                            <img src="/logo.png" alt="Logo" class="h-7 w-7 object-contain filter contrast-[1.4] brightness-[1.1] saturate-[1.6]">
                        </div>
                        <span class="text-xl font-bold font-title text-white">Makanisasi</span>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed mb-4 max-w-sm">
                        Kami menghadirkan pengalaman berbelanja makanan & minuman premium secara online. Menikmati hidangan kuliner lezat sekarang menjadi lebih mudah, higienis, dan cepat sampai di depan rumah Anda.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="p-2 bg-gray-800 rounded-full hover:bg-amber-500 hover:text-white transition-colors"><span class="material-icons text-base flex justify-center items-center">facebook</span></a>
                        <a href="#" class="p-2 bg-gray-800 rounded-full hover:bg-amber-500 hover:text-white transition-colors"><span class="material-icons text-base flex justify-center items-center">camera_alt</span></a>
                        <a href="#" class="p-2 bg-gray-800 rounded-full hover:bg-amber-500 hover:text-white transition-colors"><span class="material-icons text-base flex justify-center items-center">email</span></a>
                    </div>
                </div>

                <!-- Tautan Menu -->
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4 font-title">Navigasi</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-amber-500 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('home') }}#about" class="hover:text-amber-500 transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('home') }}#menu" class="hover:text-amber-500 transition-colors">Menu Kuliner</a></li>
                        <li><a href="{{ route('cartItem') }}" class="hover:text-amber-500 transition-colors">Keranjang Belanja</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4 font-title">Hubungi Kami</h3>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li class="flex items-start gap-2">
                            <span class="material-icons text-amber-500 text-base mt-0.5">location_on</span>
                            <span>Jl. Kuliner Raya No. 42, Sleman, D.I. Yogyakarta</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="material-icons text-amber-500 text-base">phone</span>
                            <span>+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="material-icons text-amber-500 text-base">schedule</span>
                            <span>09:00 - 22:00 WIB</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <hr class="border-gray-800 my-8">
            
            <div class="flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} Makanisasi. Seluruh Hak Cipta Dilindungi.</p>
                <div class="flex space-x-6 mt-3 sm:mt-0">
                    <a href="#" class="hover:underline">Kebijakan Privasi</a>
                    <a href="#" class="hover:underline">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Menu Mobile Handler
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeBtn = document.getElementById('close-mobile-menu');
        
        if (menuBtn && mobileMenu && closeBtn) {
            menuBtn.onclick = () => {
                mobileMenu.classList.remove('hidden');
                mobileMenu.classList.add('flex');
            };
            closeBtn.onclick = () => {
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('flex');
            };
        }
        
        function closeMobileMenu() {
            if (mobileMenu) {
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('flex');
            }
        }

        // Auto Close Toasts after 5 seconds
        document.addEventListener('DOMContentLoaded', () => {
            const toasts = document.querySelectorAll('.toast-notification');
            toasts.forEach(toast => {
                setTimeout(() => {
                    toast.remove();
                }, 5000);
            });
        });

        // Smooth scroll handler for anchor links
        document.addEventListener('click', function(e) {
            const targetLink = e.target.closest('a');
            if (!targetLink) return;

            const href = targetLink.getAttribute('href');
            if (!href) return;

            try {
                // Parse target url relative to current origin
                const url = new URL(targetLink.href);
                const currentUrl = new URL(window.location.href);

                // Check if target link points to current page path
                if (url.origin === currentUrl.origin && url.pathname === currentUrl.pathname) {
                    if (url.hash) {
                        // Scroll to the hash section
                        const targetEl = document.querySelector(url.hash);
                        if (targetEl) {
                            e.preventDefault();
                            closeMobileMenu();
                            
                            const navbarHeight = 90;
                            const elementPosition = targetEl.getBoundingClientRect().top + window.pageYOffset;
                            const offsetPosition = elementPosition - navbarHeight;

                            window.scrollTo({
                                top: offsetPosition,
                                behavior: 'smooth'
                            });
                        }
                    } else if (url.pathname === '/') {
                        // If on home page and clicking Home link (no hash)
                        e.preventDefault();
                        closeMobileMenu();
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }
                }
            } catch (err) {
                // Fallback for relative paths or mailto/tel links
            }
        });

        // Handle scrolling when arriving from another page with hash (e.g. /cart -> /#menu)
        window.addEventListener('load', function() {
            if (window.location.hash) {
                const hash = window.location.hash;
                const targetEl = document.querySelector(hash);
                if (targetEl) {
                    setTimeout(() => {
                        const navbarHeight = 90;
                        const elementPosition = targetEl.getBoundingClientRect().top + window.pageYOffset;
                        const offsetPosition = elementPosition - navbarHeight;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                    }, 200);
                }
            }
        });
    </script>
</body>
</html>
