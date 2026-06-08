<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Makanan;
use App\Models\Minuman;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Hubungkan ke directory public storage dan buat directory images jika belum ada
        Storage::disk('public')->makeDirectory('images');

        // Seed Makanan
        $makananItems = [
            [
                'nama_makanan' => 'Nasi Goreng Spesial',
                'deskripsi' => 'Nasi goreng harum wangi dengan racikan bumbu khas, disajikan dengan telur mata sapi, ayam suwir, acar segar, dan kerupuk renyah.',
                'kategori' => 'Makanan Utama',
                'price' => 25000.00,
                'image' => 'images/nasi_goreng.jpg',
                'is_available' => true,
            ],
            [
                'nama_makanan' => 'Mie Goreng Seafood',
                'deskripsi' => 'Mie goreng kenyal dengan tumisan udang segar, cumi-cumi, bakso ikan, telur orak-arik, dan sayuran segar berlumur kecap manis gurih.',
                'kategori' => 'Makanan Utama',
                'price' => 28000.00,
                'image' => 'images/mie_goreng.jpg',
                'is_available' => true,
            ],
            [
                'nama_makanan' => 'Ayam Bakar Madu',
                'deskripsi' => 'Ayam bakar dengan bumbu madu gurih manis meresap hingga ke dalam, dipanggang dengan arang harum, disajikan dengan sambal terasi.',
                'kategori' => 'Makanan Utama',
                'price' => 30000.00,
                'image' => 'images/ayam_bakar.jpg',
                'is_available' => true,
            ],
            [
                'nama_makanan' => 'Sate Ayam Madura',
                'deskripsi' => '10 tusuk sate daging ayam pilihan yang empuk dibakar dengan kematangan sempurna, disiram saus kacang gurih pekat dan irisan bawang merah.',
                'kategori' => 'Makanan Utama',
                'price' => 22000.00,
                'image' => 'images/sate_ayam.jpg',
                'is_available' => true,
            ],
            [
                'nama_makanan' => 'Dimsum Ayam Premium',
                'deskripsi' => 'Dimsum ayam kukus bertekstur lembut dan kenyal, diisi daging ayam giling berkualitas tinggi, disajikan dengan saus sambal dimsum khas.',
                'kategori' => 'Camilan',
                'price' => 18000.00,
                'image' => 'images/dimsum.jpg',
                'is_available' => true,
            ],
        ];

        foreach ($makananItems as $item) {
            // Kita pastikan data tidak duplikat
            if (!Makanan::where('nama_makanan', $item['nama_makanan'])->exists()) {
                Makanan::create($item);
            }
        }

        // Seed Minuman
        $minumanItems = [
            [
                'nama_minuman' => 'Es Teh Manis',
                'deskripsi' => 'Teh hitam pilihan yang diseduh harum, disajikan dingin dengan es batu kristal dan rasa manis gula tebu asli yang menyegarkan.',
                'kategori' => 'Dingin',
                'price' => 5000.00,
                'image' => 'images/es_teh.jpg',
                'is_available' => true,
            ],
            [
                'nama_minuman' => 'Es Jeruk Peras',
                'deskripsi' => 'Perasan jeruk lokal segar alami kaya vitamin C, dipadukan dengan air gula murni dan es batu segar pelepas dahaga.',
                'kategori' => 'Dingin',
                'price' => 8000.00,
                'image' => 'images/es_jeruk.jpg',
                'is_available' => true,
            ],
            [
                'nama_minuman' => 'Kopi Susu Gula Aren',
                'deskripsi' => 'Espresso robusta berkualitas dipadu dengan susu segar creamy dan sirup gula aren organik yang legit.',
                'kategori' => 'Kopi',
                'price' => 15000.00,
                'image' => 'images/kopi_aren.jpg',
                'is_available' => true,
            ],
            [
                'nama_minuman' => 'Matcha Latte',
                'deskripsi' => 'Bubuk matcha premium Jepang asli yang dikocok lembut dengan susu hangat atau es creamy sesuai selera, rasa sedikit pahit khas matcha yang nikmat.',
                'kategori' => 'Dingin',
                'price' => 18000.00,
                'image' => 'images/matcha.jpg',
                'is_available' => true,
            ],
            [
                'nama_minuman' => 'Teh Tarik Hangat',
                'deskripsi' => 'Teh hitam pekat dicampur dengan kental manis lembut yang ditarik hingga berbusa melimpah, disajikan hangat menenangkan.',
                'kategori' => 'Hangat',
                'price' => 12000.00,
                'image' => 'images/teh_tarik.jpg',
                'is_available' => true,
            ],
        ];

        foreach ($minumanItems as $item) {
            if (!Minuman::where('nama_minuman', $item['nama_minuman'])->exists()) {
                Minuman::create($item);
            }
        }
    }
}
