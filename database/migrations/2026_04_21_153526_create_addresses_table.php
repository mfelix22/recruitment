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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_profile_id')->constrained()->onDelete('cascade');
            $table->string('street')->comment('Nama jalan / Alamat lengkap');
            $table->string('rt_rw', 10)->nullable()->comment('RT/RW');
            $table->string('kelurahan')->nullable()->comment('Kelurahan atau Desa');
            $table->string('kecamatan')->nullable()->comment('Kecamatan');
            $table->string('kabupaten')->comment('Kabupaten atau Kota');
            $table->string('province')->comment('Provinsi');
            $table->string('postal_code', 10)->nullable()->comment('Kode Pos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
