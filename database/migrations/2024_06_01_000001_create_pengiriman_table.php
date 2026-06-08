<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('pemesanan')->onDelete('cascade');
            $table->string('kurir')->nullable();
            $table->string('nomor_kontak_kurir')->nullable();
            $table->string('alamat_pengiriman');
            $table->string('nomor_resi')->nullable()->unique();
            $table->timestamp('tanggal_kirim')->nullable();
            $table->enum('status_pengiriman', ['proses_memasak', 'dalam_perjalanan', 'sampai', 'gagal'])->default('proses_memasak');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
    }
};
