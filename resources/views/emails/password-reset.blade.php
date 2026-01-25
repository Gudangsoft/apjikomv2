<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset - APJIKOM</title>
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
        .alert {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
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
            color: #7c3aed;
        }
        .credential-item {
            margin: 10px 0;
            padding: 10px;
            background: white;
            border-radius: 4px;
        }
        .credential-label {
            font-weight: bold;
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
        }
        .credential-value {
            font-size: 16px;
            color: #111827;
            font-family: 'Courier New', monospace;
            margin-top: 5px;
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
        .warning {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Password Reset</h1>
            <p>Asosiasi Pengelola Jurnal Informatika dan Komputer (APJIKOM)</p>
        </div>
        
        <div class="content">
            <p>Halo <strong>{{ $user->name }}</strong>,</p>
            
            <p>Password akun Anda telah berhasil direset oleh administrator APJIKOM.</p>
            
            <div class="credentials">
                <h3>📧 Informasi Login Baru</h3>
                <div class="credential-item">
                    <div class="credential-label">Email</div>
                    <div class="credential-value">{{ $user->email }}</div>
                </div>
                <div class="credential-item">
                    <div class="credential-label">Password Baru</div>
                    <div class="credential-value">{{ $newPassword }}</div>
                </div>
            </div>
            
            <div class="warning">
                <strong>⚠️ PENTING - Keamanan Akun</strong>
                <p style="margin: 10px 0 0 0;">
                    Segera ubah password Anda setelah login untuk menjaga keamanan akun. 
                    Gunakan password yang kuat dengan kombinasi huruf besar, huruf kecil, angka, dan simbol.
                </p>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ route('member.profile') }}" class="button">
                    🔑 Login & Ubah Password
                </a>
            </div>
            
            <div class="alert">
                <strong>💡 Tips Keamanan:</strong>
                <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                    <li>Jangan bagikan password Anda kepada siapapun</li>
                    <li>Gunakan password yang berbeda untuk setiap akun</li>
                    <li>Aktifkan autentikasi dua faktor jika tersedia</li>
                </ul>
            </div>
        </div>
        
        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh sistem APJIKOM.</p>
            <p>Jika Anda tidak merasa meminta reset password, segera hubungi admin.</p>
            <p>&copy; {{ date('Y') }} APJIKOM. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
