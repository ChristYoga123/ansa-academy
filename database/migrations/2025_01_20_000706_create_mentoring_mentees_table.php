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
        Schema::create('mentoring_mentees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentee_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('mentor_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('mentoring_bidang_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('mentoring_paket_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentoring_mentees');
    }
};
