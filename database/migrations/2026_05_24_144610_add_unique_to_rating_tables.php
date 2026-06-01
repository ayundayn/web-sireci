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
        Schema::table('rating_wisata', function (Blueprint $table) {

            $table->unique(
                ['user_id', 'wisata_id'],
                'rating_wisata_unique_user_destinasi'
            );

        });

        Schema::table('rating_kuliner', function (Blueprint $table) {

            $table->unique(
                ['user_id', 'kuliner_id'],
                'rating_kuliner_unique_user_destinasi'
            );

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rating_wisata', function (Blueprint $table) {

            $table->dropUnique(
                'rating_wisata_unique_user_destinasi'
            );

        });

        Schema::table('rating_kuliner', function (Blueprint $table) {

            $table->dropUnique(
                'rating_kuliner_unique_user_destinasi'
            );

        });
    }
};
