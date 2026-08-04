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
        Schema::create('izins', function (Blueprint $table) {

            $table->id();

            $table->foreignId('siswa_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('tanggal');

            $table->enum('jenis', [
                'Izin',
                'Sakit',
            ]);

            $table->text('keterangan')->nullable();

            $table->string('bukti')->nullable();

            $table->enum('status', [
                'Pending',
                'Disetujui',
                'Ditolak',
            ])->default('Pending');

            $table->foreignId('disetujui_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izins');
    }
};
