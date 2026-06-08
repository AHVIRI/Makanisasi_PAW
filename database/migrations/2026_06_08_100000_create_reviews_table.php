<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('makanan_id')->nullable()->constrained('makanan')->onDelete('cascade');
            $table->foreignId('minuman_id')->nullable()->constrained('minuman')->onDelete('cascade');
            $table->foreignId('pemesanan_id')->nullable()->constrained('pemesanan')->onDelete('cascade');
            $table->integer('rating')->default(5); // 1 to 5 stars
            $table->text('ulasan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
