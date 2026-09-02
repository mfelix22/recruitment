<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 24px;
        }

        .header {
            background: #0d9488;
            color: white;
            padding: 20px 24px;
            border-radius: 8px 8px 0 0;
        }

        .body {
            background: #f9fafb;
            padding: 24px;
            border: 1px solid #e5e7eb;
        }

        .footer {
            background: #f3f4f6;
            padding: 12px 24px;
            font-size: 12px;
            color: #6b7280;
            border-radius: 0 0 8px 8px;
            border: 1px solid #e5e7eb;
            border-top: 0;
        }

        .info-box {
            background: #f0fdfa;
            border: 1px solid #0d9488;
            border-radius: 6px;
            padding: 12px 16px;
            margin: 16px 0;
        }

        .doc-table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
        }

        .doc-table th {
            background: #0d9488;
            color: white;
            padding: 8px 12px;
            text-align: left;
            font-size: 13px;
        }

        .doc-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }

        .doc-table tr:last-child td {
            border-bottom: 0;
        }

        .badge-mandatory {
            background: #fef2f2;
            color: #b91c1c;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 9999px;
            font-weight: bold;
        }

        .badge-optional {
            background: #f0fdf4;
            color: #15803d;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 9999px;
        }

        .btn {
            display: inline-block;
            background: #0d9488;
            color: white;
            padding: 10px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 16px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0">🎉 Selamat! Anda Diterima</h2>
            <p style="margin:4px 0 0">Lengkapi Dokumen Onboarding Anda</p>
        </div>
        <div class="body">
            <p>Yth. <strong>{{ $application->applicant->name }}</strong>,</p>

            <p>Kami dengan bangga menyampaikan bahwa Anda telah <strong>lulus seluruh tahap seleksi</strong> dan resmi
                diterima untuk posisi:</p>

            <div class="info-box">
                <strong>Posisi:</strong> {{ $application->jobPosting->title }}<br>
                @if ($application->jobPosting->department)
                    <strong>Departemen:</strong> {{ $application->jobPosting->department }}<br>
                @endif
                <strong>No. Lamaran:</strong> #{{ $application->id }}
            </div>

            <p>Sebagai langkah selanjutnya, Anda perlu melengkapi dokumen onboarding berikut. Silakan login ke portal
                karir dan unggah dokumen pada halaman <strong>Lamaran Saya → Detail Lamaran → Dokumen
                    Onboarding</strong>.</p>

            @if (count($requiredDocs) > 0)
                <table class="doc-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Dokumen</th>
                            <th>Format</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requiredDocs as $i => $doc)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $doc->description }}</td>
                                <td style="text-transform:uppercase; font-size:12px;">{{ $doc->format_file }}</td>
                                <td>
                                    @if ($doc->status === 'mandatory')
                                        <span class="badge-mandatory">Wajib</span>
                                    @else
                                        <span class="badge-optional">Opsional</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <p><strong>Harap melengkapi dokumen wajib dalam waktu 3 hari kerja.</strong> Tim HRD kami akan menghubungi
                Anda untuk informasi lebih lanjut mengenai jadwal mulai kerja.</p>

            <a href="{{ route('applicant.applications.index') }}" class="btn">Buka Portal Karir</a>

            <p style="margin-top:20px">Hormat kami,<br><strong>Tim HRD</strong></p>
        </div>
        <div class="footer">
            Email ini dikirim secara otomatis. Mohon tidak membalas email ini.
        </div>
    </div>
</body>

</html>
