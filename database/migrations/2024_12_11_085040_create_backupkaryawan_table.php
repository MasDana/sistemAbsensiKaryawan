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
        Schema::create('backupkaryawan', function (Blueprint $table) {
            $table->id(); // Auto increment ID untuk backup
            $table->unsignedBigInteger('id_karyawan'); // ID dari tabel karyawan
            $table->string('nama_karyawan');
            $table->unsignedBigInteger('jabatan_id');
            $table->string('email');
            $table->string('no_hp');
            $table->string('password'); // Simpan hash password
            $table->date('tanggal_lahir');
            $table->enum('gender', ['male', 'female']);
            $table->text('alamat');
            $table->timestamps(); // Waktu backup

            // Foreign key untuk menjaga hubungan dengan tabel jabatan
            $table->foreign('jabatan_id')->references('id')->on('jabatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backupkaryawan');
    }
};