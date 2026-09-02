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
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_profile_id')->constrained()->onDelete('cascade');
            $table->string('company')->comment('Nama perusahaan');
            $table->string('position')->comment('Jabatan atau posisi');
            $table->date('start_date')->comment('Tanggal mulai bekerja');
            $table->date('end_date')->nullable()->comment('Tanggal selesai bekerja');
            $table->boolean('still_working')->default(false)->comment('Masih bekerja di sini');
            $table->text('job_description')->nullable()->comment('Deskripsi pekerjaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experiences');
    }
};
