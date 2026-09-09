<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CompleteApplicantSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'lengkap@example.com';

        if (User::where('email', $email)->exists()) {
            return;
        }

        $user = User::create([
            'name'              => 'Ahmad Lengkap',
            'email'             => $email,
            'password'          => Hash::make('password'),
            'role'              => 'applicant',
            'email_verified_at' => now(),
        ]);

        $profile = $user->applicantProfile()->create([
            'desired_position'            => 'Staff Administrasi',
            'nik'                         => '3201010606060006',
            'phone'                       => '081312345678',
            'place_of_birth'              => 'Semarang',
            'date_of_birth'               => '1995-05-20',
            'gender'                      => 'Laki-laki',
            'religion'                    => 'Islam',
            'marital_status'              => 'Belum Menikah',
            'blood_type'                  => 'A',
            'height_cm'                   => 170,
            'weight_kg'                   => 65,
            'nationality'                 => 'Indonesia',
            'ktp_issued_place'            => 'Semarang',
            'sim_no'                      => '1234567890',
            'sim_issued_place'            => 'Semarang',
            'domisili_address'            => 'Jl. Setiabudi No. 45, Semarang',
            'domisili_phone'              => '081398765432',
            'ktp_phone'                   => '0241234567',
            'house_status'                => 'Kos',
            'willing_to_relocate'         => true,
            'other_dependents'            => 'Tidak ada',
            'expected_salary'             => 5000000,
            'desired_facilities'          => 'Asuransi, tunjangan transportasi',
            'available_start_date'        => now()->addMonth()->toDateString(),
            'has_company_acquaintances'   => true,
            'company_acquaintances'       => 'Bapak Hartono',
            'company_preferences'         => ['PT. Hartono Raya Motor', 'Semarang'],
            'hobbies'                     => 'Membaca, olahraga, musik',
            'free_time_activities'        => 'Bermain gitar dan bersepeda',
            'favorite_reading'            => 'Buku bisnis dan teknologi',
            'favorite_topics'             => 'Otomotif, pengembangan diri',
            'international_travel'        => 'Belum pernah ke luar negeri',
            'organizational_activities'   => 'Pernah aktif di UKM kampus',
            'strengths'                   => 'Cepat belajar, teliti, komunikatif',
            'weaknesses'                  => 'Terlalu detail kadang memakan waktu',
            'past_illness'                => 'Tidak ada',
            'permanent_physical_condition' => 'Tidak ada',
            'family_health_issues'        => 'Tidak ada',
            'emergency_contact_name'      => 'Ibu Sri Lestari',
            'emergency_contact_phone'     => '081298765432',
            'emergency_contact_relation'  => 'Ibu',
        ]);

        $profile->addresses()->create([
            'address_type' => 'ktp',
            'street'       => 'Jl. Pemuda No. 123',
            'rt_rw'        => '001/002',
            'kelurahan'    => 'Pandanaran',
            'kecamatan'    => 'Semarang Tengah',
            'kabupaten'    => 'Semarang',
            'province'     => 'Jawa Tengah',
            'postal_code'  => '50138',
            'phone'        => '0247654321',
        ]);

        $profile->educations()->createMany([
            [
                'level'          => 'S1',
                'institution'    => 'Universitas Diponegoro',
                'major'          => 'Manajemen',
                'year_start'     => 2013,
                'year_end'       => 2017,
                'gpa'            => 3.55,
                'still_studying' => false,
            ],
            [
                'level'          => 'SMA/SMK',
                'institution'    => 'SMA Negeri 1 Semarang',
                'major'          => 'IPA',
                'year_start'     => 2010,
                'year_end'       => 2013,
                'gpa'            => null,
                'still_studying' => false,
            ],
        ]);

        $profile->workExperiences()->createMany([
            [
                'company'            => 'PT Maju Bersama',
                'company_phone'      => '0245551234',
                'company_city'       => 'Semarang',
                'business_field'     => 'Distribusi',
                'position'           => 'Staff Administrasi',
                'start_date'         => '2018-01-15',
                'end_date'           => '2022-12-31',
                'still_working'      => false,
                'job_description'    => 'Mengelola dokumen dan administrasi harian',
                'salary_total'       => 4500000,
                'facilities'         => 'BPJS, thr, bonus',
                'supervisor_name'    => 'Pak Joko',
                'subordinates_count' => 0,
                'achievement'        => 'Mengurangi backlog administrasi 30%',
                'reason_for_leaving' => 'Mencari tantangan baru',
            ],
        ]);

        $profile->immediateFamilyMembers()->createMany([
            [
                'family_type'    => 'immediate',
                'relation'       => 'Istri',
                'name'           => '-',
                'gender'         => 'Perempuan',
                'place_of_birth' => '-',
                'date_of_birth'  => null,
                'education'      => '-',
                'occupation'     => '-',
            ],
            [
                'family_type'    => 'immediate',
                'relation'       => 'Anak',
                'name'           => '-',
                'gender'         => 'Laki-laki',
                'place_of_birth' => '-',
                'date_of_birth'  => null,
                'education'      => '-',
                'occupation'     => '-',
            ],
        ]);

        $profile->originFamilyMembers()->createMany([
            [
                'family_type'    => 'origin',
                'relation'       => 'Ayah',
                'name'           => 'Budi Santoso',
                'gender'         => 'Laki-laki',
                'place_of_birth' => 'Semarang',
                'date_of_birth'  => '1965-04-10',
                'education'      => 'SMA',
                'occupation'     => 'Pensiunan',
            ],
            [
                'family_type'    => 'origin',
                'relation'       => 'Ibu',
                'name'           => 'Sri Lestari',
                'gender'         => 'Perempuan',
                'place_of_birth' => 'Semarang',
                'date_of_birth'  => '1968-08-15',
                'education'      => 'SMA',
                'occupation'     => 'Ibu Rumah Tangga',
            ],
            [
                'family_type'    => 'origin',
                'relation'       => 'Saudara',
                'name'           => 'Dewi Lestari',
                'gender'         => 'Perempuan',
                'place_of_birth' => 'Semarang',
                'date_of_birth'  => '1998-02-28',
                'education'      => 'S1',
                'occupation'     => 'Mahasiswa',
            ],
        ]);

        $profile->languageSkills()->createMany([
            [
                'language'      => 'Indonesia',
                'written_level' => 'S. Baik',
                'spoken_level'  => 'S. Baik',
            ],
            [
                'language'      => 'Inggris',
                'written_level' => 'Baik',
                'spoken_level'  => 'Cukup',
            ],
        ]);

        $profile->trainings()->createMany([
            [
                'name'       => 'Pelatihan Manajemen Waktu',
                'organizer'  => 'Lembaga Pelatihan A',
                'place'      => 'Semarang',
                'year'       => 2020,
                'notes'      => 'Dibiayai perusahaan',
                'sort_order' => 1,
            ],
            [
                'name'       => 'Kursus Microsoft Excel Advanced',
                'organizer'  => 'Lembaga Komputer B',
                'place'      => 'Semarang',
                'year'       => 2019,
                'notes'      => 'Dibiayai sendiri',
                'sort_order' => 2,
            ],
        ]);

        $profile->references()->createMany([
            [
                'name'         => 'Pak Joko Widodo',
                'work_address' => 'PT Maju Bersama, Semarang',
                'phone'        => '0245551234',
                'position'     => 'Manager Operasional',
                'relation'     => 'Mantan atasan',
            ],
            [
                'name'         => 'Bu Rina Sari',
                'work_address' => 'Universitas Diponegoro',
                'phone'        => '0245555678',
                'position'     => 'Dosen',
                'relation'     => 'Dosen pembimbing',
            ],
        ]);

        $profile->vehicles()->createMany([
            [
                'brand_type' => 'Honda Beat 110',
                'cc'         => '110',
                'year'       => 2019,
                'ownership'  => 'Milik sendiri',
            ],
        ]);

        $profile->jobTypePreferences()->createMany([
            ['job_type' => 'Administrasi', 'rank_order' => 1],
            ['job_type' => 'Finance', 'rank_order' => 2],
            ['job_type' => 'Marketing', 'rank_order' => 3],
        ]);

        $profile->essay()->create([
            'why_chose_major'        => 'Karena tertarik dengan dunia bisnis dan manajemen.',
            'best_education'         => 'S1 karena banyak belajar praktik dan organisasi.',
            'worst_education'        => 'SMA karena kurang fokus pada pengembangan karakter.',
            'karya_ilmiah'           => 'Skripsi tentang pengaruh motivasi kerja karyawan.',
            'favorite_subject'       => 'Manajemen Sumber Daya Manusia, nilai A.',
            'education_funder'       => 'Orang tua.',
            'brief_job_description'  => 'Administrasi dokumen dan data karyawan.',
            'supervisor_detail'      => 'Pak Joko, Manager Operasional.',
            'subordinate_detail'     => 'Tidak memiliki bawahan.',
            'problems_faced'         => 'Sering deadline ketat, diselesaikan dengan manajemen waktu.',
            'changes_made'           => 'Mengusulkan digitalisasi arsip sehingga pencarian lebih cepat.',
            'job_satisfaction'         => 'Puas karena banyak belajar.',
            'changes_motivation'     => 'Keinginan untuk berkembang.',
            'decision_approach'      => 'Analisis data dan diskusi dengan tim.',
            'who_you_consult'        => 'Atasan dan rekan kerja.',
            'motivational_driver'    => 'Orang tua dan keinginan mandiri.',
            'decision_making'        => 'Mengumpulkan fakta, lalu memutuskan dengan cepat.',
            'why_apply_here'         => 'Perusahaan besar dan berkembang, cocok dengan skill saya.',
            'company_knowledge'      => 'Perusahaan otomotif yang memiliki banyak cabang.',
            'why_2_preferences'      => 'Administrasi dan Finance sesuai latar belakang pendidikan.',
            'plan_for_position'      => 'Bekerja keras, belajar proses, dan berkontribusi.',
            'preferred_environment'  => 'Kantor karena lebih fokus dan terstruktur.',
            'disliked_environment'   => 'Lingkungan yang tidak komunikatif.',
            'preferred_person_type'  => 'Orang yang jujur dan suka bekerja sama.',
            'disliked_person_type'   => 'Orang yang suka menyalahkan orang lain.',
            'difficult_decisions'    => 'Memutuskan untuk resign karena sudah tidak berkembang.',
        ]);
    }
}
