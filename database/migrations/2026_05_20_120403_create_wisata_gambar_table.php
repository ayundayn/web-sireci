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
        Schema::create('wisata_gambar', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('wisata_id');

            $table->string('gambar');

            $table->timestamps();

            $table->foreign('wisata_id')
                ->references('wisata_id')
                ->on('wisata')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wisata_gambar');
    }
};
