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
        Schema::create('kuliner_gambar', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('kuliner_id');

            $table->string('gambar');

            $table->timestamps();

            $table->foreign('kuliner_id')
                ->references('kuliner_id')
                ->on('kuliner')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuliner_gambar');
    }
};
