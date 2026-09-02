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
        if (\DB::getDriverName() === 'sqlite') {
            return;
        }

        // Change status from the original enum to a plain string to allow flexible status values
        \DB::statement("ALTER TABLE applications MODIFY COLUMN status VARCHAR(50) NOT NULL DEFAULT 'Menunggu'");
    }

    public function down(): void
    {
        if (\DB::getDriverName() === 'sqlite') {
            return;
        }

        \DB::statement("ALTER TABLE applications MODIFY COLUMN status ENUM('Menunggu','Sedang Ditinjau','Diterima','Tidak Diterima') NOT NULL DEFAULT 'Menunggu'");
    }
};
