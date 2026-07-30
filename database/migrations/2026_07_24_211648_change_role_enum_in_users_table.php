<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM(
                'admin',
                'guru',
                'ketua_kelas',
                'sekretaris'
            ) NOT NULL DEFAULT 'guru'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM(
                'admin',
                'guru'
            ) NOT NULL DEFAULT 'guru'
        ");
    }
};