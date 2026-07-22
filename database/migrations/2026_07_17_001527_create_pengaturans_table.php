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
        Schema::create('pengaturans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah', 100);
            $table->string('logo')->nullable();
            $table->time('jam_masuk');
            $table->time('batas_terlambat');
            $table->time('scan_mulai');
            $table->time('scan_selesai');
            $table->string('timezone', 50)->default('Asia/Jakarta');
            $table->timestamps();
            $table->boolean('aktifkan_foto')->default(true);
            $table->boolean('aktifkan_suara')->default(true);
            $table->string('alamat_sekolah')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('kepala_sekolah')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};
