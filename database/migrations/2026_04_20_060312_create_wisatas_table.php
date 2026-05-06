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
        Schema::create('wisata', function (Blueprint $table) {
            $table->id('wisata_id');
            $table->foreignId('kategori_wisata_id');

            $table->string('nama_tempat');
            $table->string('jam_buka')->nullable();
            $table->string('jam_tutup')->nullable();

            $table->string('alamat')->nullable();
            $table->string('lokasi_geo')->nullable();

            $table->decimal('htm_min_domestik', 10, 2)->nullable();
            $table->decimal('htm_max_domestik', 10, 2)->nullable();
            $table->decimal('htm_min_mancanegara', 10, 2)->nullable();
            $table->decimal('htm_max_mancanegara', 10, 2)->nullable();

            $table->string('akses_transportasi')->nullable();

            $table->string('gambar')->nullable();

            $table->timestamps();

            $table->foreign('kategori_wisata_id')
                ->references('kategori_wisata_id')
                ->on('kategori_wisata')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wisata');
    }
};
