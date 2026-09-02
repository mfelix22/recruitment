<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ─── Extra fields on applicant_profiles ───────────────────────────────
        Schema::table('applicant_profiles', function (Blueprint $table) {
            // blood_type, height_cm, weight_kg, nationality already added by partial run
            // place_of_birth already existed in original migration — skip
            $table->string('ktp_issued_place', 100)->nullable()->after('place_of_birth');
            $table->string('sim_no', 50)->nullable()->after('ktp_issued_place');
            $table->string('sim_issued_place', 100)->nullable()->after('sim_no');
            $table->string('house_status', 50)->nullable()->after('sim_issued_place');
            $table->boolean('willing_to_relocate')->default(false)->after('house_status');
            $table->text('other_dependents')->nullable()->after('willing_to_relocate');
            $table->text('hobbies')->nullable()->after('other_dependents');
            $table->text('strengths')->nullable()->after('hobbies');
            $table->text('weaknesses')->nullable()->after('strengths');
            $table->text('past_illness')->nullable()->after('weaknesses');
            $table->text('international_travel')->nullable()->after('past_illness');
            $table->text('organizational_activities')->nullable()->after('international_travel');
            $table->integer('expected_salary')->nullable()->after('organizational_activities');
            $table->string('emergency_contact_name', 100)->nullable()->after('expected_salary');
            $table->string('emergency_contact_phone', 30)->nullable()->after('emergency_contact_name');
            $table->string('emergency_contact_relation', 50)->nullable()->after('emergency_contact_phone');
        });

        // ─── Extra fields on work_experiences ─────────────────────────────────
        Schema::table('work_experiences', function (Blueprint $table) {
            $table->string('salary_total', 100)->nullable()->after('job_description');
            $table->string('facilities', 255)->nullable()->after('salary_total');
            $table->string('supervisor_name', 100)->nullable()->after('facilities');
            $table->unsignedSmallInteger('subordinates_count')->nullable()->after('supervisor_name');
            $table->text('achievement')->nullable()->after('subordinates_count');
            $table->string('reason_for_leaving', 255)->nullable()->after('achievement');
        });

        // ─── Family members ────────────────────────────────────────────────────
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_profile_id')->constrained()->cascadeOnDelete();
            $table->string('family_type', 20); // 'immediate' | 'origin'
            $table->string('relation', 50);    // Istri/Suami, Anak ke 1, Ayah, dll.
            $table->string('name')->nullable();
            $table->string('gender', 1)->nullable(); // L / P
            $table->string('place_of_birth', 100)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('education', 50)->nullable();
            $table->string('occupation', 100)->nullable();
            $table->timestamps();
        });

        // ─── Language skills ───────────────────────────────────────────────────
        Schema::create('language_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_profile_id')->constrained()->cascadeOnDelete();
            $table->string('language', 50);
            $table->string('written_level', 20)->nullable();  // S.Baik/Baik/Cukup/Kurang
            $table->string('spoken_level', 20)->nullable();
            $table->timestamps();
        });

        // ─── Trainings / informal education ───────────────────────────────────
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_profile_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('organizer', 150)->nullable();
            $table->string('place', 100)->nullable();
            $table->string('year', 10)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // ─── References ────────────────────────────────────────────────────────
        Schema::create('applicant_references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_profile_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('work_address', 255)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('position', 100)->nullable();
            $table->string('relation', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applicant_references');
        Schema::dropIfExists('trainings');
        Schema::dropIfExists('language_skills');
        Schema::dropIfExists('family_members');

        Schema::table('work_experiences', function (Blueprint $table) {
            $table->dropColumn(['salary_total', 'facilities', 'supervisor_name', 'subordinates_count', 'achievement', 'reason_for_leaving']);
        });

        Schema::table('applicant_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'blood_type',
                'height_cm',
                'weight_kg',
                'nationality',
                'place_of_birth',
                'ktp_issued_place',
                'sim_no',
                'sim_issued_place',
                'house_status',
                'willing_to_relocate',
                'other_dependents',
                'hobbies',
                'strengths',
                'weaknesses',
                'past_illness',
                'international_travel',
                'organizational_activities',
                'expected_salary',
                'emergency_contact_name',
                'emergency_contact_phone',
                'emergency_contact_relation',
            ]);
        });
    }
};
