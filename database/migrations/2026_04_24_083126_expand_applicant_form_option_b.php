<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── A. Extra columns on applicant_profiles ───────────────────────────
        Schema::table('applicant_profiles', function (Blueprint $table) {
            $table->date('marital_since')->nullable()->after('marital_status');
            $table->text('domisili_address')->nullable()->after('marital_since');
            $table->string('domisili_phone', 30)->nullable()->after('domisili_address');
            $table->string('ktp_phone', 30)->nullable()->after('ktp_issued_place');
            $table->text('desired_facilities')->nullable()->after('expected_salary');
            $table->date('available_start_date')->nullable()->after('desired_facilities');
            $table->boolean('has_company_acquaintances')->default(false)->after('available_start_date');
            $table->text('company_acquaintances')->nullable()->after('has_company_acquaintances');
            $table->text('free_time_activities')->nullable()->after('international_travel');
            $table->text('favorite_reading')->nullable()->after('free_time_activities');
            $table->text('favorite_topics')->nullable()->after('favorite_reading');
            $table->text('permanent_physical_condition')->nullable()->after('past_illness');
            $table->text('family_health_issues')->nullable()->after('permanent_physical_condition');
        });

        // ── Add address_type + phone to addresses table ──────────────────────
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('address_type', 10)->default('domisili')->after('applicant_profile_id');
            $table->string('phone', 30)->nullable()->after('postal_code');
        });

        // ── C. Add place (city) to educations ────────────────────────────────
        Schema::table('educations', function (Blueprint $table) {
            $table->string('place', 100)->nullable()->after('institution');
        });

        // ── D. Add company phone/city/field to work_experiences ──────────────
        Schema::table('work_experiences', function (Blueprint $table) {
            $table->string('company_phone', 30)->nullable()->after('company');
            $table->string('company_city', 100)->nullable()->after('company_phone');
            $table->string('business_field', 100)->nullable()->after('company_city');
        });

        // ── F. Vehicles table ─────────────────────────────────────────────────
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_profile_id')->constrained()->cascadeOnDelete();
            $table->string('brand_type', 100);
            $table->string('cc', 30)->nullable();
            $table->string('year', 10)->nullable();
            $table->enum('ownership', ['Pribadi', 'Orang Tua', 'Saudara'])->default('Pribadi');
            $table->timestamps();
        });

        // ── E. Job type preferences table ────────────────────────────────────
        Schema::create('job_type_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_profile_id')->constrained()->cascadeOnDelete();
            $table->string('job_type', 60);
            $table->unsignedTinyInteger('rank_order');
            $table->timestamps();
        });

        // ── Essay answers (C, D, E sections) ─────────────────────────────────
        Schema::create('applicant_essays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_profile_id')->constrained()->cascadeOnDelete();
            // Section C
            $table->text('why_chose_major')->nullable();
            $table->text('best_education')->nullable();
            $table->text('worst_education')->nullable();
            $table->text('karya_ilmiah')->nullable();
            $table->text('favorite_subject')->nullable();
            $table->text('education_funder')->nullable();
            // Section D (conditional on non-fresh-grad)
            $table->text('brief_job_description')->nullable();
            $table->text('supervisor_detail')->nullable();
            $table->text('subordinate_detail')->nullable();
            $table->text('problems_faced')->nullable();
            $table->text('changes_made')->nullable();
            $table->text('job_satisfaction')->nullable();
            $table->text('changes_motivation')->nullable();
            $table->text('decision_approach')->nullable();
            $table->text('who_you_consult')->nullable();
            // Section D (for everyone)
            $table->text('motivational_driver')->nullable();
            $table->text('decision_making')->nullable();
            // Section E
            $table->text('why_apply_here')->nullable();
            $table->text('company_knowledge')->nullable();
            $table->text('why_2_preferences')->nullable();
            $table->text('plan_for_position')->nullable();
            $table->text('preferred_environment')->nullable();
            $table->text('disliked_environment')->nullable();
            $table->text('preferred_person_type')->nullable();
            $table->text('disliked_person_type')->nullable();
            $table->text('difficult_decisions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applicant_essays');
        Schema::dropIfExists('job_type_preferences');
        Schema::dropIfExists('vehicles');

        Schema::table('work_experiences', function (Blueprint $table) {
            $table->dropColumn(['company_phone', 'company_city', 'business_field']);
        });

        Schema::table('educations', function (Blueprint $table) {
            $table->dropColumn('place');
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn(['address_type', 'phone']);
        });

        Schema::table('applicant_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'marital_since',
                'domisili_address',
                'domisili_phone',
                'ktp_phone',
                'desired_facilities',
                'available_start_date',
                'has_company_acquaintances',
                'company_acquaintances',
                'free_time_activities',
                'favorite_reading',
                'favorite_topics',
                'permanent_physical_condition',
                'family_health_issues',
            ]);
        });
    }
};
