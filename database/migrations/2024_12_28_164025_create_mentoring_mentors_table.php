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
        Schema::create('mentoring_mentors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentoring_id')->constrained('mentorings')->cascadeOnDelete();
            $table->unsignedBigInteger('mentor_id');
            $table->timestamps();

            $table->foreign('mentor_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentoring_mentors');
    }
};
