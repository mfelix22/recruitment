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
            background: #2563eb;
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
            background: #eff6ff;
            border: 1px solid #93c5fd;
            border-radius: 6px;
            padding: 16px 20px;
            margin: 16px 0;
        }

        .info-row {
            margin: 6px 0;
        }

        .info-label {
            font-weight: bold;
            display: inline-block;
            min-width: 130px;
            color: #1e40af;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0">Undangan Interview</h2>
        </div>
        <div class="body">
            <p>Yth. <strong>{{ $application->applicant->name }}</strong>,</p>

            <p>Kami dengan senang hati mengundang Anda untuk mengikuti <strong>wawancara kerja</strong> pada posisi:</p>

            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">Posisi</span>
                    : {{ $application->jobPosting->title }}
                </div>
                @if ($application->jobPosting->department)
                    <div class="info-row">
                        <span class="info-label">Departemen</span>
                        : {{ $application->jobPosting->department }}
                    </div>
                @endif
                <div class="info-row">
                    <span class="info-label">No. Lamaran</span>
                    : #{{ $application->id }}
                </div>
                @if ($application->interview_at)
                    <div class="info-row">
                        <span class="info-label">Tanggal &amp; Waktu</span>
                        : {{ $application->interview_at->translatedFormat('l, d F Y') }} pukul
                        {{ $application->interview_at->format('H:i') }} WIB
                    </div>
                @endif
                @if ($application->interview_location)
                    <div class="info-row">
                        <span class="info-label">Lokasi</span>
                        : {{ $application->interview_location }}
                    </div>
                @endif
            </div>

            @if ($application->interview_notes)
                <p><strong>Informasi tambahan:</strong></p>
                <p style="background:#fff;border:1px solid #e5e7eb;border-radius:6px;padding:12px 16px;">
                    {{ $application->interview_notes }}
                </p>
            @endif

            <p>Mohon hadir tepat waktu dan membawa dokumen identitas diri. Jika ada pertanyaan atau kendala,
                silakan hubungi kami melalui email ini.</p>

            <p>Kami tunggu kehadiran Anda.</p>

            <p>Hormat kami,<br>
                <strong>Tim Rekrutmen</strong>
            </p>
        </div>
        <div class="footer">
            Email ini dikirim secara otomatis oleh sistem rekrutmen. Mohon tidak membalas email ini.
        </div>
    </div>
</body>

</html>
