<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pendaftaran - {{ $globalSiteName }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .container { background: #f9fafb; border-radius: 10px; padding: 30px; border: 1px solid #e5e7eb; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #7c3aed; margin: 0; }
        .content { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .info-badge { background: #ede9fe; border-left: 4px solid #7c3aed; padding: 15px; margin: 20px 0; border-radius: 4px; }
        .detail-box { background: #f3f4f6; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .detail-item { margin: 10px 0; padding: 10px; background: white; border-radius: 4px; }
        .detail-item strong { display: inline-block; width: 140px; color: #6b7280; }
        .warning { background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; margin: 20px 0; border-radius: 4px; font-size: 14px; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; font-size: 14px; }
        .steps { background: #f0fdf4; border-left: 4px solid #10b981; padding: 15px; margin: 20px 0; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Pendaftaran Diterima</h1>
            <p style="color:#6b7280;margin:10px 0 0 0;">{{ $globalSiteTagline }}</p>
        </div>

        <div class="content">
            <div class="info-badge">
                <strong>Terima kasih telah mendaftar!</strong><br>
                Pendaftaran Anda sebagai anggota <strong>{{ $globalSiteName }}</strong> telah kami terima dan sedang dalam proses review.
            </div>

            <p>Halo <strong>{{ $registration->full_name }}</strong>,</p>
            <p>Kami telah menerima permohonan keanggotaan Anda. Tim kami akan segera meninjau data pendaftaran dan menghubungi Anda kembali melalui email ini.</p>

            <div class="detail-box">
                <h3 style="margin-top:0;color:#4b5563;">📄 Ringkasan Pendaftaran</h3>
                <div class="detail-item">
                    <strong>Nama Lengkap:</strong> {{ $registration->full_name }}
                </div>
                <div class="detail-item">
                    <strong>Email:</strong> {{ $registration->email }}
                </div>
                <div class="detail-item">
                    <strong>No. HP / WA:</strong> {{ $registration->phone }}
                </div>
                <div class="detail-item">
                    <strong>Tipe Keanggotaan:</strong> {{ ucfirst($registration->type) }}
                </div>
                @if($registration->institution)
                <div class="detail-item">
                    <strong>Institusi:</strong> {{ $registration->institution }}
                </div>
                @endif
                <div class="detail-item">
                    <strong>Status:</strong>
                    <span style="color:#f59e0b;font-weight:bold;">⏳ Menunggu Review</span>
                </div>
            </div>

            <div class="steps">
                <strong>📌 Langkah Selanjutnya:</strong>
                <ol style="margin:10px 0 0 0;padding-left:20px;">
                    <li>Admin akan meninjau data pendaftaran Anda</li>
                    <li>Anda akan mendapat email konfirmasi persetujuan beserta data akun login</li>
                    <li>Setelah akun aktif, Anda dapat login ke dashboard member</li>
                </ol>
            </div>

            <div class="warning">
                <strong>⚠️ Catatan:</strong><br>
                Jika Anda tidak menerima email persetujuan dalam 3 hari kerja, silakan hubungi kami melalui
                @if(setting('contact_email'))
                    <a href="mailto:{{ setting('contact_email') }}" style="color:#d97706;">{{ setting('contact_email') }}</a>
                @else
                    halaman kontak website kami
                @endif
                .
            </div>

            <p style="color:#6b7280;font-size:14px;">
                Jika Anda merasa tidak melakukan pendaftaran ini, abaikan email ini.
            </p>
        </div>

        <div class="footer">
            <p style="margin:5px 0;">
                <strong>{{ $globalSiteName }}</strong><br>
                {{ $globalSiteTagline }}
            </p>
            <p style="margin:5px 0;font-size:13px;">Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
            <p style="margin:10px 0;">
                <a href="{{ url('/') }}" style="color:#7c3aed;text-decoration:none;">Kunjungi Website</a>
            </p>
        </div>
    </div>
</body>
</html>
