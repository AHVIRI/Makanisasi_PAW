@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[70vh] py-10">
    <div class="w-full max-w-md bg-white rounded-3xl border border-gray-100 shadow-2xl overflow-hidden">
        
        <!-- Welcome banner -->
        <div class="bg-gradient-amber p-8 text-center text-white">
            <span class="material-icons text-5xl mb-2 float-slow">login</span>
            <h2 class="text-2xl font-extrabold font-title">Selamat Datang Kembali</h2>
            <p class="text-xs text-amber-100 mt-1">Masuk untuk memesan kuliner premium kesukaan Anda</p>
        </div>

        <!-- Form content -->
        <form method="POST" action="{{ route('login') }}" class="p-8 space-y-6 m-0">
            @csrf

            <!-- Email -->
            <div class="space-y-1.5">
                <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <span class="material-icons text-lg">mail_outline</span>
                    </span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="contoh@domain.com"
                        class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 bg-gray-50/50 text-sm transition @error('email') border-red-500 @enderror">
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="space-y-1.5">
                <div class="flex justify-between items-center">
                    <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Password</label>
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                        <span class="material-icons text-lg">lock_open</span>
                    </span>
                    <input id="password" type="password" name="password" required placeholder="••••••••"
                        class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 bg-gray-50/50 text-sm transition @error('password') border-red-500 @enderror">
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember me -->
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                    class="h-4.5 w-4.5 text-amber-500 border-gray-300 rounded focus:ring-amber-500">
                <label for="remember" class="ml-2 text-xs font-bold text-gray-500 uppercase tracking-wider select-none">Remember Me</label>
            </div>

            <!-- Action buttons -->
            <div class="pt-2 space-y-4">
                <button type="submit" class="btn-premium w-full py-4 rounded-full font-bold text-center text-sm shadow-md hover:shadow-lg transition">
                    Masuk Ke Akun
                </button>
                
                <p class="text-center text-xs text-gray-400">
                    Belum punya akun? 
                    <a href="/register" class="text-amber-500 font-bold hover:underline">Daftar Sekarang</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection