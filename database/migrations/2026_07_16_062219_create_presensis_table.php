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
        Schema::create('presensis', function (Blueprint $table) {

            $table->id();

            // Siswa
            $table->foreignId('siswa_id')
                ->constrained('siswas')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Guru
            $table->foreignId('guru_id')
                ->constrained('gurus')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Tahun Ajaran
            $table->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajarans')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Tanggal Presensi
            $table->date('tanggal');

            // Jam Scan
            $table->time('jam_scan');

            // Status
            $table->enum('status', [
                'Hadir',
                'Terlambat',
                'Sakit',
                'Izin',
                'Alpha',
            ])->default('Hadir');

            // Metode
            $table->enum('metode', [
                'Barcode',
                'QR',
                'RFID',
                'Fingerprint',
                'FaceID',
                'Manual',
            ])->default('Barcode');

            // Catatan
            $table->text('keterangan')->nullable();

            // Nama Device
            $table->string('device_name')->nullable();

            $table->timestamps();

            // Index
            $table->index('tanggal');
            $table->index('status');

            // Mencegah siswa presensi dua kali di hari yang sama
            $table->unique([
                'siswa_id',
                'tanggal'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};