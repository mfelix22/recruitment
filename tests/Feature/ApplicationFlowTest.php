<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\ApplicantProfile;
use App\Models\Application;
use App\Models\Education;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApplicationFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function createApplicant(array $overrides = []): User
    {
        $user = User::factory()->create(array_merge(['role' => 'applicant'], $overrides));

        $profile = ApplicantProfile::create([
            'user_id' => $user->id,
            'nik' => fake()->numerify('################'),
            'phone' => fake()->phoneNumber(),
            'place_of_birth' => fake()->city(),
            'date_of_birth' => now()->subYears(25)->toDateString(),
            'gender' => 'Laki-laki',
            'religion' => 'Islam',
            'blood_type' => 'O',
            'height_cm' => 170,
            'weight_kg' => 65,
            'nationality' => 'WNI',
            'emergency_contact_name' => fake()->name(),
            'emergency_contact_phone' => fake()->phoneNumber(),
            'emergency_contact_relation' => 'Orang Tua',
        ]);

        Address::create([
            'applicant_profile_id' => $profile->id,
            'address_type' => 'ktp',
            'street' => fake()->streetAddress(),
            'kabupaten' => fake()->city(),
            'province' => 'DKI Jakarta',
        ]);

        Education::create([
            'applicant_profile_id' => $profile->id,
            'level' => 'S1',
            'institution' => fake()->company() . ' University',
            'year_start' => 2015,
        ]);

        return $user;
    }

    protected function createJob(User $employer, array $overrides = []): JobPosting
    {
        return JobPosting::create(array_merge([
            'employer_id' => $employer->id,
            'title' => fake()->jobTitle(),
            'position' => fake()->jobTitle(),
            'department' => 'IT',
            'job_description' => fake()->paragraph(),
            'employment_type' => 'Full Time',
            'open_positions' => 1,
            'is_active' => true,
        ], $overrides));
    }

    public function test_applicant_can_apply_to_a_job_with_complete_profile(): void
    {
        $applicant = $this->createApplicant();
        $employer = User::factory()->create(['role' => 'employer']);
        $job = $this->createJob($employer);

        $response = $this->actingAs($applicant)
            ->post(route('applicant.apply', $job), [
                'cover_letter' => 'Saya sangat tertarik dengan posisi ini.',
            ]);

        $response->assertRedirect(route('applicant.applications.index'));
        $this->assertDatabaseHas('applications', [
            'applicant_id' => $applicant->id,
            'job_posting_id' => $job->id,
            'status' => 'Menunggu',
        ]);
    }

    public function test_applicant_cannot_view_another_applicants_application(): void
    {
        $applicantOne = $this->createApplicant();
        $applicantTwo = $this->createApplicant();
        $employer = User::factory()->create(['role' => 'employer']);
        $job = $this->createJob($employer);

        $application = Application::create([
            'applicant_id' => $applicantTwo->id,
            'job_posting_id' => $job->id,
            'status' => 'Menunggu',
        ]);

        $response = $this->actingAs($applicantOne)
            ->get(route('applicant.applications.show', $application));

        $response->assertStatus(403);
    }

    public function test_employer_can_update_application_status(): void
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $applicant = $this->createApplicant();
        $job = $this->createJob($employer);

        $application = Application::create([
            'applicant_id' => $applicant->id,
            'job_posting_id' => $job->id,
            'status' => 'Menunggu',
        ]);

        $response = $this->actingAs($employer)
            ->patch(route('employer.applications.status', $application), [
                'status' => 'Sedang Ditinjau',
            ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('applications', [
            'id' => $application->id,
            'status' => 'Sedang Ditinjau',
        ]);
    }

    public function test_employer_cannot_update_other_employers_application(): void
    {
        $employerA = User::factory()->create(['role' => 'employer']);
        $employerB = User::factory()->create(['role' => 'employer']);
        $applicant = $this->createApplicant();

        $job = $this->createJob($employerA);
        $application = Application::create([
            'applicant_id' => $applicant->id,
            'job_posting_id' => $job->id,
            'status' => 'Menunggu',
        ]);

        $response = $this->actingAs($employerB)
            ->patch(route('employer.applications.status', $application), [
                'status' => 'Sedang Ditinjau',
            ]);

        $response->assertStatus(403);
    }

    public function test_employer_can_download_applicant_pdf(): void
    {
        Storage::fake('public');

        $employer = User::factory()->create(['role' => 'employer']);
        $applicant = $this->createApplicant();
        $job = $this->createJob($employer);

        $application = Application::create([
            'applicant_id' => $applicant->id,
            'job_posting_id' => $job->id,
            'status' => 'Menunggu',
        ]);

        $response = $this->actingAs($employer)
            ->get(route('employer.applications.pdf', $application));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }
}
