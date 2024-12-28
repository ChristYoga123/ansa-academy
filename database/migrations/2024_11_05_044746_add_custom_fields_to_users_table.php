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
        Schema::table('users', function (Blueprint $table) {
            /**
             * Mentee Custom Fields:
             * 1. no_telp
             * 2. sekolah_universitas
             * 3. kelas_semester
             * 4. asal
             * 
             * Mentor Custom Fields:
             * 1. no_telp
             * 2. universitas
             * 3. semester
             * 4. mahasiswa_berprestasi
             * 5. pencapaian
             * 6. cv
             * 7. portofolio
             */
            $table->json('custom_fields')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('custom_fields');
        });
    }
};
