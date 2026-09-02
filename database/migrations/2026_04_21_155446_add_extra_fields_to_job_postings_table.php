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
        Schema::table('job_postings', function (Blueprint $table) {
            $table->string('position')->nullable()->after('title')->comment('Posisi spesifik');
            $table->string('location')->nullable()->after('department')->comment('Lokasi kerja');
            $table->enum('experience_level', ['Fresh Graduate', 'Junior', 'Mid', 'Senior', 'Manajer'])
                ->nullable()->after('location')->comment('Tingkat pengalaman');
            $table->string('experience_years')->nullable()->after('experience_level')
                ->comment('Contoh: 1-2 tahun');
            $table->enum('employment_type', ['Full Time', 'Part Time', 'Kontrak', 'Magang', 'Freelance'])
                ->default('Full Time')->after('experience_years')->comment('Jenis pekerjaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_postings', function (Blueprint $table) {
            $table->dropColumn([
                'position',
                'location',
                'experience_level',
                'experience_years',
                'employment_type',
            ]);
        });
    }
};
