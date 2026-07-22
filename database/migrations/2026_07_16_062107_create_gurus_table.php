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
        Schema::create('gurus', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
            ->unique()
            ->constrained()
            ->cascadeOnDelete();

            $table->string('nip', 30)->unique();
            $table->string('nama', 100);

            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();

            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();

            $table->string('no_hp', 20)->nullable();
            $table->string('email')->nullable();

            $table->text('alamat')->nullable();

            $table->string('foto')->nullable();

            $table->boolean('aktif')->default(true);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};