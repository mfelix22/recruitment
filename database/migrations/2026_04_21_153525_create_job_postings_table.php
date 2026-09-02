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
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('users')->onDelete('cascade');
            $table->string('title')->comment('Nama jabatan atau posisi');
            $table->string('department')->nullable()->comment('Departemen');
            $table->text('job_description')->comment('Deskripsi jabatan');
            $table->text('requirements')->nullable()->comment('Persyaratan');
            $table->enum('min_education', ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'])
                ->nullable()->comment('Pendidikan minimum');
            $table->integer('open_positions')->default(1)->comment('Jumlah posisi tersedia');
            $table->date('deadline')->nullable()->comment('Batas waktu pendaftaran');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
