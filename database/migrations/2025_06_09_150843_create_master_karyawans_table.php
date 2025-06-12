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
        Schema::create('master_karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('nama', 60); // batas 60 karakter
            $table->string('jabatan', 45); // tetap 45 karakter
            $table->string('divisi', 45); // tetap 45 karakter
            $table->enum('role', ['karyawan', 'hrd', 'kepala_divisi', 'direktur']);
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_karyawans');
    }
};

