<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('uat_answers', function (Blueprint $table) {

            $table->string('jenis_kelamin')->nullable();

            $table->string('usia')->nullable();

            $table->string('pekerjaan')->nullable();

            $table->string('pekerjaan_lainnya')->nullable();

            $table->string('asal_daerah')->nullable();

            $table->string('frekuensi_digital')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('uat_answers', function (Blueprint $table) {

            $table->dropColumn([
                'jenis_kelamin',
                'usia',
                'pekerjaan',
                'pekerjaan_lainnya',
                'asal_daerah',
                'frekuensi_digital'
            ]);

        });
    }
};
