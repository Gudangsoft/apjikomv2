<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Sertifikat - {{ $event->title }}</title>
    <style>
        @page {
            margin: 0;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            width: 100vw;
        }
        
        .certificate-container {
            position: relative;
            width: 100%;
            height: 100%;
            background: white;
            padding: 40px;
            box-sizing: border-box;
        }
        
        .border-outer {
            border: 3px solid #6B46C1;
            padding: 20px;
            height: calc(100% - 80px);
            box-sizing: border-box;
        }
        
        .border-inner {
            border: 1px solid #9F7AEA;
            padding: 30px;
            height: 100%;
            box-sizing: border-box;
            position: relative;
        }
        
        .corner-decoration {
            position: absolute;
            width: 60px;
            height: 60px;
            border: 3px solid #6B46C1;
        }
        
        .corner-tl {
            top: 10px;
            left: 10px;
            border-right: none;
            border-bottom: none;
        }
        
        .corner-tr {
            top: 10px;
            right: 10px;
            border-left: none;
            border-bottom: none;
        }
        
        .corner-bl {
            bottom: 10px;
            left: 10px;
            border-right: none;
            border-top: none;
        }
        
        .corner-br {
            bottom: 10px;
            right: 10px;
            border-left: none;
            border-top: none;
        }
        
        .content {
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .header-text {
            font-size: 14px;
            color: #718096;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .title {
            font-size: 42px;
            font-weight: bold;
            color: #6B46C1;
            margin: 10px 0;
            letter-spacing: 5px;
        }
        
        .subtitle {
            font-size: 14px;
            color: #718096;
            margin-bottom: 30px;
        }
        
        .certifies-text {
            font-size: 14px;
            color: #4A5568;
            margin-bottom: 15px;
        }
        
        .participant-name {
            font-size: 32px;
            font-weight: bold;
            color: #2D3748;
            margin: 10px 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #6B46C1;
            display: inline-block;
        }
        
        .description {
            font-size: 14px;
            color: #4A5568;
            line-height: 1.6;
            max-width: 80%;
            margin: 0 auto 20px auto;
        }
        
        .event-title {
            font-size: 18px;
            font-weight: bold;
            color: #6B46C1;
            margin: 15px 0;
        }
        
        .event-details {
            font-size: 12px;
            color: #718096;
            margin-bottom: 30px;
        }
        
        .footer {
            margin-top: 30px;
        }
        
        .signature-section {
            display: flex;
            justify-content: space-between;
            padding: 0 80px;
            margin-top: 30px;
        }
        
        .signature-box {
            text-align: center;
            width: 200px;
        }
        
        .signature-line {
            border-top: 1px solid #2D3748;
            margin-bottom: 5px;
            margin-top: 50px;
        }
        
        .signature-name {
            font-size: 12px;
            font-weight: bold;
            color: #2D3748;
        }
        
        .signature-title {
            font-size: 10px;
            color: #718096;
        }
        
        .certificate-number {
            position: absolute;
            bottom: 15px;
            left: 30px;
            font-size: 10px;
            color: #A0AEC0;
        }
        
        .issue-date {
            position: absolute;
            bottom: 15px;
            right: 30px;
            font-size: 10px;
            color: #A0AEC0;
        }
        
        .organization-name {
            font-size: 16px;
            font-weight: bold;
            color: #6B46C1;
            margin-bottom: 5px;
        }
        
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 120px;
            color: rgba(107, 70, 193, 0.03);
            font-weight: bold;
            z-index: 0;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="border-outer">
            <div class="border-inner">
                <div class="corner-decoration corner-tl"></div>
                <div class="corner-decoration corner-tr"></div>
                <div class="corner-decoration corner-bl"></div>
                <div class="corner-decoration corner-br"></div>
                
                <div class="watermark">APJIKOM</div>
                
                <div class="content">
                    <div class="organization-name">{{ site_name() }}</div>
                    <div class="header-text">Dengan Bangga Memberikan</div>
                    <div class="title">SERTIFIKAT</div>
                    <div class="subtitle">Keikutsertaan Event</div>
                    
                    <div class="certifies-text">Diberikan kepada:</div>
                    <div class="participant-name">{{ $user->name }}</div>
                    
                    <div class="description">
                        Telah berpartisipasi dalam kegiatan yang diselenggarakan oleh {{ site_name() }}
                    </div>
                    
                    <div class="event-title">"{{ $event->title }}"</div>
                    
                    <div class="event-details">
                        @if($event->location)
                            {{ $event->location }} • 
                        @endif
                        {{ $event->event_date->translatedFormat('d F Y') }}
                        @if($event->event_time)
                            • {{ date('H:i', strtotime($event->event_time)) }} WIB
                        @endif
                    </div>
                    
                    <table style="width: 100%; margin-top: 20px;">
                        <tr>
                            <td style="width: 33%; text-align: center;"></td>
                            <td style="width: 34%; text-align: center;"></td>
                            <td style="width: 33%; text-align: center;">
                                <div style="font-size: 11px; color: #718096; margin-bottom: 40px;">
                                    {{ $issued_date->translatedFormat('d F Y') }}
                                </div>
                                <div style="border-top: 1px solid #2D3748; display: inline-block; padding-top: 5px; min-width: 150px;">
                                    <div style="font-size: 12px; font-weight: bold; color: #2D3748;">Ketua APJIKOM</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <div class="certificate-number">No: {{ $certificate_number }}</div>
                <div class="issue-date">Diterbitkan: {{ $issued_date->translatedFormat('d F Y') }}</div>
            </div>
        </div>
    </div>
</body>
</html>
