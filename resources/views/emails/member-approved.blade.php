<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Disetujui - APJIKOM</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background: #f9fafb;
            border-radius: 10px;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #7c3aed;
            margin: 0;
        }
        .content {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .success-badge {
            background: #dcfce7;
            border-left: 4px solid #10b981;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .credentials {
            background: #f3f4f6;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .credentials h3 {
            margin-top: 0;
            color: #4b5563;
        }
        .credential-item {
            margin: 10px 0;
            padding: 10px;
            background: white;
            border-radius: 4px;
        }
        .credential-item strong {
            display: inline-block;
            width: 120px;
            color: #6b7280;
        }
        .button {
            display: inline-block;
            background: #7c3aed;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
        .button:hover {
            background: #6d28d9;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .warning {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ Pendaftaran Disetujui</h1>
            <p style="color: #6b7280; margin: 10px 0 0 0;">Asosiasi Pendidikan Jurnalistik dan Komunikasi</p>
        </div>

        <div class="content">
            <div class="success-badge">
                <strong>🎉 Selamat!</strong><br>
                Pendaftaran Anda sebagai anggota APJIKOM telah disetujui.
            </div>

            <p>Halo <strong>{{ $user->name }}</strong>,</p>
            
            <p>Kami dengan senang hati menginformasikan bahwa pendaftaran Anda sebagai anggota APJIKOM telah <strong>disetujui</strong> oleh admin.</p>

            <div class="credentials">
                <h3>📋 Informasi Akun Anda</h3>
                <div class="credential-item">
                    <strong>Nama:</strong> {{ $user->name }}
                </div>
                <div class="credential-item">
                    <strong>Email:</strong> {{ $user->email }}
                </div>
                @if($user->username)
                <div class="credential-item">
                    <strong>Username:</strong> {{ $user->username }}
                </div>
                @endif
                <div class="credential-item">
                    <strong>Password:</strong> <code style="background: #fee2e2; padding: 4px 8px; border-radius: 4px; color: #dc2626;">{{ $password }}</code>
                </div>
                <div class="credential-item">
                    <strong>Status:</strong> <span style="color: #10b981; font-weight: bold;">✓ Aktif</span>
                </div>
            </div>

            <div class="warning">
                <strong>⚠️ Penting:</strong><br>
                Harap simpan informasi akun Anda dengan aman. Segera ganti password Anda setelah login pertama kali untuk keamanan akun Anda.
            </div>

            <p><strong>Langkah Selanjutnya:</strong></p>
            <ol>
                <li>Login ke dashboard member menggunakan kredensial di atas</li>
                <li>Lengkapi profil Anda</li>
                <li>Ganti password untuk keamanan</li>
                <li>Nikmati berbagai benefit sebagai anggota APJIKOM</li>
            </ol>

            <div style="text-align: center;">
                <a href="{{ url('/member/login') }}" class="button">
                    🔐 Login ke Dashboard
                </a>
            </div>

            <p style="margin-top: 30px; color: #6b7280; font-size: 14px;">
                Jika Anda mengalami kesulitan dalam login atau memiliki pertanyaan, silakan hubungi admin kami.
            </p>
        </div>

        <div class="footer">
            <p style="margin: 5px 0;">
                <strong>APJIKOM</strong><br>
                Asosiasi Pendidikan Jurnalistik dan Komunikasi
            </p>
            <p style="margin: 5px 0; font-size: 13px;">
                Email ini dikirim secara otomatis. Mohon tidak membalas email ini.
            </p>
            <p style="margin: 10px 0;">
                <a href="{{ url('/') }}" style="color: #7c3aed; text-decoration: none;">Kunjungi Website</a> |
                <a href="{{ url('/contact') }}" style="color: #7c3aed; text-decoration: none;">Hubungi Kami</a>
            </p>
        </div>
    </div>
</body>
</html>
