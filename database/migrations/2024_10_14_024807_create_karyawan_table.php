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
            Schema::create('karyawan', function (Blueprint $table) {
                $table->unsignedBigInteger('id')->autoIncrement()->startingValue(101); // Use unsignedBigInteger
                $table->string('nama_karyawan');
                $table->foreignId('jabatan_id')->constrained('jabatan');
                $table->string('email')->unique();
                $table->string('no_hp');
                $table->string('password');
                $table->date('tanggal_lahir');
                $table->enum('gender', ['male', 'female']);
                $table->text('alamat');
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
