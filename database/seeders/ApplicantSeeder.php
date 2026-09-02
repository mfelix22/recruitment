<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ApplicantSeeder extends Seeder
{
    public function run(): void
    {
        $applicants = [
            [
                'name'  => 'Budi Santoso',
                'email' => 'budi@example.com',
                'profile' => [
                    'nik'                        => '3201010101010001',
                    'phone'                      => '081234567890',
                    'place_of_birth'             => 'Jakarta',
                    'date_of_birth'              => '1995-03-15',
                    'gender'                     => 'Laki-laki',
                    'religion'                   => 'Islam',
                    'marital_status'             => 'Belum Menikah',
                    'blood_type'                 => 'A',
                    'height_cm'                  => 172,
                    'weight_kg'                  => 68,
                    'nationality'                => 'Indonesia',
                    'house_status'               => 'Kos',
                    'willing_to_relocate'        => true,
                    'emergency_contact_name'     => 'Siti Santoso',
                    'emergency_contact_phone'    => '082199990001',
                    'emergency_contact_relation' => 'Ibu',
                    'hobbies'                    => 'Membaca, olahraga',
                    'strengths'                  => 'Cepat belajar, komunikatif',
                    'weaknesses'                 => 'Kurang sabar',
                ],
                'address' => [
                    'street'      => 'Jl. Merdeka No. 10',
                    'rt_rw'       => '003/005',
                    'kelurahan'   => 'Gambir',
                    'kecamatan'   => 'Gambir',
                    'kabupaten'   => 'Jakarta Pusat',
                    'province'    => 'DKI Jakarta',
                    'postal_code' => '10110',
                ],
                'educations' => [
                    [
                        'level' => 'S1',
                        'institution' => 'Universitas Indonesia',
                        'major' => 'Teknik Informatika',
                        'year_start' => 2013,
                        'year_end' => 2017,
                        'gpa' => 3.52,
                        'still_studying' => false,
                    ],
                    [
                        'level' => 'SMA/SMK',
                        'institution' => 'SMAN 1 Jakarta',
                        'major' => 'IPA',
                        'year_start' => 2010,
                        'year_end' => 2013,
                        'gpa' => null,
                        'still_studying' => false,
                    ],
                ],
                'work_experiences' => [
                    [
                        'company' => 'PT Teknologi Maju',
                        'position' => 'Junior Developer',
                        'start_date' => '2017-08-01',
                        'end_date' => '2020-12-31',
                        'still_working' => false,
                        'job_description' => 'Mengembangkan aplikasi web menggunakan Laravel dan Vue.js',
                        'reason_for_leaving' => 'Mencari peluang yang lebih baik',
                    ],
                    [
                        'company' => 'PT Digital Solusi',
                        'position' => 'Backend Developer',
                        'start_date' => '2021-01-15',
                        'end_date' => null,
                        'still_working' => true,
                        'job_description' => 'Pengembangan API dan sistem backend',
                        'reason_for_leaving' => null,
                    ],
                ],
                'languages' => [
                    ['language' => 'Indonesia', 'written_level' => 'Sangat Baik', 'spoken_level' => 'Sangat Baik'],
                    ['language' => 'Inggris',   'written_level' => 'Baik',        'spoken_level' => 'Cukup'],
                ],
            ],
            [
                'name'  => 'Dewi Rahayu',
                'email' => 'dewi@example.com',
                'profile' => [
                    'nik'                        => '3201010202020002',
                    'phone'                      => '085678901234',
                    'place_of_birth'             => 'Bandung',
                    'date_of_birth'              => '1997-07-22',
                    'gender'                     => 'Perempuan',
                    'religion'                   => 'Kristen Protestan',
                    'marital_status'             => 'Belum Menikah',
                    'blood_type'                 => 'B',
                    'height_cm'                  => 160,
                    'weight_kg'                  => 52,
                    'nationality'                => 'Indonesia',
                    'house_status'               => 'Orang Tua',
                    'willing_to_relocate'        => false,
                    'emergency_contact_name'     => 'Pak Rahayu',
                    'emergency_contact_phone'    => '082199990002',
                    'emergency_contact_relation' => 'Ayah',
                    'hobbies'                    => 'Desain grafis, fotografi',
                    'strengths'                  => 'Kreatif, detail',
                    'weaknesses'                 => 'Perfeksionis',
                ],
                'address' => [
                    'street' => 'Jl. Dago No. 45',
                    'rt_rw' => '002/003',
                    'kelurahan' => 'Coblong',
                    'kecamatan' => 'Coblong',
                    'kabupaten' => 'Bandung',
                    'province' => 'Jawa Barat',
                    'postal_code' => '40135',
                ],
                'educations' => [
                    [
                        'level' => 'S1',
                        'institution' => 'Institut Teknologi Bandung',
                        'major' => 'Desain Komunikasi Visual',
                        'year_start' => 2015,
                        'year_end' => 2019,
                        'gpa' => 3.75,
                        'still_studying' => false,
                    ],
                ],
                'work_experiences' => [
                    [
                        'company' => 'Agensi Kreatif Nusantara',
                        'position' => 'Graphic Designer',
                        'start_date' => '2019-07-01',
                        'end_date' => '2022-06-30',
                        'still_working' => false,
                        'job_description' => 'Membuat materi visual untuk brand klien',
                        'reason_for_leaving' => 'Ingin berkembang di bidang UI/UX',
                    ],
                ],
                'languages' => [
                    ['language' => 'Indonesia', 'written_level' => 'Sangat Baik', 'spoken_level' => 'Sangat Baik'],
                    ['language' => 'Inggris',   'written_level' => 'Cukup',       'spoken_level' => 'Cukup'],
                ],
            ],
            [
                'name'  => 'Andi Wijaya',
                'email' => 'andi@example.com',
                'profile' => [
                    'nik'                        => '3201010303030003',
                    'phone'                      => '087812345678',
                    'place_of_birth'             => 'Surabaya',
                    'date_of_birth'              => '1993-11-05',
                    'gender'                     => 'Laki-laki',
                    'religion'                   => 'Islam',
                    'marital_status'             => 'Menikah',
                    'blood_type'                 => 'O',
                    'height_cm'                  => 175,
                    'weight_kg'                  => 75,
                    'nationality'                => 'Indonesia',
                    'house_status'               => 'Milik Sendiri',
                    'willing_to_relocate'        => true,
                    'emergency_contact_name'     => 'Sari Wijaya',
                    'emergency_contact_phone'    => '082199990003',
                    'emergency_contact_relation' => 'Istri',
                    'hobbies'                    => 'Sepak bola, travelling',
                    'strengths'                  => 'Kepemimpinan, analitis',
                    'weaknesses'                 => 'Terlalu kritis',
                ],
                'address' => [
                    'street' => 'Jl. Pemuda No. 78',
                    'rt_rw' => '001/002',
                    'kelurahan' => 'Gubeng',
                    'kecamatan' => 'Gubeng',
                    'kabupaten' => 'Surabaya',
                    'province' => 'Jawa Timur',
                    'postal_code' => '60281',
                ],
                'educations' => [
                    [
                        'level' => 'S1',
                        'institution' => 'Universitas Airlangga',
                        'major' => 'Manajemen',
                        'year_start' => 2011,
                        'year_end' => 2015,
                        'gpa' => 3.40,
                        'still_studying' => false,
                    ],
                ],
                'work_experiences' => [
                    [
                        'company' => 'PT Mitra Jaya Abadi',
                        'position' => 'Sales Supervisor',
                        'start_date' => '2015-09-01',
                        'end_date' => '2019-08-31',
                        'still_working' => false,
                        'job_description' => 'Mengelola tim penjualan wilayah Jawa Timur',
                        'reason_for_leaving' => 'Pindah kota',
                    ],
                    [
                        'company' => 'PT Sumber Makmur',
                        'position' => 'Area Manager',
                        'start_date' => '2019-10-01',
                        'end_date' => null,
                        'still_working' => true,
                        'job_description' => 'Mengawasi operasional 3 cabang di wilayah Jawa Timur',
                        'reason_for_leaving' => null,
                    ],
                ],
                'languages' => [
                    ['language' => 'Indonesia', 'written_level' => 'Sangat Baik', 'spoken_level' => 'Sangat Baik'],
                    ['language' => 'Inggris',   'written_level' => 'Baik',        'spoken_level' => 'Baik'],
                ],
            ],
            [
                'name'  => 'Siti Nuraini',
                'email' => 'siti@example.com',
                'profile' => [
                    'nik'                        => '3201010404040004',
                    'phone'                      => '089934567890',
                    'place_of_birth'             => 'Yogyakarta',
                    'date_of_birth'              => '1996-02-14',
                    'gender'                     => 'Perempuan',
                    'religion'                   => 'Islam',
                    'marital_status'             => 'Belum Menikah',
                    'blood_type'                 => 'AB',
                    'height_cm'                  => 158,
                    'weight_kg'                  => 49,
                    'nationality'                => 'Indonesia',
                    'house_status'               => 'Kos',
                    'willing_to_relocate'        => true,
                    'emergency_contact_name'     => 'Hj. Aminah',
                    'emergency_contact_phone'    => '082199990004',
                    'emergency_contact_relation' => 'Ibu',
                    'hobbies'                    => 'Memasak, membaca novel',
                    'strengths'                  => 'Teliti, sabar, kerja keras',
                    'weaknesses'                 => 'Pemalu',
                ],
                'address' => [
                    'street' => 'Jl. Malioboro No. 22',
                    'rt_rw' => '004/006',
                    'kelurahan' => 'Sosromenduran',
                    'kecamatan' => 'Gedongtengen',
                    'kabupaten' => 'Yogyakarta',
                    'province' => 'DI Yogyakarta',
                    'postal_code' => '55271',
                ],
                'educations' => [
                    [
                        'level' => 'D3',
                        'institution' => 'Politeknik Negeri Yogyakarta',
                        'major' => 'Akuntansi',
                        'year_start' => 2014,
                        'year_end' => 2017,
                        'gpa' => 3.65,
                        'still_studying' => false,
                    ],
                ],
                'work_experiences' => [
                    [
                        'company' => 'KAP Budi & Rekan',
                        'position' => 'Staff Akuntansi',
                        'start_date' => '2017-06-01',
                        'end_date' => '2023-05-31',
                        'still_working' => false,
                        'job_description' => 'Menyusun laporan keuangan dan rekonsiliasi bank',
                        'reason_for_leaving' => 'Ingin pengalaman di industri yang lebih besar',
                    ],
                ],
                'languages' => [
                    ['language' => 'Indonesia', 'written_level' => 'Sangat Baik', 'spoken_level' => 'Sangat Baik'],
                    ['language' => 'Inggris',   'written_level' => 'Cukup',       'spoken_level' => 'Kurang'],
                ],
            ],
            [
                'name'  => 'Reza Firmansyah',
                'email' => 'reza@example.com',
                'profile' => [
                    'nik'                        => '3201010505050005',
                    'phone'                      => '081398765432',
                    'place_of_birth'             => 'Medan',
                    'date_of_birth'              => '1994-09-30',
                    'gender'                     => 'Laki-laki',
                    'religion'                   => 'Islam',
                    'marital_status'             => 'Belum Menikah',
                    'blood_type'                 => 'A',
                    'height_cm'                  => 170,
                    'weight_kg'                  => 65,
                    'nationality'                => 'Indonesia',
                    'house_status'               => 'Kontrak',
                    'willing_to_relocate'        => true,
                    'emergency_contact_name'     => 'H. Firmansyah',
                    'emergency_contact_phone'    => '082199990005',
                    'emergency_contact_relation' => 'Ayah',
                    'hobbies'                    => 'Gaming, coding, hiking',
                    'strengths'                  => 'Problem solving, adaptif',
                    'weaknesses'                 => 'Sulit menolak permintaan',
                ],
                'address' => [
                    'street' => 'Jl. Gatot Subroto No. 99',
                    'rt_rw' => '002/004',
                    'kelurahan' => 'Helvetia',
                    'kecamatan' => 'Medan Helvetia',
                    'kabupaten' => 'Medan',
                    'province' => 'Sumatera Utara',
                    'postal_code' => '20124',
                ],
                'educations' => [
                    [
                        'level' => 'S1',
                        'institution' => 'Universitas Sumatera Utara',
                        'major' => 'Teknik Elektro',
                        'year_start' => 2012,
                        'year_end' => 2016,
                        'gpa' => 3.30,
                        'still_studying' => false,
                    ],
                    [
                        'level' => 'SMA/SMK',
                        'institution' => 'SMAN 2 Medan',
                        'major' => 'IPA',
                        'year_start' => 2009,
                        'year_end' => 2012,
                        'gpa' => null,
                        'still_studying' => false,
                    ],
                ],
                'work_experiences' => [
                    [
                        'company' => 'PT Energi Nusantara',
                        'position' => 'Electrical Engineer',
                        'start_date' => '2016-10-01',
                        'end_date' => '2021-09-30',
                        'still_working' => false,
                        'job_description' => 'Perencanaan dan pengawasan instalasi listrik industri',
                        'reason_for_leaving' => 'Pindah ke sektor swasta',
                    ],
                    [
                        'company' => 'PT Hartono Elektronik',
                        'position' => 'Senior Electrical Engineer',
                        'start_date' => '2021-11-01',
                        'end_date' => null,
                        'still_working' => true,
                        'job_description' => 'Memimpin proyek instalasi dan pemeliharaan sistem kelistrikan',
                        'reason_for_leaving' => null,
                    ],
                ],
                'languages' => [
                    ['language' => 'Indonesia', 'written_level' => 'Sangat Baik', 'spoken_level' => 'Sangat Baik'],
                    ['language' => 'Inggris',   'written_level' => 'Baik',        'spoken_level' => 'Baik'],
                    ['language' => 'Mandarin',  'written_level' => 'Kurang',      'spoken_level' => 'Kurang'],
                ],
            ],
        ];

        foreach ($applicants as $data) {
            if (User::where('email', $data['email'])->exists()) {
                continue;
            }

            $user = User::create([
                'name'              => $data['name'],
                'email'             => $data['email'],
                'password'          => Hash::make('password'),
                'role'              => 'applicant',
                'email_verified_at' => now(),
            ]);

            $profile = $user->applicantProfile()->create($data['profile']);

            $profile->address()->create($data['address']);

            foreach ($data['educations'] as $edu) {
                $profile->educations()->create($edu);
            }

            foreach ($data['work_experiences'] as $work) {
                $profile->workExperiences()->create($work);
            }

            foreach ($data['languages'] as $lang) {
                $profile->languageSkills()->create($lang);
            }
        }
    }
}
