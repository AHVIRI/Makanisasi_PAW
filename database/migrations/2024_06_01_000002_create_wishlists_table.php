<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('makanan_id')->nullable()->constrained('makanan')->onDelete('cascade');
            $table->foreignId('minuman_id')->nullable()->constrained('minuman')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['user_id', 'makanan_id', 'minuman_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
