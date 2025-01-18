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
        Schema::create('program_testimonis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentee_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('rating');
            $table->text('testimoni');
            $table->timestamps();

            $table->unique(['mentee_id', 'program_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_testimonis');
    }
};
