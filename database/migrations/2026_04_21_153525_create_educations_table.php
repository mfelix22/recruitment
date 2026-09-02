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
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_profile_id')->constrained()->onDelete('cascade');
            $table->enum('level', ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'])
                ->comment('Jenjang pendidikan');
            $table->string('institution')->comment('Nama sekolah / universitas');
            $table->string('major')->nullable()->comment('Jurusan atau program studi');
            $table->decimal('gpa', 4, 2)->nullable()->comment('IPK atau nilai akhir');
            $table->year('year_start')->comment('Tahun masuk');
            $table->year('year_end')->nullable()->comment('Tahun lulus');
            $table->boolean('still_studying')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
