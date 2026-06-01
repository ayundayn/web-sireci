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
        Schema::table('wisata_preference', function (Blueprint $table) {
            $table->string('guest_id')->nullable()->index();
            $table->foreignId('user_id')->nullable()->change();
        });

        Schema::table('kuliner_preference', function (Blueprint $table) {
            $table->string('guest_id')->nullable()->index();
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('preferences', function (Blueprint $table) {
            //
        });
    }
};
