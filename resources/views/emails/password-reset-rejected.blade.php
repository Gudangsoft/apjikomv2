<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Reset Password Ditolak - APJIKOM</title>
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
            color: #ef4444;
            margin: 0;
        }
        .content {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .alert {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box {
            background: #f3f4f6;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #7c3aed;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>❌ Permintaan Reset Password Ditolak</h1>
            <p>Asosiasi Pengelola Jurnal Ilmu Komunikasi (APJIKOM)</p>
        </div>
        
        <div class="content">
            <p>Halo <strong>{{ $user->name }}</strong>,</p>
            
            <p>Permintaan reset password Anda telah ditinjau oleh administrator APJIKOM.</p>
            
            <div class="alert">
                <strong>⚠️ Permintaan Anda Ditolak</strong>
                <p style="margin: 10px 0 0 0;">
                    Maaf, permintaan reset password Anda tidak dapat disetujui saat ini.
                    Hal ini mungkin disebabkan oleh beberapa alasan seperti verifikasi identitas yang belum lengkap atau alasan keamanan lainnya.
                </p>
            </div>
            
            <div class="info-box">
                <h3>🤔 Apa yang Harus Dilakukan?</h3>
                <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                    <li>Hubungi administrator APJIKOM untuk informasi lebih lanjut</li>
                    <li>Pastikan data profil Anda sudah lengkap dan terverifikasi</li>
                    <li>Coba ingat kembali password Anda atau gunakan fitur "Lupa Password" di halaman login</li>
                </ul>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ route('member.profile') }}" class="button">
                    👤 Lihat Profil Saya
                </a>
            </div>
            
            <p style="margin-top: 30px;">
                <strong>Butuh Bantuan?</strong><br>
                Jika Anda memiliki pertanyaan atau memerlukan bantuan lebih lanjut, 
                silakan hubungi tim support APJIKOM melalui email atau hubungi administrator.
            </p>
        </div>
        
        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh sistem APJIKOM.</p>
            <p>&copy; {{ date('Y') }} APJIKOM. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
