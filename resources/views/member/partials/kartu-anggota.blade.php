{{-- =====================================================================
     Kartu Tanda Anggota APJIKOM — tampilan HTML (live), tanpa chip ATM.
     Butuh variabel $member (App\Models\Member) di scope pemanggil.
     Self-contained: semua class diprefiks .ktapj- agar tidak bentrok
     dengan Tailwind / layout admin maupun member.
     ===================================================================== --}}
@php
    use Illuminate\Support\Facades\Storage;

    $m = $member;
    $namaAnggota  = $m->user->name ?? '-';
    $nomorAnggota = $m->member_number ?: '-';
    $jabatan      = $m->position ?: '-';
    $institusi    = $m->institution_name ?: '-';
    $alamatAnggota = $m->address
        ?: (collect([$m->city, $m->province])->filter()->implode(', ') ?: '-');
    $alamatAnggota = trim(str_replace(["\r\n", "\r", "\n"], ', ', $alamatAnggota));
    // Keanggotaan APJIKOM berlaku seumur hidup (bisa diganti via setting).
    $berlaku = setting('card_berlaku_text', 'Seumur Hidup');

    $fotoUrl = ($m->photo && Storage::disk('public')->exists($m->photo))
        ? Storage::url($m->photo)
        : null;

    $ahu    = setting('org_ahu_number', 'AHU-0007794.AH.01.07.Tahun 2025 tentang Pengesahan Pendirian Perkumpulan Asosiasi Pengelola Jurnal Informatika dan Komputer Indonesia');
    $alamat = setting('contact_address', 'Jl. Watunganten I No.1, Batursari, Kec. Mranggen, Kabupaten Demak, Jawa Tengah 59567');
    $alamat = trim(str_replace(["\r\n", "\r", "\n"], ', ', $alamat));
    $telp   = setting('contact_phone', '+62 822-2372-5276');
    $email  = setting('contact_email', 'sekretariat@apjikom.or.id');

    $webLabel = setting('card_website_label', 'www.apjikom.or.id');
    $fbLabel  = setting('card_facebook_label', 'APJIKOM');
    $igLabel  = setting('card_instagram_label', 'apjikom_id');
    $ytLabel  = setting('card_youtube_label', 'APJIKOM Official');

    // ── Template kartu dari admin (bila sudah di-upload & diaktifkan) ──────
    // Ada template  -> gambar itu jadi latar, hanya data member yang di-overlay.
    // Tidak ada     -> pakai desain vektor HTML penuh (fallback di bawah).
    $tpl = \App\Models\MemberCardTemplate::getActive();
    $tplUrl = null; $tplW = 1200; $tplH = 757;
    if ($tpl && $tpl->template_image && Storage::disk('public')->exists($tpl->template_image)) {
        $tplUrl = Storage::url($tpl->template_image);
        $tplSize = @getimagesize(storage_path('app/public/' . $tpl->template_image));
        if ($tplSize) { $tplW = (int) $tplSize[0]; $tplH = (int) $tplSize[1]; }
    }
    // Overlay ditata seperti kartu contoh. Posisi tiap blok dalam PERSEN.
    // Dibaca LANGSUNG dari tabel settings (tanpa cache) supaya perubahan
    // langsung terlihat tanpa perlu `php artisan cache:clear`.
    $ovRaw = fn ($k) => \App\Models\Setting::query()->where('key', $k)->value('value');
    $ovn = function ($k, $d) use ($ovRaw) { $v = $ovRaw($k); return ($v === null || $v === '') ? (float) $d : (float) $v; };
    $ovs = function ($k, $d) use ($ovRaw) { $v = $ovRaw($k); return ($v === null || $v === '') ? $d : $v; };

    $sx  = $ovn('card_ov_x_shift', 0);   // geser overlay ke kanan (%)
    $sy  = $ovn('card_ov_y_shift', 0);   // geser overlay ke bawah (%)
    $ov  = [
        'photo_w'  => $ovn('card_ov_photo_w', 22),
        'photo_top'=> $ovn('card_ov_photo_top', 25),
        // Titik-tengah foto diukur dari tepi KANAN kartu (%). Kecilkan = geser
        // foto (dan QR) ke kanan; besarkan = ke kiri.
        'photo_cx' => $ovn('card_ov_photo_cx', 16),
        'qr_w'     => $ovn('card_ov_qr_w', 11),
        'qr_left'  => $ovn('card_ov_qr_left', 14),   // QR di kiri, di bawah seal
        'qr_top'   => $ovn('card_ov_qr_top', 34),
        'berlaku_top' => $ovn('card_ov_berlaku_top', 65),  // "Berlaku S/D" di bawah foto
        'font'     => $ovn('card_ov_font_scale', 100),
    ];
    $photoRight = round($ov['photo_cx'] - $ov['photo_w'] / 2 - $sx, 3);
    $ovText   = $ovs('card_ov_text_color', '#20232e');
    $ovLabelC = $ovs('card_ov_label_color', '#5a2d8f');
    $ovShowQr = $ovs('card_ov_show_qr', '1') !== '0';
    $pw = fn ($f) => round($tplW * $f, 2) . 'px';                          // geometri (px)
    $fw = fn ($f) => round($tplW * $f * ($ov['font'] / 100), 2) . 'px';   // font-size (px)
    $L  = fn ($p) => round($p + $sx, 3) . '%';                             // left  + shift
    $T  = fn ($p) => round($p + $sy, 3) . '%';                             // top   + shift

    // QR asli menuju halaman verifikasi keanggotaan (URL literal, aman dari route cache).
    $verifikasiUrl = url('/verifikasi-anggota/' . $m->id);
    $qrSvg = null;
    if (class_exists(\SimpleSoftwareIO\QrCode\Facades\QrCode::class)) {
        try {
            $qrSvg = (string) \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                ->size(240)->margin(1)->errorCorrection('M')->color(35, 38, 47)
                ->generate($verifikasiUrl);
            $qrSvg = preg_replace('/<\?xml.*?\?>\s*/', '', $qrSvg);
        } catch (\Throwable $e) {
            $qrSvg = null;
        }
    }

    // QR dekoratif (fallback bila paket QR belum ter-install) — dibangun di PHP, tanpa JS.
    $qrSeed = 987654321;
    $qrRand = function () use (&$qrSeed) {
        $qrSeed = ($qrSeed * 1103515245 + 12345) & 0x7fffffff;
        return $qrSeed / 0x7fffffff;
    };
    $qrRects = '';
    for ($qy = 0; $qy < 21; $qy++) {
        for ($qx = 0; $qx < 21; $qx++) {
            if ($qx < 8 && $qy < 8) continue;
            if ($qx > 12 && $qy < 8) continue;
            if ($qx < 8 && $qy > 12) continue;
            if ($qx === 6 || $qy === 6) {
                if ((($qx + $qy) % 2) === 0) $qrRects .= "<rect x='{$qx}' y='{$qy}' width='1' height='1'/>";
                continue;
            }
            if ($qrRand() > 0.52) $qrRects .= "<rect x='{$qx}' y='{$qy}' width='1' height='1'/>";
        }
    }
@endphp

<div class="ktapj-stage" data-ktapj-stage>
@if($tplUrl)
{{-- ═══ MODE TEMPLATE: gambar template = latar, hanya data member yang di-overlay ═══ --}}
<div class="ktapj-card ktapj-card--tpl" data-ktapj-card data-w="{{ $tplW }}" data-h="{{ $tplH }}"
     style="width:{{ $tplW }}px; height:{{ $tplH }}px; background:#ffffff url('{{ $tplUrl }}') center center / 100% 100% no-repeat;">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Open+Sans:ital,wght@0,400;0,600;0,700;1,600&display=swap');
    .ktapj-stage { width: 100%; overflow: hidden; }
    .ktapj-card--tpl {
      --accent: {{ $ovLabelC }};
      --ff-display: 'Montserrat', 'Segoe UI', system-ui, sans-serif;
      --ff-body: 'Open Sans', 'Segoe UI', system-ui, sans-serif;
      position: relative; overflow: hidden; transform-origin: top left;
      font-family: var(--ff-body); color: {{ $ovText }}; line-height: 1.3;
    }
    .ktapj-card--tpl * { box-sizing: border-box; margin: 0; }
    .ktb { position: absolute; }
    .ktcol { display: flex; flex-direction: column; }
    .ktov-h1 { font-family: var(--ff-display); font-weight: 800; letter-spacing: .5px; color: #20232e; font-size: {{ $fw(0.028) }}; white-space: nowrap; }
    .ktov-pill { display: inline-block; background: {{ $ovLabelC }}; color: #fff; font-family: var(--ff-display); font-weight: 700; letter-spacing: 1.4px; font-size: {{ $fw(0.0145) }}; padding: {{ $pw(0.0056) }} {{ $pw(0.02) }}; border-radius: 999px; }
    .ktov-tag { font-style: italic; font-weight: 600; color: #4c4657; font-size: {{ $fw(0.0132) }}; margin-top: {{ $pw(0.007) }}; }
    .ktov-div { width: 100%; height: 1.5px; background: #d7cbe8; margin: {{ $pw(0.007) }} 0; }
    .ktov-num { font-family: var(--ff-display); font-weight: 800; letter-spacing: .5px; color: {{ $ovText }}; font-size: {{ $fw(0.028) }}; text-align: left; }
    .ktov-cap { font-family: var(--ff-display); font-weight: 700; letter-spacing: 2.5px; color: #6b6478; font-size: {{ $fw(0.0076) }}; margin-top: {{ $pw(0.003) }}; text-align: left; }
    .ktov-l { font-family: var(--ff-display); font-weight: 700; text-transform: uppercase; letter-spacing: 1.1px; color: {{ $ovLabelC }}; font-size: {{ $fw(0.0099) }}; }
    .ktov-v { font-family: var(--ff-display); font-weight: 700; color: {{ $ovText }}; font-size: {{ $fw(0.0154) }}; line-height: 1.28; }
    .ktov-v.sm { font-family: var(--ff-body); font-weight: 600; font-size: {{ $fw(0.0128) }}; line-height: 1.35; }
    .ktov-clamp { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .ktov-body { color: #201c28; font-weight: 500; line-height: 1.55; font-size: {{ $fw(0.0092) }}; }
    .ktov-ico { display: flex; align-items: flex-start; gap: {{ $pw(0.006) }}; color: #201c28; font-weight: 500; line-height: 1.5; font-size: {{ $fw(0.0092) }}; margin-top: {{ $pw(0.0035) }}; }
    .ktov-ico > svg { flex: none; width: {{ $pw(0.013) }}; height: {{ $pw(0.013) }}; margin-top: {{ $pw(0.0012) }}; }
    .ktov-ico2 { display: flex; flex-wrap: wrap; align-items: center; gap: {{ $pw(0.004) }} {{ $pw(0.017) }}; color: #201c28; font-weight: 500; font-size: {{ $fw(0.0092) }}; margin-top: {{ $pw(0.005) }}; }
    .ktov-ico2 span.i { display: inline-flex; align-items: center; gap: {{ $pw(0.005) }}; }
    .ktov-ico2 svg { flex: none; width: {{ $pw(0.013) }}; height: {{ $pw(0.013) }}; }
    .ktov-sep { position: absolute; width: {{ $pw(0.0016) }}; background: linear-gradient(to bottom, transparent, #cdbce4 10%, #cdbce4 90%, transparent); }
    .ktov-photo { width: 100%; aspect-ratio: 3 / 3.3; object-fit: cover; border-radius: {{ $pw(0.007) }}; border: {{ $pw(0.0022) }} solid {{ $ovLabelC }}; background: #e7e2ef; display: block; }
    .ktov-ph { display: flex; align-items: center; justify-content: center; font-family: var(--ff-display); font-weight: 700; letter-spacing: 1px; color: #7a7091; font-size: {{ $fw(0.008) }}; }
    .ktov-qr { width: 100%; aspect-ratio: 1/1; background: #fff; padding: {{ $pw(0.004) }}; border-radius: {{ $pw(0.005) }}; border: {{ $pw(0.0022) }} solid {{ $ovLabelC }}; }
    .ktov-qr svg { display: block; width: 100%; height: 100%; }
    .ktapj-qr-fallback rect, .ktapj-qr-fallback path { fill: {{ $ovText }}; }
    @media print {
      .ktapj-stage { overflow: visible !important; height: auto !important; }
      .ktapj-card--tpl { transform: none !important; }
    }
  </style>

  {{-- Judul — sejajar kiri dengan pill / nomor di bawahnya --}}
  <div class="ktb ktov-h1" style="left:{{ $L(29) }}; top:{{ $T(33) }};">KARTU TANDA ANGGOTA</div>

  {{-- Blok tengah: pill, tagline, garis, nomor anggota --}}
  <div class="ktb ktcol" style="left:{{ $L(29) }}; top:{{ $T(39) }}; width:39%; align-items:flex-start;">
    <span class="ktov-pill">ANGGOTA APJIKOM</span>
    <div class="ktov-tag">Bersama Mengelola Jurnal, Membangun Bangsa</div>
    <div class="ktov-div"></div>
    <div style="width:100%;">
      <div class="ktov-num">{{ $nomorAnggota }}</div>
      <div class="ktov-cap">NOMOR ANGGOTA</div>
    </div>
  </div>

  {{-- Data member (kiri bawah) --}}
  <div class="ktb ktcol" style="left:{{ $L(8.5) }}; top:{{ $T(56.5) }}; width:22%; gap:{{ $pw(0.0105) }};">
    <div><div class="ktov-l">Nama</div><div class="ktov-v">{{ $namaAnggota }}</div></div>
    <div><div class="ktov-l">Jabatan / Profesi</div><div class="ktov-v">{{ $jabatan }}</div></div>
    <div><div class="ktov-l">Institusi</div><div class="ktov-v ktov-clamp">{{ $institusi }}</div></div>
    <div><div class="ktov-l">Alamat</div><div class="ktov-v sm ktov-clamp">{{ $alamatAnggota }}</div></div>
  </div>

  {{-- Berlaku S/D — di bawah foto --}}
  <div class="ktb ktcol" style="right:{{ $photoRight }}%; top:{{ $T($ov['berlaku_top']) }}; width:{{ $ov['photo_w'] }}%; align-items:flex-start;">
    <div class="ktov-l">Berlaku S/D</div>
    <div class="ktov-v">{{ $berlaku }}</div>
  </div>

  {{-- Garis pembatas: biodata (kiri) | bagian kanan --}}
  <div class="ktov-sep" style="left:{{ $L(31.5) }}; top:{{ $T(57.5) }}; height:33%;"></div>

  {{-- Nomor AHU + Kantor Sekretariat (tengah bawah) --}}
  <div class="ktb ktcol" style="left:{{ $L(33.5) }}; top:{{ $T(62) }}; width:32%; gap:{{ $pw(0.014) }};">
    <div>
      <div class="ktov-l">Nomor AHU</div>
      <div class="ktov-body">{{ $ahu }}</div>
    </div>
    <div>
      <div class="ktov-l">Kantor Sekretariat:</div>
      <div class="ktov-ico">
        <svg viewBox="0 0 24 24" fill="none" stroke="{{ $ovLabelC }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s7-6.5 7-12A7 7 0 0 0 5 10c0 5.5 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/></svg>
        <span>{{ $alamat }}</span>
      </div>
      <div class="ktov-ico2">
        <span class="i"><svg viewBox="0 0 24 24" fill="{{ $ovLabelC }}"><path d="M6.6 10.8a15.5 15.5 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11.4 11.4 0 0 0 3.5.56 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.2.2 2.4.56 3.5a1 1 0 0 1-.25 1z"/></svg><span>{{ $telp }}</span></span>
        <span class="i"><svg viewBox="0 0 24 24" fill="none" stroke="{{ $ovLabelC }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4.5" width="20" height="15" rx="2.5"/><path d="M3 7l9 6 9-6"/></svg><span>{{ $email }}</span></span>
      </div>
    </div>
  </div>

  {{-- Foto (kanan atas) --}}
  <div class="ktb" style="right:{{ $photoRight }}%; top:{{ $T($ov['photo_top']) }}; width:{{ $ov['photo_w'] }}%;">
    @if($fotoUrl)
      <img class="ktov-photo" src="{{ $fotoUrl }}" alt="Foto {{ $namaAnggota }}">
    @else
      <div class="ktov-photo ktov-ph">FOTO</div>
    @endif
  </div>

  @if($ovShowQr)
  {{-- QR + verifikasi — kiri, di bawah seal --}}
  <div class="ktb ktcol" style="left:{{ $L($ov['qr_left']) }}; top:{{ $T($ov['qr_top']) }}; align-items:flex-start; gap:{{ $pw(0.006) }};">
    <div class="ktov-qr" style="width:{{ $pw($ov['qr_w'] / 100) }};">
      @if($qrSvg)
        {!! $qrSvg !!}
      @else
        <svg class="ktapj-qr-fallback" width="100%" height="100%" viewBox="0 0 21 21" shape-rendering="crispEdges" xmlns="http://www.w3.org/2000/svg">
          <g><path d="M0 0h7v7h-7z M1 1v5h5v-5z" fill-rule="evenodd"/><rect x="2" y="2" width="3" height="3"/></g>
          <g transform="translate(14 0)"><path d="M0 0h7v7h-7z M1 1v5h5v-5z" fill-rule="evenodd"/><rect x="2" y="2" width="3" height="3"/></g>
          <g transform="translate(0 14)"><path d="M0 0h7v7h-7z M1 1v5h5v-5z" fill-rule="evenodd"/><rect x="2" y="2" width="3" height="3"/></g>
          {!! $qrRects !!}
        </svg>
      @endif
    </div>
    <div>
      <div style="font-family:var(--ff-display); font-weight:700; letter-spacing:1.2px; color:#2b2b33; font-size:{{ $fw(0.0082) }}; line-height:1.25;">VERIFIKASI ANGGOTA</div>
      <div style="display:flex; align-items:center; gap:{{ $pw(0.004) }}; margin-top:{{ $pw(0.004) }};">
        <svg width="{{ $pw(0.015) }}" height="{{ $pw(0.015) }}" viewBox="0 0 24 24"><path d="M12 2l8 3v6c0 5.1-3.4 9.4-8 11-4.6-1.6-8-5.9-8-11V5z" fill="{{ $ovLabelC }}"/><path d="M8.3 12.2l2.6 2.6 4.8-5.4" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <span style="font-family:var(--ff-display); font-weight:700; color:{{ $ovLabelC }}; font-size:{{ $fw(0.0082) }};">TERDAFTAR RESMI</span>
      </div>
    </div>
  </div>
  @endif
</div>
@else
<div class="ktapj-card" data-ktapj-card data-w="1200" data-h="757">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Open+Sans:ital,wght@0,400;0,600;0,700;1,600&display=swap');
    .ktapj-stage { width: 100%; overflow: hidden; }
    .ktapj-card {
      --accent: #5a2d8f; --accent-dark: #4c2678; --accent-deep: #3b1d5d; --accent-soft: #d6cbe3;
      --ff-display: 'Montserrat', 'Segoe UI', system-ui, sans-serif;
      --ff-body: 'Open Sans', 'Segoe UI', system-ui, sans-serif;
      position: relative; width: 1200px; height: 757px; overflow: hidden; border-radius: 30px;
      transform-origin: top left;
      background: linear-gradient(135deg, #fbf9fd 0%, #f2ecf8 52%, #e9dff5 100%);
      box-shadow: 0 30px 70px -22px rgba(59, 29, 93, .5);
      color: #23262f; font-family: var(--ff-body);
      line-height: 1.4;
    }
    .ktapj-card, .ktapj-card * { box-sizing: border-box; }
    .ktapj-card p, .ktapj-card div, .ktapj-card span { margin: 0; }
    .ktapj-layer { position: absolute; inset: 0; }
    .ktapj-main {
      position: absolute; left: 0; top: 0; bottom: 46px; right: 372px; z-index: 3;
      padding: 32px 0 20px 46px; display: flex; flex-direction: column; gap: 10px;
    }
    .ktapj-side {
      position: absolute; top: 34px; right: 40px; bottom: 60px; width: 318px; z-index: 3;
      display: flex; flex-direction: column; align-items: flex-end; gap: 26px;
    }
    .ktapj-footer {
      position: absolute; left: 0; right: 0; bottom: 0; height: 46px; z-index: 4;
      display: flex; align-items: center; justify-content: space-between; gap: 18px; padding: 0 54px;
      background: linear-gradient(90deg, var(--accent-deep), var(--accent)); color: #fff;
    }
    .ktapj-brand { display: flex; align-items: center; gap: 16px; }
    .ktapj-ico { display: inline-flex; flex: none; }
    .ktapj-fitem { display: flex; align-items: flex-start; gap: 9px; }
    .ktapj-fnav { display: flex; align-items: center; gap: 9px; font: 600 12.5px var(--ff-body); letter-spacing: .3px; }
    .ktapj-label { font-family: var(--ff-display); font-weight: 700; font-size: 11px; letter-spacing: 1.3px; color: var(--accent); }
    .ktapj-value { font-weight: 700; font-size: 16px; color: #23262f; letter-spacing: .3px; }
    .ktapj-qr svg { display: block; width: 100%; height: 100%; }
    .ktapj-qr-fallback rect, .ktapj-qr-fallback path { fill: #23262f; }
    @media print {
      .ktapj-stage { overflow: visible !important; height: auto !important; }
      .ktapj-card { transform: none !important; box-shadow: none; }
    }
  </style>

  <!-- decorative circuitry -->
  <svg class="ktapj-layer" width="100%" height="100%" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" style="opacity:.5">
    <defs>
      <pattern id="ktapjCircuit" width="94" height="94" patternUnits="userSpaceOnUse">
        <g fill="none" stroke="#d9cee9" stroke-width="1">
          <path d="M12 12 H44 V38 H70"/><path d="M74 6 V26 H58 V60"/>
          <path d="M40 84 H62 V64 H88"/><path d="M6 60 H26 V78"/>
        </g>
        <g fill="#cdbfe4">
          <circle cx="12" cy="12" r="2.3"/><circle cx="70" cy="38" r="2.3"/>
          <circle cx="58" cy="60" r="2.3"/><circle cx="26" cy="78" r="2.3"/><circle cx="88" cy="64" r="2.3"/>
        </g>
      </pattern>
    </defs>
    <rect width="100%" height="100%" fill="url(#ktapjCircuit)"/>
  </svg>

  <svg class="ktapj-layer" style="width:300px;height:210px" viewBox="0 0 300 210" xmlns="http://www.w3.org/2000/svg">
    <path d="M0 0 H236 C196 66 150 104 92 132 C44 156 16 182 0 210 Z" fill="var(--accent)"/>
    <path d="M0 0 H150 C124 46 96 74 52 96 C24 110 8 140 0 166 Z" fill="var(--accent-deep)" opacity=".55"/>
  </svg>
  <svg class="ktapj-layer" style="left:120px;top:-70px;width:760px;height:300px" viewBox="0 0 760 300" xmlns="http://www.w3.org/2000/svg">
    <ellipse cx="380" cy="80" rx="420" ry="150" fill="var(--accent-soft)" opacity=".26"/>
  </svg>
  <svg class="ktapj-layer" style="top:auto;bottom:46px;left:0;width:140px;height:52px" viewBox="0 0 140 52" xmlns="http://www.w3.org/2000/svg">
    <path d="M0 52 H132 C100 34 54 16 0 10 Z" fill="var(--accent)" opacity=".85"/>
    <path d="M0 52 H86 C64 40 36 28 0 22 Z" fill="var(--accent-deep)" opacity=".5"/>
  </svg>
  <svg class="ktapj-layer" style="left:auto;top:auto;right:30px;bottom:58px;width:78px;height:46px" viewBox="0 0 78 46" xmlns="http://www.w3.org/2000/svg">
    <g fill="var(--accent)" opacity=".5">
      <circle cx="6" cy="6" r="3"/><circle cx="24" cy="6" r="3"/><circle cx="42" cy="6" r="3"/><circle cx="60" cy="6" r="3"/><circle cx="73" cy="6" r="3"/>
      <circle cx="6" cy="24" r="3"/><circle cx="24" cy="24" r="3"/><circle cx="42" cy="24" r="3"/><circle cx="60" cy="24" r="3"/><circle cx="73" cy="24" r="3"/>
      <circle cx="6" cy="40" r="3"/><circle cx="24" cy="40" r="3"/><circle cx="42" cy="40" r="3"/><circle cx="60" cy="40" r="3"/><circle cx="73" cy="40" r="3"/>
    </g>
  </svg>

  <!-- ================= MAIN COLUMN ================= -->
  <div class="ktapj-main">

    <div class="ktapj-brand">
      <svg width="90" height="90" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="flex:none">
        <defs><path id="ktapjSealArc" d="M50 50 m0 -37 a37 37 0 1 1 -0.01 0" fill="none"/></defs>
        <circle cx="50" cy="50" r="49" fill="var(--accent)"/>
        <circle cx="50" cy="50" r="41.5" fill="#ffffff"/>
        <circle cx="50" cy="50" r="39.5" fill="none" stroke="var(--accent)" stroke-width="1"/>
        <text font-family="Montserrat, sans-serif" font-size="5.1" font-weight="700" letter-spacing="0.32" fill="var(--accent-deep)">
          <textPath href="#ktapjSealArc" xlink:href="#ktapjSealArc" startOffset="1%">ASOSIASI PENGELOLA JURNAL INFORMATIKA DAN KOMPUTER INDONESIA</textPath>
        </text>
        <g transform="translate(50 45)">
          <g fill="var(--accent)">
            <circle cx="-11" cy="-13" r="2.3"/><circle cx="0" cy="-17" r="2.3"/><circle cx="11" cy="-13" r="2.3"/>
            <circle cx="-15" cy="-5" r="1.9"/><circle cx="15" cy="-5" r="1.9"/>
          </g>
          <g stroke="var(--accent)" stroke-width="1">
            <line x1="-11" y1="-13" x2="0" y2="-17"/><line x1="0" y1="-17" x2="11" y2="-13"/>
            <line x1="-11" y1="-13" x2="-15" y2="-5"/><line x1="11" y1="-13" x2="15" y2="-5"/>
            <line x1="0" y1="-17" x2="0" y2="-7"/>
          </g>
          <path d="M-17 3 Q-9 -1 0 3 L0 15 Q-9 11 -17 15 Z" fill="var(--accent)"/>
          <path d="M17 3 Q9 -1 0 3 L0 15 Q9 11 17 15 Z" fill="var(--accent-dark)"/>
          <rect x="-4.5" y="-8" width="9" height="13" rx="4.5" fill="#fff" stroke="var(--accent)" stroke-width="1.2"/>
          <line x1="0" y1="-8" x2="0" y2="-2.5" stroke="var(--accent)" stroke-width="1.2"/>
        </g>
        <text x="50" y="90" text-anchor="middle" font-family="Montserrat, sans-serif" font-size="8.5" font-weight="800" fill="var(--accent-deep)">APJIKOM</text>
      </svg>
      <div>
        <div style="font-family:var(--ff-display); font-weight:800; font-size:64px; line-height:1; letter-spacing:.5px; color:var(--accent);">APJIKOM</div>
        <div style="font-weight:700; font-size:12px; line-height:1.3; color:#3f3a48; letter-spacing:.2px; margin-top:4px;">Asosiasi Pengelola Jurnal<br>Informatika dan Komputer Indonesia</div>
      </div>
    </div>

    <div style="font-family:var(--ff-display); font-weight:800; font-size:33px; letter-spacing:.5px; color:#20232e; margin-top:2px;">KARTU TANDA ANGGOTA</div>

    <div>
      <span style="display:inline-block; background:var(--accent); color:#fff; font-family:var(--ff-display); font-weight:700; font-size:16px; letter-spacing:1.5px; padding:9px 30px; border-radius:999px; box-shadow:0 8px 18px -6px rgba(59, 29, 93, .55);">ANGGOTA APJIKOM</span>
    </div>

    <div style="font-style:italic; font-weight:600; font-size:15px; color:#4c4657;">Bersama Mengelola Jurnal, Membangun Bangsa</div>

    <div style="width:66%; height:1.5px; background:#d7cbe8; margin:3px 0;"></div>

    <div style="width:86%; text-align:center;">
      <div style="font-family:var(--ff-display); font-weight:700; font-size:28px; letter-spacing:1px; color:#23262f;">{{ $nomorAnggota }}</div>
      <div style="font-weight:700; font-size:11px; letter-spacing:2.5px; color:#6b6478; margin-top:4px;">NOMOR ANGGOTA</div>
    </div>

    <div style="display:flex; gap:26px; margin-top:10px;">
      <div style="width:252px; display:flex; flex-direction:column; gap:12px;">
        <div>
          <div class="ktapj-label">NAMA</div>
          <div class="ktapj-value">{{ $namaAnggota }}</div>
        </div>
        <div>
          <div class="ktapj-label">JABATAN / PROFESI</div>
          <div class="ktapj-value">{{ $jabatan }}</div>
        </div>
        <div>
          <div class="ktapj-label">INSTITUSI</div>
          <div class="ktapj-value" style="line-height:1.3; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $institusi }}</div>
        </div>
        <div>
          <div class="ktapj-label">ALAMAT</div>
          <div class="ktapj-value" style="font-weight:600; font-size:13px; line-height:1.35; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $alamatAnggota }}</div>
        </div>
        <div>
          <div class="ktapj-label">BERLAKU S/D</div>
          <div class="ktapj-value">{{ $berlaku }}</div>
        </div>
      </div>

      <div style="flex:1; display:flex; flex-direction:column; gap:14px;">
        <div>
          <div class="ktapj-label" style="margin-bottom:3px;">NOMOR AHU</div>
          <div style="font-size:11.5px; line-height:1.5; color:#3a3742; max-width:400px;">{{ $ahu }}</div>
        </div>
        <div>
          <div class="ktapj-label" style="margin-bottom:5px;">KANTOR SEKRETARIAT</div>
          <div class="ktapj-fitem" style="font-size:11.5px; line-height:1.45; color:#3a3742; max-width:400px;">
            <span class="ktapj-ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s7-6.5 7-12A7 7 0 0 0 5 10c0 5.5 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/></svg></span>
            <span>{{ $alamat }}</span>
          </div>
          <div style="display:flex; gap:20px; margin-top:6px; font-size:11.5px; color:#3a3742; flex-wrap:wrap;">
            <span class="ktapj-fitem" style="align-items:center;"><span class="ktapj-ico"><svg width="13" height="13" viewBox="0 0 24 24" fill="var(--accent)"><path d="M6.6 10.8a15.5 15.5 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11.4 11.4 0 0 0 3.5.56 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.2.2 2.4.56 3.5a1 1 0 0 1-.25 1z"/></svg></span><span>{{ $telp }}</span></span>
            <span class="ktapj-fitem" style="align-items:center;"><span class="ktapj-ico"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4.5" width="20" height="15" rx="2.5"/><path d="M3 7l9 6 9-6"/></svg></span><span>{{ $email }}</span></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ================= SIDE COLUMN ================= -->
  <div class="ktapj-side">

    <div style="text-align:right;">
      <div style="font-family:var(--ff-display); font-weight:700; font-size:13px; letter-spacing:2px; color:#2b2b33;">BANK PARTNER</div>
      <div style="display:flex; align-items:center; gap:10px; margin-top:7px; justify-content:flex-end;">
        <span style="width:46px; height:46px; border:1.5px dashed #b7afc4; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:8px; font-weight:700; color:#9a92a6; letter-spacing:.5px;">LOGO</span>
        <span style="font-family:var(--ff-display); font-weight:800; font-size:31px; color:#1f3a63; letter-spacing:.5px;">BNI</span>
      </div>
      <div style="font-size:9px; color:#6b6478; margin-top:4px;">Melayani Negeri, Kebanggaan Bangsa</div>
    </div>

    <div style="width:210px; height:262px; border-radius:14px; border:3px solid var(--accent); background:linear-gradient(160deg, #eee9f5, #ded4ec); overflow:hidden; box-shadow:0 12px 26px -12px rgba(59, 29, 93, .5); position:relative;">
      @if($fotoUrl)
        <img src="{{ $fotoUrl }}" alt="Foto {{ $namaAnggota }}" style="width:100%; height:100%; object-fit:cover; display:block;">
      @else
        <svg width="100%" height="100%" viewBox="0 0 120 148" preserveAspectRatio="xMidYMax meet" xmlns="http://www.w3.org/2000/svg">
          <circle cx="60" cy="52" r="24" fill="#b9aed6"/>
          <path d="M18 150 C20 108 38 86 60 86 C82 86 100 108 102 150 Z" fill="#b9aed6"/>
        </svg>
        <span style="position:absolute; left:0; right:0; bottom:7px; text-align:center; font-size:8.5px; letter-spacing:1.5px; color:#7a7091; font-weight:700;">FOTO ANGGOTA</span>
      @endif
    </div>

    <div style="display:flex; align-items:center; gap:14px;">
      <div class="ktapj-qr" style="width:90px; height:90px; border-radius:10px; border:3px solid var(--accent); background:#fff; padding:6px;">
        @if($qrSvg)
          {!! $qrSvg !!}
        @else
          <svg class="ktapj-qr-fallback" width="100%" height="100%" viewBox="0 0 21 21" shape-rendering="crispEdges" xmlns="http://www.w3.org/2000/svg">
            <g><path d="M0 0h7v7h-7z M1 1v5h5v-5z" fill-rule="evenodd"/><rect x="2" y="2" width="3" height="3"/></g>
            <g transform="translate(14 0)"><path d="M0 0h7v7h-7z M1 1v5h5v-5z" fill-rule="evenodd"/><rect x="2" y="2" width="3" height="3"/></g>
            <g transform="translate(0 14)"><path d="M0 0h7v7h-7z M1 1v5h5v-5z" fill-rule="evenodd"/><rect x="2" y="2" width="3" height="3"/></g>
            {!! $qrRects !!}
          </svg>
        @endif
      </div>
      <div style="text-align:left;">
        <div style="font-family:var(--ff-display); font-weight:700; font-size:12.5px; letter-spacing:1.4px; color:#2b2b33; line-height:1.3; max-width:132px;">VERIFIKASI ANGGOTA</div>
        <div style="display:flex; align-items:center; gap:6px; margin-top:8px;">
          <span class="ktapj-ico"><svg width="21" height="21" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2l8 3v6c0 5.1-3.4 9.4-8 11-4.6-1.6-8-5.9-8-11V5z" fill="var(--accent)"/><path d="M8.3 12.2l2.6 2.6 4.8-5.4" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
          <span style="font-family:var(--ff-display); font-weight:700; font-size:12.5px; color:var(--accent);">TERDAFTAR RESMI</span>
        </div>
      </div>
    </div>
  </div>

  <!-- ================= FOOTER ================= -->
  <div class="ktapj-footer">
    <span class="ktapj-fnav"><span class="ktapj-ico"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c3 3.2 3 14.8 0 18M12 3c-3 3.2-3 14.8 0 18"/></svg></span><span>{{ $webLabel }}</span></span>
    <span class="ktapj-fnav"><span class="ktapj-ico"><svg width="15" height="15" viewBox="0 0 24 24" fill="#fff"><path d="M13.5 21v-8h2.7l.4-3.1h-3.1V7.9c0-.9.25-1.5 1.55-1.5H17V3.6c-.3-.04-1.3-.13-2.5-.13-2.5 0-4.2 1.5-4.2 4.3v2.4H7.5V13h2.8v8z"/></svg></span><span>{{ $fbLabel }}</span></span>
    <span class="ktapj-fnav"><span class="ktapj-ico"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17" cy="7" r="1.2" fill="#fff" stroke="none"/></svg></span><span>{{ $igLabel }}</span></span>
    <span class="ktapj-fnav"><span class="ktapj-ico"><svg width="15" height="15" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="4.5" fill="#fff"/><path d="M10 8.5l6 3.5-6 3.5z" fill="var(--accent)"/></svg></span><span>{{ $ytLabel }}</span></span>
  </div>

</div>
@endif
</div>

<script>
(function () {
  function fitKtapj() {
    document.querySelectorAll('[data-ktapj-stage]').forEach(function (stage) {
      var card = stage.querySelector('[data-ktapj-card]');
      if (!card) return;
      var baseW = parseFloat(card.getAttribute('data-w')) || 1200;
      var baseH = parseFloat(card.getAttribute('data-h')) || 757;
      var scale = Math.min(1, stage.clientWidth / baseW);
      card.style.transform = 'scale(' + scale + ')';
      stage.style.height = Math.round(baseH * scale) + 'px';
    });
  }
  fitKtapj();
  window.addEventListener('resize', fitKtapj);
  if (document.fonts && document.fonts.ready) { document.fonts.ready.then(fitKtapj); }
  setTimeout(fitKtapj, 400);
})();
</script>
