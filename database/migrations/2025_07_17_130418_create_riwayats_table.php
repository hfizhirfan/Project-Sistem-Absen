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
        Schema::create('riwayats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('master_karyawans')->onDelete('cascade');
            $table->string('nip');
            $table->string('nama');
            $table->string('jabatan');
            $table->string('divisi');
            $table->enum('jenis_laporan', ['cuti', 'izin', 'lembur']);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayats');
    }
};
