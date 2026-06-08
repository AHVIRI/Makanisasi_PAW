@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">
    
    <!-- Title -->
    <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-100">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800 font-title">Edit Makanan</h1>
            <p class="text-sm text-gray-500 mt-0.5">Ubah rincian menu makanan terpilih</p>
        </div>
        <a href="{{ route('admin.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-full text-xs font-bold transition flex items-center gap-1">
            <span class="material-icons text-sm">arrow_back</span> Kembali
        </a>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('admin.makananupdate', $makanan->id) }}" enctype="multipart/form-data" class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="space-y-1.5">
            <label for="nama_makanan" class="block text-xs font-bold text-gray-500 uppercase tracking-wider font-semibold">Nama Makanan</label>
            <input type="text" name="nama_makanan" id="nama_makanan" value="{{ old('nama_makanan', $makanan->nama_makanan) }}" required
                class="w-full p-4 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 bg-gray-50/50 text-sm transition">
        </div>

        <!-- Description -->
        <div class="space-y-1.5">
            <label for="deskripsi" class="block text-xs font-bold text-gray-500 uppercase tracking-wider font-semibold">Deskripsi Lengkap</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" required
                class="w-full p-4 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 bg-gray-50/50 text-sm transition leading-relaxed">{{ old('deskripsi', $makanan->deskripsi) }}</textarea>
        </div>

        <!-- Category & Price -->
        <div class="grid sm:grid-cols-2 gap-6">
            <!-- Category selection -->
            <div class="space-y-1.5">
                <label for="kategori" class="block text-xs font-bold text-gray-500 uppercase tracking-wider font-semibold font-semibold">Kategori Makanan</label>
                <div class="relative">
                    <select name="kategori" id="kategori" required 
                        class="w-full p-4 pr-10 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 bg-gray-50/50 text-sm transition appearance-none">
                        <option value="Makanan Utama" @if(old('kategori', $makanan->kategori) == 'Makanan Utama') selected @endif>Makanan Utama</option>
                        <option value="Camilan" @if(old('kategori', $makanan->kategori) == 'Camilan') selected @endif>Camilan</option>
                    </select>
                    <span class="material-icons absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">expand_more</span>
                </div>
            </div>

            <!-- Price -->
            <div class="space-y-1.5">
                <label for="price" class="block text-xs font-bold text-gray-500 uppercase tracking-wider font-semibold">Harga (Rupiah)</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 font-bold text-xs">Rp</span>
                    <input type="number" name="price" id="price" value="{{ old('price', (int) $makanan->price) }}" min="0" required
                        class="w-full pl-10 pr-4 py-4 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 bg-gray-50/50 text-sm transition">
                </div>
            </div>
        </div>

        <!-- Availability -->
        <div class="space-y-1.5">
            <label for="is_available" class="block text-xs font-bold text-gray-500 uppercase tracking-wider font-semibold">Status Ketersediaan</label>
            <div class="relative">
                <select name="is_available" id="is_available" required 
                    class="w-full p-4 pr-10 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 bg-gray-50/50 text-sm transition appearance-none">
                    <option value="1" {{ $makanan->is_available ? 'selected' : '' }}>Tersedia (Ready)</option>
                    <option value="0" {{ !$makanan->is_available ? 'selected' : '' }}>Tidak Tersedia (Sold Out)</option>
                </select>
                <span class="material-icons absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">expand_more</span>
            </div>
        </div>

        <!-- Image Upload -->
        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider font-semibold">Foto Hidangan</label>
            <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 hover:bg-gray-50 transition flex flex-col items-center justify-center text-center relative group">
                <span class="material-icons text-4xl text-gray-300 group-hover:text-amber-500 transition mb-2">cloud_upload</span>
                <span class="text-xs text-gray-500 font-bold">Pilih foto baru atau seret ke sini</span>
                <span class="text-[10px] text-gray-400 mt-1">Dukungan format JPG, PNG, WEBP (Maksimal 2MB)</span>
                
                <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)"
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
            </div>

            <!-- Image Preview Box -->
            <div id="imagePreview" class="mt-4 border border-gray-100 rounded-2xl p-4 flex flex-col items-center bg-gray-50/50">
                <span class="text-[10px] text-gray-400 uppercase font-light mb-2 block" id="preview-title">Foto Saat Ini:</span>
                @if ($makanan->image)
                    <img id="preview" class="max-w-xs h-32 object-cover rounded-xl shadow-md" src="{{ asset('storage/' . $makanan->image) }}">
                @else
                    <span id="no-img-text" class="text-gray-400 text-xs">Belum ada gambar</span>
                    <img id="preview" class="max-w-xs h-32 object-cover rounded-xl shadow-md hidden" src="">
                @endif
            </div>
        </div>

        <!-- Submit -->
        <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('admin.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-full text-xs font-bold transition">Batal</a>
            <button type="submit" class="btn-premium px-8 py-3 rounded-full text-xs font-bold shadow-md hover:shadow-lg transition">Simpan Perubahan</button>
        </div>
    </form>
</div>

<!-- Image Preview Script -->
<script>
    function previewImage(event) {
        const previewImg = document.getElementById('preview');
        const file = event.target.files[0];
        const title = document.getElementById('preview-title');
        const noImgText = document.getElementById('no-img-text');

        if (file) {
            previewImg.src = URL.createObjectURL(file);
            previewImg.classList.remove('hidden');
            if(noImgText) noImgText.classList.add('hidden');
            title.textContent = 'Preview Upload Baru:';
        }
    }
</script>
@endsection
