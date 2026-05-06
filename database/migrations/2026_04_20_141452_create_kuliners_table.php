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
        Schema::create('kuliner', function (Blueprint $table) {
            $table->id('kuliner_id');

            $table->foreignId('kategori_kuliner_id');

            $table->string('nama_tempat');
            $table->string('jam_buka')->nullable();
            $table->string('jam_tutup')->nullable();

            $table->string('alamat')->nullable();
            $table->string('lokasi_geo')->nullable();

            $table->decimal('htm_min', 10, 2)->nullable();
            $table->decimal('htm_max', 10, 2)->nullable();

            $table->string('gambar')->nullable();

            $table->timestamps();

            $table->foreign('kategori_kuliner_id')
                ->references('kategori_kuliner_id')
                ->on('kategori_kuliner')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuliner');
    }
};
