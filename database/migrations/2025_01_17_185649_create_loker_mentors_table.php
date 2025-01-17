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
        Schema::create('loker_mentors', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('no_hp');
            $table->string('universitas');
            $table->enum('semester', ['6', '7', '8', '9', 'Fresh Graduate']);
            $table->enum('mahasiswa_berprestrasi', ['Fakultas', 'Universitas', 'Wilayah', 'Nasional'])->nullable();
            $table->longText('alasan_mendaftar');
            $table->json('pencapaian');
            $table->text('drive_portofolio');
            $table->enum('status_penerimaan', ['Diterima', 'Ditolak', 'Menunggu']);
            $table->string('linkedin');
            $table->string('instagram');
            $table->longText('alasan_ditolak')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loker_mentors');
    }
};
