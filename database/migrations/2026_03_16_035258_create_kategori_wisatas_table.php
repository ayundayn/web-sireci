<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_wisata', function (Blueprint $table) {

            $table->id('kategori_wisata_id');

            $table->string('nama_kategori',100);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_wisata');
    }
};
