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
        Schema::create('rating_kuliner', function (Blueprint $table) {
            $table->id('rating_kuliner_id');

            $table->foreignId('user_id');
            $table->foreignId('kuliner_id');

            $table->decimal('nilai_rating', 2, 1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating_kuliner');
    }
};
