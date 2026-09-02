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
        Schema::table('applicant_profiles', function (Blueprint $table) {
            $table->string('blood_type', 5)->nullable()->after('marital_status');
            $table->unsignedSmallInteger('height_cm')->nullable()->after('blood_type');
            $table->unsignedSmallInteger('weight_kg')->nullable()->after('height_cm');
            $table->string('nationality', 50)->nullable()->after('weight_kg');
        });
    }

    public function down(): void
    {
        Schema::table('applicant_profiles', function (Blueprint $table) {
            $table->dropColumn(['blood_type', 'height_cm', 'weight_kg', 'nationality']);
        });
    }
};
