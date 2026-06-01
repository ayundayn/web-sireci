<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uat_answers', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('cascade');

            // SECTION 1
            $table->string('q1')->nullable();
            $table->string('q2')->nullable();
            $table->string('q3')->nullable();
            $table->string('q4')->nullable();
            $table->string('q5')->nullable();
            $table->string('q6')->nullable();
            $table->string('q7')->nullable();
            $table->string('q8')->nullable();

            // SECTION 2
            $table->tinyInteger('q9')->nullable();
            $table->tinyInteger('q10')->nullable();
            $table->tinyInteger('q11')->nullable();
            $table->tinyInteger('q12')->nullable();
            $table->tinyInteger('q13')->nullable();
            $table->tinyInteger('q14')->nullable();
            $table->tinyInteger('q15')->nullable();
            $table->tinyInteger('q16')->nullable();
            $table->tinyInteger('q17')->nullable();
            $table->tinyInteger('q18')->nullable();
            $table->tinyInteger('q19')->nullable();
            $table->tinyInteger('q20')->nullable();
            $table->tinyInteger('q21')->nullable();
            $table->tinyInteger('q22')->nullable();
            $table->tinyInteger('q23')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uat_answers');
    }
};
