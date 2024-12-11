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
        Schema::create('backupjabatan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jabatan'); // ID dari tabel jabatan
            $table->string('nama_jabatan'); // Nama jabatan
            $table->timestamps(); // Waktu backup
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backupjabatan');
    }
};