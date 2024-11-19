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
        Schema::create('pengajuan_izin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawan')->onDelete('cascade');
            $table->date('tanggal_izin_dari');
            $table->date('tanggal_izin_sampai');
            $table->char('status', 1)->comment('i = izin, s = sakit');
            $table->string('keterangan', 255);
            $table->char('status_approved', 1)->default('0')->comment('0 = pending, 1 = disetujui, 2 = tolak');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_izin');
    }
};
