<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Sertifikat - {{ $event->title }}</title>
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: white;
        }
        
        .certificate {
            width: 297mm;
            height: 210mm;
            background: white;
            border: 12px solid #6B46C1;
            position: relative;
        }
        
        .header {
            background: #6B46C1;
            padding: 20px 40px;
            color: white;
            text-align: center;
        }
        
        .apjikom-title {
            font-size: 48px;
            font-weight: bold;
            letter-spacing: 6px;
            color: #FCD34D;
            margin-bottom: 5px;
        }
        
        .apjikom-subtitle {
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        
        .apjikom-details {
            font-size: 7px;
            line-height: 1.3;
        }
        
        .content {
            text-align: center;
            padding: 35px 50px 20px 50px;
            position: relative;
        }
        
        .watermark {
            position: absolute;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 150px;
            color: rgba(107, 70, 193, 0.02);
            font-weight: bold;
            z-index: 0;
        }
        
        .content-inner {
            position: relative;
            z-index: 1;
        }
        
        .certificate-title {
            font-size: 48px;
            font-weight: bold;
            color: #8B5CF6;
            margin: 15px 0 20px 0;
            letter-spacing: 6px;
        }
        
        .given-to {
            font-size: 14px;
            color: #8B5CF6;
            margin: 15px 0 10px 0;
        }
        
        .name-box {
            border: 3px solid #DC2626;
            padding: 18px 35px;
            margin: 10px auto;
            max-width: 550px;
            min-height: 65px;
            background: white;
        }
        
        .participant-name {
            font-size: 28px;
            font-weight: bold;
            color: #1F2937;
            letter-spacing: 1px;
        }
        
        .as-participant {
            font-size: 16px;
            color: #8B5CF6;
            margin: 20px 0 10px 0;
            font-style: italic;
        }
        
        .event-box {
            border: 3px solid #DC2626;
            padding: 22px 35px;
            margin: 10px auto;
            max-width: 650px;
            min-height: 80px;
            background: white;
        }
        
        .event-name {
            font-size: 18px;
            font-weight: bold;
            color: #1F2937;
            line-height: 1.4;
        }
        
        .footer {
            padding: 25px 70px 15px 70px;
            text-align: right;
        }
        
        .signature {
            display: inline-block;
            text-align: center;
        }
        
        .signature-location {
            font-size: 10px;
            color: #4B5563;
            margin-bottom: 3px;
        }
        
        .signature-space {
            margin: 35px 0 8px 0;
        }
        
        .signature-name {
            font-size: 12px;
            font-weight: bold;
            color: #1F2937;
            border-top: 1px solid #1F2937;
            padding-top: 4px;
            min-width: 180px;
            display: inline-block;
        }
        
        .cert-number {
            position: absolute;
            bottom: 15px;
            left: 25px;
            font-size: 8px;
            color: #9CA3AF;
        }
        
        .issue-date {
            position: absolute;
            bottom: 15px;
            right: 25px;
            font-size: 8px;
            color: #9CA3AF;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">
            <div class="apjikom-title">APJIKOM</div>
            <div class="apjikom-subtitle">ASOSIASI PENGELOLA JURNAL INFORMATIKA DAN KOMPUTER INDONESIA</div>
            <div class="apjikom-details">
                S.K. KEMENKUMHAM Nomor AHU-0007794.AH.01.07.TAHUN 2025, Akta Nomor 37 Tanggal 28 Oktober 2025<br>
                Kantor Sekretariat Pusat: Jl. Radin Inten II No.63 A, RT.7/RW.14, Duren Sawit, Kec. Duren Sawit, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13440
            </div>
        </div>

        <div class="content">
            <div class="watermark">APJIKOM</div>
            
            <div class="content-inner">
                <div class="certificate-title">SERTIFIKAT</div>
                
                <div class="given-to">diberikan kepada :</div>
                
                <div class="name-box">
                    <div class="participant-name">{{ strtoupper($user->name) }}</div>
                </div>
                
                <div class="as-participant">Sebagai Peserta Dalam</div>
                
                <div class="event-box">
                    <div class="event-name">{{ $event->title }}</div>
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="signature">
                <div class="signature-location">Jakarta, {{ $issued_date->translatedFormat('d F Y') }}</div>
                <div style="font-size: 10px; color: #4B5563;">Ketua Umum</div>
                <div class="signature-space"></div>
                <div class="signature-name">Prof. Zainal A.Hasibuan, Ir.,MLS, PhD</div>
            </div>
        </div>

        <div class="cert-number">No: {{ $certificate_number }}</div>
        <div class="issue-date">Diterbitkan: {{ $issued_date->translatedFormat('d F Y') }}</div>
    </div>
</body>
</html>
