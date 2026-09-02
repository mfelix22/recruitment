<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Formulir Lamaran Kerja - {{ $application->applicant->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9px;
            color: #111;
            background: #fff;
        }

        .page {
            padding: 14mm 12mm;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4mm;
        }

        .logo-cell {
            width: 32mm;
            vertical-align: top;
            padding-right: 3mm;
        }

        .logo-ring {
            border: 3px solid #222;
            border-radius: 50%;
            width: 22mm;
            height: 22mm;
            text-align: center;
            line-height: 22mm;
            font-size: 18px;
            font-weight: bold;
            display: inline-block;
        }

        .logo-text {
            font-size: 7.5px;
            font-weight: bold;
            margin-top: 2px;
            line-height: 1.4;
        }

        .title-cell {
            vertical-align: middle;
            text-align: center;
        }

        .main-title {
            font-size: 15px;
            font-weight: bold;
            text-decoration: underline;
            letter-spacing: 1px;
        }

        .photo-cell {
            width: 32mm;
            vertical-align: top;
            text-align: right;
        }

        .section-header {
            background: #1a1a1a;
            color: #fff;
            font-weight: bold;
            font-size: 9px;
            padding: 2px 6px;
            margin: 3mm 0 2mm;
        }

        .sub-header {
            font-weight: bold;
            font-size: 9px;
            margin: 2mm 0 1mm;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2mm;
        }

        table.data td,
        table.data th {
            border: 1px solid #333;
            padding: 2px 4px;
            vertical-align: top;
            font-size: 8.5px;
        }

        table.data th {
            background: #e0e0e0;
            font-weight: bold;
            text-align: center;
            font-size: 8px;
        }

        table.data .lbl {
            background: #f5f5f5;
            font-weight: normal;
            width: 38%;
        }

        table.data .val {
            font-weight: bold;
        }

        .cb {
            display: inline-block;
            width: 9px;
            height: 9px;
            border: 1px solid #333;
            text-align: center;
            vertical-align: middle;
            line-height: 9px;
            font-size: 7px;
            margin-right: 1px;
        }

        .cb-checked {
            background: #111;
            color: #fff;
        }

        .cb-label {
            vertical-align: middle;
            margin-right: 5px;
            font-size: 8.5px;
        }

        .essay-q {
            font-size: 8.5px;
            font-style: italic;
            color: #333;
            margin-top: 1mm;
        }

        .essay-a {
            border: 1px solid #aaa;
            padding: 2px 4px;
            min-height: 8mm;
            font-size: 8.5px;
            margin-bottom: 2mm;
        }

        .page-break {
            page-break-before: always;
        }

        .no-break {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    <div class="page">

        @php
            $profile = $application->applicant->applicantProfile;
            $essay = $profile?->essay;
            $savedPrefs = $profile?->company_preferences ?? [];
            $companyOptions = [
                'PT. Hartono Raya Motor',
                'Surabaya',
                'Jakarta',
                'Semarang',
                'Bali',
                'PT. Rudy Darma Engineering',
                'Harent',
                'Grand Istana Rama Hotel, Bali',
            ];
        @endphp

        {{-- LETTERHEAD --}}
        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    <div class="logo-ring">H</div>
                    <div class="logo-text">Hartono Raya<br>Motor Group</div>
                </td>
                <td class="title-cell">
                    <div class="main-title">FORMULIR LAMARAN KERJA</div>
                </td>
                <td class="photo-cell">
                    <table style="width:28mm;height:36mm;border:1px solid #333;border-collapse:collapse;">
                        <tr>
                            <td style="text-align:center;vertical-align:middle;font-size:7.5px;color:#666;padding:2px;">
                                @if ($profile?->photo)
                                    <img src="{{ storage_path('app/public/' . $profile->photo) }}"
                                        style="width:26mm;height:34mm;object-fit:cover;" />
                                @else
                                    4 X 6 CM<br>(Foto Terbaru)
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <hr style="border:none;border-top:2px solid #333;margin-bottom:3mm;">

        {{-- JOB & COMPANY --}}
        <table style="width:100%;border-collapse:collapse;margin-bottom:2mm;">
            <tr>
                <td style="width:56mm;font-size:8.5px;padding:1mm 0;">Untuk jabatan apa Saudara melamar</td>
                <td style="width:4mm;text-align:center;">:</td>
                <td style="border-bottom:1px solid #333;padding:1mm 2mm;font-weight:bold;font-size:8.5px;">
                    {{ $profile?->desired_position ?: $application->jobPosting->title }}</td>
            </tr>
            <tr>
                <td style="font-size:8.5px;padding:2mm 0 1mm;vertical-align:top;">Saudara melamar untuk perusahaan mana
                </td>
                <td style="text-align:center;vertical-align:top;padding-top:2mm;">:</td>
                <td style="padding:1mm 2mm;font-size:8.5px;">
                    @foreach ($companyOptions as $co)
                        @php $checked = in_array($co, $savedPrefs); @endphp
                        <span class="cb {{ $checked ? 'cb-checked' : '' }}">{{ $checked ? '✓' : ' ' }}</span><span
                            class="cb-label">{{ $co }}</span>
                        @if ($loop->index === 4)
                            <br style="margin-bottom:1mm;">
                        @endif
                    @endforeach
                </td>
            </tr>
        </table>

        <div style="border:1px solid #888;padding:3px 6px;margin-bottom:3mm;font-size:8px;">
            <strong>Catatan :</strong><br>
            1. Pengisian formulir ini harus dengan huruf cetak dan diisi oleh pelamar sendiri.<br>
            2. Bila keterangan yang diberikan di bawah ini ada yang tidak sesuai dengan kenyataan, maka Perusahaan
            berhak membatalkan lamaran ini / memutuskan hubungan kerja atau menuntut pelamar sesuai dengan hukum yang
            berlaku oleh sebab memberikan keterangan palsu.
        </div>

        {{-- A. IDENTITAS --}}
        <div class="section-header">A. IDENTITAS</div>
        @if ($profile)
            <table class="data">
                <tr>
                    <td class="lbl">Nama lengkap</td>
                    <td>:</td>
                    <td class="val" colspan="3">{{ $application->applicant->name }}</td>
                </tr>
                <tr>
                    <td class="lbl">Tempat / Tanggal lahir</td>
                    <td>:</td>
                    <td class="val" colspan="3">{{ $profile->place_of_birth ?? '-' }},
                        {{ $profile->date_of_birth?->format('d M Y') ?? '-' }}@if ($profile->date_of_birth)
                            &nbsp;(Usia: {{ $profile->date_of_birth->diffInYears(now()) }} tahun)
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="lbl">Alamat Domisili</td>
                    <td>:</td>
                    <td class="val" colspan="3">{{ $profile->domisili_address ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="lbl"></td>
                    <td></td>
                    <td colspan="3">No. Telp. : {{ $profile->domisili_phone ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Alamat Tetap (KTP)</td>
                    <td>:</td>
                    <td class="val" colspan="3">
                        @if ($profile->address)
                            {{ $profile->address->full_address }}@else-
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="lbl">No. Telp.</td>
                    <td>:</td>
                    <td style="width:32%;">{{ $profile->ktp_phone ?? '-' }}</td>
                    <td class="lbl" style="width:20%;">No. HP</td>
                    <td>{{ $profile->phone ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Agama / Kepercayaan</td>
                    <td>:</td>
                    <td>{{ $profile->religion ?? '-' }}</td>
                    <td class="lbl">Kewarganegaraan</td>
                    <td>{{ $profile->nationality ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="lbl">KTP No.</td>
                    <td>:</td>
                    <td>{{ $profile->nik ?? '-' }}</td>
                    <td class="lbl">Dikeluarkan di</td>
                    <td>{{ $profile->ktp_issued_place ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="lbl">SIM No</td>
                    <td>:</td>
                    <td>{{ $profile->sim_no ?? '-' }}</td>
                    <td class="lbl">Dikeluarkan di</td>
                    <td>{{ $profile->sim_issued_place ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Alamat Email</td>
                    <td>:</td>
                    <td>{{ $application->applicant->email }}</td>
                    <td class="lbl">Golongan Darah</td>
                    <td>{{ $profile->blood_type ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Tinggi Badan</td>
                    <td>:</td>
                    <td>{{ $profile->height_cm ? $profile->height_cm . ' cm' : '-' }}</td>
                    <td class="lbl">Berat Badan</td>
                    <td>{{ $profile->weight_kg ? $profile->weight_kg . ' kg' : '-' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Jenis Kelamin</td>
                    <td>:</td>
                    <td>{{ $profile->gender ?? '-' }}</td>
                    <td class="lbl">Status Perkawinan</td>
                    <td>{{ $profile->marital_status ?? '-' }}</td>
                </tr>
            </table>
        @else
            <p style="color:#888;font-style:italic;font-size:8.5px;margin:2mm 0;">Profil belum dilengkapi.</p>
        @endif

        {{-- B. KELUARGA --}}
        <div class="section-header">B. KELUARGA DAN LINGKUNGAN</div>
        @if ($profile)
            @php
                $ms = $profile->marital_status ?? '';
                $since = $profile->marital_since?->format('d M Y') ?? '';
            @endphp
            <div class="no-break" style="margin-bottom:2mm;">
                <div class="sub-header">1. Status pernikahan :</div>
                <div style="padding-left:6mm;font-size:8.5px;line-height:1.8;">
                    <span
                        class="cb {{ in_array($ms, ['Belum Menikah', 'Bertunangan']) ? 'cb-checked' : '' }}">{{ in_array($ms, ['Belum Menikah', 'Bertunangan']) ? '✓' : ' ' }}</span>
                    <span class="cb-label">Single / Bertunangan sejak tanggal :</span> <span
                        style="border-bottom:1px solid #333;display:inline-block;min-width:30mm;">
                        {{ $ms === 'Bertunangan' ? $since : '' }}</span>
                    &nbsp;&nbsp;
                    <span
                        class="cb {{ $ms === 'Menikah' ? 'cb-checked' : '' }}">{{ $ms === 'Menikah' ? '✓' : ' ' }}</span>
                    <span class="cb-label">Menikah sejak tanggal :</span> <span
                        style="border-bottom:1px solid #333;display:inline-block;min-width:30mm;">
                        {{ $ms === 'Menikah' ? $since : '' }}</span>
                    &nbsp;&nbsp;
                    <span
                        class="cb {{ in_array($ms, ['Cerai Hidup', 'Cerai Mati']) ? 'cb-checked' : '' }}">{{ in_array($ms, ['Cerai Hidup', 'Cerai Mati']) ? '✓' : ' ' }}</span>
                    <span class="cb-label">Bercerai sejak tanggal :</span> <span
                        style="border-bottom:1px solid #333;display:inline-block;min-width:30mm;">
                        {{ in_array($ms, ['Cerai Hidup', 'Cerai Mati']) ? $since : '' }}</span>
                </div>
            </div>

            <div class="sub-header">2. Susunan keluarga ( istri / suami dan anak – anak ) :</div>
            <table class="data" style="margin-bottom:2mm;">
                <thead>
                    <tr>
                        <th style="width:18mm;"></th>
                        <th>Nama</th>
                        <th style="width:10mm;">L / P</th>
                        <th>Tempat / Tgl Lahir</th>
                        <th>Pendidikan</th>
                        <th>Pekerjaan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $immRows = ['Istri / suami', 'Anak ke 1', 'Anak ke 2', 'Anak ke 3', 'Anak ke 4', 'Anak ke 5'];
                        $immData = $profile->immediateFamilyMembers->values();
                    @endphp
                    @foreach ($immRows as $ri => $rowLabel)
                        @php $fm=$immData[$ri]??null; @endphp
                        <tr>
                            <td>{{ $rowLabel }}</td>
                            <td>{{ $fm?->name ?? '' }}</td>
                            <td style="text-align:center;">
                                {{ $fm?->gender ? ($fm->gender === 'Laki-laki' ? 'L' : 'P') : '' }}
                            </td>
                            <td>{{ $fm ? ($fm->place_of_birth ?? '') . ($fm->date_of_birth ? ', ' . $fm->date_of_birth->format('d M Y') : '') : '' }}
                            </td>
                            <td>{{ $fm?->education ?? '' }}</td>
                            <td>{{ $fm?->occupation ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="sub-header">3. Susunan keluarga asal ( Ayah / Ibu / Saudara Kandung ) :</div>
            <table class="data" style="margin-bottom:2mm;">
                <thead>
                    <tr>
                        <th style="width:18mm;"></th>
                        <th>Nama</th>
                        <th style="width:10mm;">L / P</th>
                        <th>Tempat / Tgl Lahir</th>
                        <th>Pendidikan</th>
                        <th>Pekerjaan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $origLabels = ['Ayah', 'Ibu', 'Saudara ke 1', 'Saudara ke 2', 'Saudara ke 3', 'Saudara ke 4'];
                        $origData = $profile->originFamilyMembers->values();
                    @endphp
                    @foreach ($origLabels as $ri => $rowLabel)
                        @php $fm=$origData[$ri]??null; @endphp
                        <tr>
                            <td>{{ $rowLabel }}</td>
                            <td>{{ $fm?->name ?? '' }}</td>
                            <td style="text-align:center;">
                                {{ $fm?->gender ? ($fm->gender === 'Laki-laki' ? 'L' : 'P') : '' }}
                            </td>
                            <td>{{ $fm ? ($fm->place_of_birth ?? '') . ($fm->date_of_birth ? ', ' . $fm->date_of_birth->format('d M Y') : '') : '' }}
                            </td>
                            <td>{{ $fm?->education ?? '' }}</td>
                            <td>{{ $fm?->occupation ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="data" style="margin-bottom:2mm;">
                <tr>
                    <td class="lbl">Status Rumah Tempat Tinggal</td>
                    <td>:</td>
                    <td>{{ $profile->house_status ?? '-' }}</td>
                    <td class="lbl" style="width:26%;">Bersedia Ditempatkan</td>
                    <td>{{ $profile->willing_to_relocate ? 'Ya, di seluruh Indonesia' : 'Tidak' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Tanggungan lain</td>
                    <td>:</td>
                    <td colspan="3">{{ $profile->other_dependents ?? '-' }}</td>
                </tr>
            </table>
        @endif

        {{-- C. PENDIDIKAN --}}
        <div class="section-header page-break">C. RIWAYAT PENDIDIKAN</div>

        <div class="sub-header">1. Pendidikan Formal</div>
        @if ($profile && $profile->educations->isNotEmpty())
            <table class="data">
                <thead>
                    <tr>
                        <th>Jenjang</th>
                        <th>Nama Sekolah / Institusi</th>
                        <th>Kota</th>
                        <th>Jurusan</th>
                        <th style="width:18mm;">Tahun</th>
                        <th style="width:12mm;">IPK/Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profile->educations as $edu)
                        <tr>
                            <td>{{ $edu->level }}</td>
                            <td>{{ $edu->institution }}</td>
                            <td>{{ $edu->place ?? '-' }}</td>
                            <td>{{ $edu->major ?? '-' }}</td>
                            <td style="text-align:center;">{{ $edu->year_start }}–{{ $edu->year_end ?? 'skr' }}</td>
                            <td style="text-align:center;">{{ $edu->gpa ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color:#888;font-style:italic;font-size:8.5px;margin:1mm 0 2mm 6mm;">Tidak ada data pendidikan.</p>
        @endif

        <div class="sub-header">2. Pendidikan Non-Formal / Training / Kursus / Seminar</div>
        @if ($profile && $profile->trainings->isNotEmpty())
            <table class="data">
                <thead>
                    <tr>
                        <th>Nama Kursus / Training / Seminar</th>
                        <th>Diselenggarakan Oleh</th>
                        <th>Tempat</th>
                        <th style="width:14mm;">Tahun</th>
                        <th>Biaya Ditanggung</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profile->trainings as $t)
                        <tr>
                            <td>{{ $t->name }}</td>
                            <td>{{ $t->organizer ?? '-' }}</td>
                            <td>{{ $t->place ?? '-' }}</td>
                            <td style="text-align:center;">{{ $t->year ?? '-' }}</td>
                            <td>{{ $t->notes ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color:#888;font-style:italic;font-size:8.5px;margin:1mm 0 2mm 6mm;">Tidak ada data pelatihan.</p>
        @endif

        <div class="sub-header">3. Penguasaan Bahasa Asing</div>
        @if ($profile && $profile->languageSkills->isNotEmpty())
            <table class="data">
                <thead>
                    <tr>
                        <th rowspan="2">Bahasa</th>
                        <th colspan="4">Tertulis</th>
                        <th colspan="4">Percakapan</th>
                    </tr>
                    <tr>
                        <th>S. Baik</th>
                        <th>Baik</th>
                        <th>Cukup</th>
                        <th>Kurang</th>
                        <th>S. Baik</th>
                        <th>Baik</th>
                        <th>Cukup</th>
                        <th>Kurang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profile->languageSkills as $lang)
                        <tr>
                            <td>{{ $lang->language }}</td>
                            @foreach (['S. Baik', 'Baik', 'Cukup', 'Kurang'] as $lv)
                                <td style="text-align:center;">{{ $lang->written_level === $lv ? '✓' : '' }}</td>
                            @endforeach
                            @foreach (['S. Baik', 'Baik', 'Cukup', 'Kurang'] as $lv)
                                <td style="text-align:center;">{{ $lang->spoken_level === $lv ? '✓' : '' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color:#888;font-style:italic;font-size:8.5px;margin:1mm 0 2mm 6mm;">Tidak ada data bahasa.</p>
        @endif

        <div class="sub-header">4. Pertanyaan tentang Pendidikan</div>
        @php $cEssays=[['why_chose_major','Mengapa Saudara memilih pendidikan / jurusan tersebut?'],['best_education','Di pendidikan manakah Saudara paling puas dengan prestasi Saudara? Mengapa?'],['worst_education','Di pendidikan manakah Saudara paling tidak puas? Mengapa?'],['karya_ilmiah','Karya Ilmiah Saudara (skripsi, artikel, buku, dll.)'],['favorite_subject','Mata pelajaran yang paling disukai? Berapa nilai rata-rata?'],['education_funder','Siapa yang selama ini membiayai pendidikan Saudara?']]; @endphp
        @foreach ($cEssays as [$field, $label])
            <div style="margin-bottom:2mm;">
                <div class="essay-q">{{ $label }}</div>
                <div class="essay-a">{{ $essay?->$field ?? '' }}</div>
            </div>
        @endforeach

        {{-- D. PEKERJAAN --}}
        <div class="section-header page-break">D. RIWAYAT PEKERJAAN</div>
        @if ($profile && $profile->workExperiences->isNotEmpty())
            <table class="data">
                <thead>
                    <tr>
                        <th>Nama Perusahaan</th>
                        <th>Kota</th>
                        <th>Jabatan</th>
                        <th>Periode</th>
                        <th>Gaji Terakhir</th>
                        <th>Alasan Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profile->workExperiences as $work)
                        <tr>
                            <td>{{ $work->company }}</td>
                            <td>{{ $work->company_city ?? '-' }}</td>
                            <td>{{ $work->position }}</td>
                            <td>{{ $work->period }}</td>
                            <td>{{ $work->last_salary ?? '-' }}</td>
                            <td>{{ $work->reason_for_leaving ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="sub-header">Pertanyaan tentang Pengalaman Kerja</div>
            @php $dEssays=[['brief_job_description','Uraian singkat dari 2 jabatan terakhir yang Saudara jabat'],['supervisor_detail','Siapa yang menjadi atasan Saudara?'],['subordinate_detail','Berapa banyak bawahan Saudara?'],['changes_made','Pernahkah melakukan perubahan / pembaharuan di perusahaan terdahulu? Perubahan apa?'],['job_satisfaction','Puaskah terhadap kemajuan di pekerjaan terdahulu? Mengapa?'],['changes_motivation','Apa yang paling mendorong Saudara sampai pada taraf kemajuan seperti sekarang?'],['decision_approach','Bila menghadapi persoalan dalam pekerjaan, apa yang Saudara lakukan?']]; @endphp
            @foreach ($dEssays as [$field, $label])
                <div style="margin-bottom:2mm;">
                    <div class="essay-q">{{ $label }}</div>
                    <div class="essay-a">{{ $essay?->$field ?? '' }}</div>
                </div>
            @endforeach
        @else
            <p style="color:#555;font-style:italic;font-size:8.5px;margin:1mm 0 2mm 6mm;">Fresh Graduate / tidak ada
                pengalaman kerja.</p>
        @endif

        <div class="sub-header">Pertanyaan Umum</div>
        @php $dGeneral=[['problems_faced','Masalah-masalah penting yang pernah dihadapi dan bagaimana mengatasinya?'],['motivational_driver','Menurut pendapat Saudara, apa dan siapa yang paling utama mendorong Saudara sampai pada taraf kemajuan seperti sekarang?'],['decision_making','Bila menghadapi persoalan dalam pekerjaan dan harus mengambil keputusan, apa yang Saudara lakukan?'],['who_you_consult','Bila menghadapi persoalan pribadi / pekerjaan, dengan siapa biasanya Saudara berunding?']]; @endphp
        @foreach ($dGeneral as [$field, $label])
            <div style="margin-bottom:2mm;">
                <div class="essay-q">{{ $label }}</div>
                <div class="essay-a">{{ $essay?->$field ?? '' }}</div>
            </div>
        @endforeach

        @if ($profile && $profile->references->isNotEmpty())
            <div class="sub-header">Referensi</div>
            <table class="data">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Alamat Kantor</th>
                        <th>No. Telp</th>
                        <th>Hubungan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profile->references as $ref)
                        <tr>
                            <td>{{ $ref->name }}</td>
                            <td>{{ $ref->position ?? '-' }}</td>
                            <td>{{ $ref->work_address ?? '-' }}</td>
                            <td>{{ $ref->phone ?? '-' }}</td>
                            <td>{{ $ref->relation ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        {{-- E. MINAT --}}
        <div class="section-header page-break">E. MINAT DAN KONSEP PRIBADI</div>
        @if ($profile)
            <table class="data" style="margin-bottom:2mm;">
                <tr>
                    <td class="lbl">Gaji Minimal yang Diinginkan</td>
                    <td>:</td>
                    <td>Rp
                        {{ $profile->expected_salary ? number_format($profile->expected_salary, 0, ',', '.') : '-' }}
                    </td>
                    <td class="lbl" style="width:28%;">Dapat Mulai Bekerja</td>
                    <td>{{ $profile->available_start_date?->format('d M Y') ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Fasilitas yang Diinginkan</td>
                    <td>:</td>
                    <td colspan="3">{{ $profile->desired_facilities ?? '-' }}</td>
                </tr>
            </table>
            @if ($profile->jobTypePreferences->isNotEmpty())
                <div class="sub-header">Ranking Jenis Pekerjaan yang Diminati</div>
                <table class="data" style="width:70%;margin-bottom:2mm;">
                    <thead>
                        <tr>
                            <th style="width:12mm;">Urutan</th>
                            <th>Jenis Pekerjaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profile->jobTypePreferences as $pref)
                            <tr>
                                <td style="text-align:center;">{{ $pref->rank_order }}</td>
                                <td>{{ $pref->job_type }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            @if ($profile->has_company_acquaintances && $profile->company_acquaintances)
                <table class="data" style="margin-bottom:2mm;">
                    <tr>
                        <td class="lbl">Kenalan di Perusahaan</td>
                        <td>:</td>
                        <td>{{ $profile->company_acquaintances }}</td>
                    </tr>
                </table>
            @endif
        @endif

        <div class="sub-header">Pertanyaan tentang Minat</div>
        @php $eEssays=[['why_apply_here','Mengapa Saudara ingin bekerja di perusahaan kami?'],['company_knowledge','Apa yang Saudara ketahui mengenai perusahaan kami?'],['why_2_preferences','Mengapa Saudara memilih 2 urutan teratas pada ranking pekerjaan di atas?'],['plan_for_position','Apa yang Saudara lakukan untuk dapat menduduki jabatan yang diinginkan?'],['preferred_environment','Lingkungan pekerjaan yang disenangi (pabrik, kantor, lapangan, laboratorium)? Mengapa?'],['disliked_environment','Lingkungan pekerjaan yang tidak disenangi? Mengapa?'],['preferred_person_type','Tipe orang yang paling Saudara senangi?'],['disliked_person_type','Tipe orang yang tidak Saudara senangi?'],['difficult_decisions','Terhadap hal-hal apakah Saudara paling sulit mengambil keputusan? Mengapa?']]; @endphp
        @foreach ($eEssays as [$field, $label])
            <div style="margin-bottom:2mm;">
                <div class="essay-q">{{ $label }}</div>
                <div class="essay-a">{{ $essay?->$field ?? '' }}</div>
            </div>
        @endforeach

        {{-- F. AKTIVITAS SOSIAL --}}
        <div class="section-header page-break">F. AKTIVITAS SOSIAL DAN KEGIATAN LAIN</div>
        @if ($profile)
            <table class="data" style="margin-bottom:2mm;">
                <tr>
                    <td class="lbl">Hobby / Kegemaran</td>
                    <td>:</td>
                    <td>{{ $profile->hobbies ?? '-' }}</td>
                    <td class="lbl" style="width:26%;">Cara Mengisi Waktu Luang</td>
                    <td>{{ $profile->free_time_activities ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Surat Kabar / Buku yang Disukai</td>
                    <td>:</td>
                    <td>{{ $profile->favorite_reading ?? '-' }}</td>
                    <td class="lbl">Topik / Pokok yang Disukai</td>
                    <td>{{ $profile->favorite_topics ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Perjalanan ke Luar Negeri</td>
                    <td>:</td>
                    <td colspan="3">{{ $profile->international_travel ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Organisasi &amp; Jabatan</td>
                    <td>:</td>
                    <td colspan="3">{{ $profile->organizational_activities ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Kenalan di Perusahaan</td>
                    <td>:</td>
                    <td colspan="3">
                        {{ $profile->has_company_acquaintances ? 'Ya — ' . ($profile->company_acquaintances ?? '') : 'Tidak' }}
                    </td>
                </tr>
            </table>
            @if ($profile->vehicles->isNotEmpty())
                <div class="sub-header">Kendaraan Pribadi</div>
                <table class="data" style="margin-bottom:2mm;">
                    <thead>
                        <tr>
                            <th>Merek / Type Kendaraan</th>
                            <th style="width:18mm;">CC / Kapasitas</th>
                            <th style="width:14mm;">Tahun</th>
                            <th style="width:20mm;">Kepemilikan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profile->vehicles as $v)
                            <tr>
                                <td>{{ $v->brand_type ?? '-' }}</td>
                                <td style="text-align:center;">{{ $v->cc ?? '-' }}</td>
                                <td style="text-align:center;">{{ $v->year ?? '-' }}</td>
                                <td>{{ $v->ownership ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endif

        {{-- G. LAIN-LAIN --}}
        <div class="section-header">G. LAIN-LAIN</div>
        @if ($profile)
            <table class="data" style="margin-bottom:2mm;">
                <tr>
                    <td class="lbl" style="vertical-align:top;">Kekuatan / Strengths</td>
                    <td style="vertical-align:top;">:</td>
                    <td style="vertical-align:top;">{{ $profile->strengths ?? '-' }}</td>
                    <td class="lbl" style="width:26%;vertical-align:top;">Kelemahan / Weaknesses</td>
                    <td style="vertical-align:top;">{{ $profile->weaknesses ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Pernah sakit yang lama sembuh</td>
                    <td>:</td>
                    <td colspan="3">{{ $profile->past_illness ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Gangguan jasmani tetap</td>
                    <td>:</td>
                    <td colspan="3">{{ $profile->permanent_physical_condition ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Gangguan kesehatan keluarga</td>
                    <td>:</td>
                    <td colspan="3">{{ $profile->family_health_issues ?? '-' }}</td>
                </tr>
            </table>

            <div class="sub-header">Kontak Darurat (tidak tinggal serumah)</div>
            <table class="data" style="margin-bottom:4mm;">
                <tr>
                    <td class="lbl">Nama</td>
                    <td>:</td>
                    <td>{{ $profile->emergency_contact_name ?? '-' }}</td>
                    <td class="lbl" style="width:22%;">Hubungan</td>
                    <td>{{ $profile->emergency_contact_relation ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="lbl">No. Telepon</td>
                    <td>:</td>
                    <td colspan="3">{{ $profile->emergency_contact_phone ?? '-' }}</td>
                </tr>
            </table>
        @endif

        @if ($application->cover_letter)
            <div class="sub-header">Surat / Catatan dari Pelamar</div>
            <div style="border:1px solid #aaa;padding:3px 6px;font-size:8.5px;white-space:pre-wrap;margin-bottom:4mm;">
                {{ $application->cover_letter }}</div>
        @endif

        {{-- Signature --}}
        <table style="width:100%;margin-top:6mm;border-collapse:collapse;">
            <tr>
                <td style="width:60%;"></td>
                <td style="text-align:center;font-size:8.5px;">
                    <div>{{ $application->jobPosting->location ?? '' }}, {{ now()->translatedFormat('d F Y') }}
                    </div>
                    <br><br><br><br>
                    <div
                        style="border-top:1px solid #333;display:inline-block;min-width:50mm;text-align:center;padding-top:1mm;">
                        {{ $application->applicant->name }}
                    </div>
                </td>
            </tr>
        </table>

    </div>
</body>

</html>
