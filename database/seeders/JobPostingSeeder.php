<?php

namespace Database\Seeders;

use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobPostingSeeder extends Seeder
{
    public function run(): void
    {
        $employer = User::where('role', 'employer')->first();

        if (! $employer) {
            $this->command->warn('No employer user found. Run UserSeeder first.');
            return;
        }

        $jobs = [
            [
                'title'            => 'Staff Akuntansi',
                'position'         => 'Staf',
                'department'       => 'Keuangan & Akuntansi',
                'location'         => 'Semarang',
                'experience_level' => 'Junior',
                'experience_years' => '1-2 tahun',
                'employment_type'  => 'Full Time',
                'min_education'    => 'D3',
                'open_positions'   => 2,
                'deadline'         => now()->addDays(30)->toDateString(),
                'is_active'        => true,
                'job_description'  => "Bertanggung jawab atas pencatatan transaksi keuangan harian, rekonsiliasi bank, dan penyusunan laporan keuangan bulanan. Berkoordinasi dengan tim keuangan untuk memastikan akurasi data.",
                'requirements'     => "- Pendidikan minimal D3 Akuntansi / Keuangan\n- Pengalaman minimal 1 tahun di bidang akuntansi\n- Menguasai Microsoft Excel dan software akuntansi (SAP/Accurate)\n- Teliti, jujur, dan mampu bekerja di bawah tekanan\n- Bersedia ditempatkan di Semarang",
            ],
            [
                'title'            => 'Teknisi Listrik',
                'position'         => 'Teknisi',
                'department'       => 'Teknik & Pemeliharaan',
                'location'         => 'Solo',
                'experience_level' => 'Mid',
                'experience_years' => '2-4 tahun',
                'employment_type'  => 'Full Time',
                'min_education'    => 'SMA/SMK',
                'open_positions'   => 3,
                'deadline'         => now()->addDays(21)->toDateString(),
                'is_active'        => true,
                'job_description'  => "Melakukan pemasangan, pemeliharaan, dan perbaikan instalasi listrik di fasilitas produksi. Memastikan semua instalasi sesuai standar keselamatan yang berlaku.",
                'requirements'     => "- Pendidikan SMK Teknik Elektro atau sederajat\n- Memiliki sertifikat kompetensi kelistrikan (nilai lebih)\n- Pengalaman minimal 2 tahun sebagai teknisi listrik industri\n- Bersedia bekerja shift\n- Bersedia ditempatkan di Solo",
            ],
            [
                'title'            => 'Marketing Executive',
                'position'         => 'Executive',
                'department'       => 'Marketing & Sales',
                'location'         => 'Jakarta',
                'experience_level' => 'Junior',
                'experience_years' => '1-3 tahun',
                'employment_type'  => 'Full Time',
                'min_education'    => 'S1',
                'open_positions'   => 2,
                'deadline'         => now()->addDays(28)->toDateString(),
                'is_active'        => true,
                'job_description'  => "Mengembangkan strategi pemasaran untuk produk elektronik konsumen. Mengelola hubungan dengan distributor dan pelanggan korporat. Menyusun laporan penjualan dan analisis pasar.",
                'requirements'     => "- Pendidikan S1 Marketing / Manajemen / Bisnis\n- Pengalaman 1-3 tahun di bidang marketing / sales\n- Komunikatif, proaktif, dan berorientasi target\n- Memiliki kemampuan presentasi yang baik\n- Bersedia melakukan perjalanan dinas",
            ],
            [
                'title'            => 'Staff IT Support',
                'position'         => 'Staf',
                'department'       => 'Teknologi Informasi',
                'location'         => 'Semarang',
                'experience_level' => 'Junior',
                'experience_years' => '0-2 tahun',
                'employment_type'  => 'Full Time',
                'min_education'    => 'D3',
                'open_positions'   => 1,
                'deadline'         => now()->addDays(14)->toDateString(),
                'is_active'        => true,
                'job_description'  => "Memberikan dukungan teknis kepada pengguna internal terkait hardware, software, dan jaringan. Mengelola aset IT dan memastikan sistem berjalan dengan baik.",
                'requirements'     => "- Pendidikan D3/S1 Teknik Informatika / Sistem Informasi\n- Memahami troubleshooting hardware dan software\n- Familiar dengan jaringan komputer (LAN, WiFi)\n- Mampu bekerja mandiri dan dalam tim\n- Fresh graduate dipersilakan melamar",
            ],
            [
                'title'            => 'HRD Recruiter',
                'position'         => 'Recruiter',
                'department'       => 'Human Resources',
                'location'         => 'Semarang',
                'experience_level' => 'Junior',
                'experience_years' => '1-3 tahun',
                'employment_type'  => 'Full Time',
                'min_education'    => 'S1',
                'open_positions'   => 1,
                'deadline'         => now()->addDays(35)->toDateString(),
                'is_active'        => true,
                'job_description'  => "Mengelola proses rekrutmen end-to-end mulai dari sourcing kandidat, screening CV, koordinasi wawancara, hingga onboarding karyawan baru. Membangun talent pool dan employer branding perusahaan.",
                'requirements'     => "- Pendidikan S1 Psikologi / Manajemen SDM / Hukum\n- Pengalaman minimal 1 tahun di bidang rekrutmen\n- Menguasai teknik wawancara berbasis kompetensi\n- Familiar dengan job portal (Jobstreet, LinkedIn, dll)\n- Komunikatif dan memiliki interpersonal skill yang baik",
            ],
            [
                'title'            => 'Supervisor Gudang',
                'position'         => 'Supervisor',
                'department'       => 'Logistik & Warehouse',
                'location'         => 'Solo',
                'experience_level' => 'Mid',
                'experience_years' => '3-5 tahun',
                'employment_type'  => 'Full Time',
                'min_education'    => 'S1',
                'open_positions'   => 1,
                'deadline'         => now()->addDays(25)->toDateString(),
                'is_active'        => true,
                'job_description'  => "Memimpin operasional gudang meliputi penerimaan, penyimpanan, dan pengiriman barang. Memastikan akurasi stok dan kelancaran proses distribusi ke seluruh cabang.",
                'requirements'     => "- Pendidikan S1 Manajemen / Logistik / Teknik Industri\n- Pengalaman minimal 3 tahun di bidang warehouse / logistik\n- Menguasai sistem WMS (Warehouse Management System)\n- Mampu memimpin tim minimal 10 orang\n- Bersedia bekerja shift dan ditempatkan di Solo",
            ],
        ];

        foreach ($jobs as $job) {
            JobPosting::create(array_merge($job, ['employer_id' => $employer->id]));
        }
    }
}
