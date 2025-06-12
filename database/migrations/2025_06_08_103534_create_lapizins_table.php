<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lapizins', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('nama');
            $table->string('jabatan');
            $table->string('divisi');
            $table->date('tanggal_izin');
            $table->date('tanggal_masuk');
            $table->text('keterangan')->nullable();

            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->enum('status_hrd', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->enum('status_kepala_divisi', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->enum('status_direktur', ['pending', 'disetujui', 'ditolak'])->default('pending');

            $table->text('keterangan_penolakan')->nullable();

            // 🔽 kolom bukti opsional
            $table->string('bukti')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lapizins');
    }
};
