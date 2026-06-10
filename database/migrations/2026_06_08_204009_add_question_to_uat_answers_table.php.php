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
        Schema::table('uat_answers', function (Blueprint $table) {

            $table->text('sumber_informasi')->nullable();

            $table->text('saran_pengguna')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('uat_answers', function (Blueprint $table) {

            $table->dropColumn([
                'sumber_informasi',
                'saran_pengguna'
            ]);

        });
    }
};
