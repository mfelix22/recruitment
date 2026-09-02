<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE applicant_profiles MODIFY COLUMN marital_status ENUM('Belum Menikah','Menikah','Cerai Hidup','Cerai Mati') NULL DEFAULT NULL");
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE applicant_profiles MODIFY COLUMN marital_status ENUM('Belum Kawin','Kawin','Cerai') NULL DEFAULT NULL");
    }
};
