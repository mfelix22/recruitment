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
            background: #4f46e5;
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
            background: #fffbeb;
            border: 1px solid #f59e0b;
            border-radius: 6px;
            padding: 12px 16px;
            margin: 16px 0;
        }

        .btn {
            display: inline-block;
            background: #4f46e5;
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
            <h2 style="margin:0">Undangan Medical Check-Up (MCU)</h2>
        </div>
        <div class="body">
            <p>Yth. <strong>{{ $application->applicant->name }}</strong>,</p>

            <p>Kami dengan senang hati memberitahukan bahwa Anda telah berhasil melewati tahap seleksi untuk posisi:</p>

            <div class="info-box">
                <strong>Posisi:</strong> {{ $application->jobPosting->title }}<br>
                @if ($application->jobPosting->department)
                    <strong>Departemen:</strong> {{ $application->jobPosting->department }}<br>
                @endif
                <strong>No. Lamaran:</strong> #{{ $application->id }}
            </div>

            <p>Sebagai langkah selanjutnya, Anda diwajibkan untuk mengikuti <strong>Medical Check-Up (MCU)</strong>. Tim
                HRD kami akan menghubungi Anda untuk mengatur jadwal MCU.</p>

            <p>Hal-hal yang perlu dipersiapkan:</p>
            <ul>
                <li>Kartu identitas (KTP) asli</li>
                <li>Datang dalam keadaan puasa minimal 8 jam (jika diperlukan)</li>
                <li>Pakaian yang nyaman dan sopan</li>
            </ul>

            <p>Jika ada pertanyaan, silakan hubungi tim HRD kami.</p>

            <p>Hormat kami,<br><strong>Tim HRD</strong></p>
        </div>
        <div class="footer">
            Email ini dikirim secara otomatis. Mohon tidak membalas email ini.
        </div>
    </div>
</body>

</html>
