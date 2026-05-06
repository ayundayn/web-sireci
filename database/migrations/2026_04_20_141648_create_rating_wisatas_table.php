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
        Schema::create('rating_wisata', function (Blueprint $table) {
            $table->id('rating_wisata_id');

            $table->foreignId('user_id');
            $table->foreignId('wisata_id');

            $table->decimal('nilai_rating', 2, 1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating_wisata');
    }
};
