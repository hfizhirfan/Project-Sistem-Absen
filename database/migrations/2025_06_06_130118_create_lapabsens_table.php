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
        Schema::create('lapabsen', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('nip'); // bisa juga unsignedBigInteger jika relasi ke users
            $table->string('nama'); // nama lengkap
            $table->string('jabatan'); // misal: Staff, Manager
            $table->string('divisi'); // misal: HRD, Keuangan
            $table->timestamp('jam_absen')->useCurrent(); // default ke jam saat insert
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapabsens');
    }
};
