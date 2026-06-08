<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('makanan_id')->nullable()->constrained('makanan')->onDelete('cascade');
            $table->foreignId('minuman_id')->nullable()->constrained('minuman')->onDelete('cascade');
            $table->date('tanggal_pemesanan');
            $table->decimal('total_harga', 10, 2);
            $table->text('alamat_pengiriman')->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};