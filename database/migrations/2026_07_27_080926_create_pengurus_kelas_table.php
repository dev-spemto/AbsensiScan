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
        Schema::create('pengurus_kelas', function (Blueprint $table) {

            $table->id();

            // Kelas
            $table->foreignId('kelas_id')
                ->constrained('kelas')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // Ketua
            $table->foreignId('ketua_siswa_id')
                ->nullable()
                ->constrained('siswas')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('ketua_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            // Wakil
            $table->foreignId('wakil_siswa_id')
                ->nullable()
                ->constrained('siswas')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('wakil_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            // Sekretaris
            $table->foreignId('sekretaris_siswa_id')
                ->nullable()
                ->constrained('siswas')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('sekretaris_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();

            $table->unique('kelas_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengurus_kelas');
    }
};