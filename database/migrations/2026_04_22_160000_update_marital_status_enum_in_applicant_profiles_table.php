<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE applicant_profiles MODIFY COLUMN marital_status ENUM('Belum Menikah','Menikah','Cerai Hidup','Cerai Mati') NULL DEFAULT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE applicant_profiles MODIFY COLUMN marital_status ENUM('Belum Kawin','Kawin','Cerai') NULL DEFAULT NULL");
    }
};
