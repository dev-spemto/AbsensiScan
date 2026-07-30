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
        Schema::table('presensis', function (Blueprint $table) {

            $table->foreignId('scanner_id')
                ->nullable()
                ->after('guru_id')
                ->constrained('users')
                ->nullOnDelete();

            $table->enum('scan_by', [
                'admin',
                'guru',
                'ketua_kelas',
                'sekretaris'
            ])->nullable()->after('metode');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensis', function (Blueprint $table) {

            $table->dropForeign(['scanner_id']);
            $table->dropColumn('scanner_id');

            $table->dropColumn('scan_by');

        });
    }
};