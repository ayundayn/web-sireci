<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kuliner_preference_kategori', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kuliner_preference_id')->constrained('kuliner_preference')->cascadeOnDelete();
            $table->foreignId('kategori_kuliner_id')->constrained('kategori_kuliner', 'kategori_kuliner_id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuliner_preference_kategori');
    }
};
