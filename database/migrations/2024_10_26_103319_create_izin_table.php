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
        Schema::create('izin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawan');
            $table->date('tanggal_izin');
            $table->char('status', 1); // Misalnya: 'S' untuk Sakit, 'I' untuk Izin, dll.
            $table->string('keterangan', 255);
            $table->char('approved', 1)->default('N'); // 'Y' untuk Yes, 'N' untuk No
            $table->timestamps();

            // Foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin');
    }
};
