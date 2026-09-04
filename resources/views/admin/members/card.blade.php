@php
    $cardName = $member->member_number ?: ($member->user->name ?? 'anggota');
    $cardFile = 'kartu-' . \Illuminate\Support\Str::slug($cardName) . '.png';
    // Skala agar kartu muat 1 halaman A4 landscape (~1122x793 px @96dpi, margin 0).
    $pScale = min(1122 / max($tplW, 1), 793 / max($tplH, 1), 1);
    $pScale = round($pScale, 4);
    $pStageW = (int) round($tplW * $pScale);
    $pStageH = (int) round($tplH * $pScale);
@endphp
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kartu Anggota — {{ $cardName }}</title>
<style>
  * { box-sizing: border-box; }
  body { margin: 0; background: #e9e4f1; font-family: system-ui, 'Segoe UI', sans-serif; }
  .bar { position: sticky; top: 0; z-index: 10; display: flex; gap: 10px; align-items: center;
         padding: 12px 18px; background: #fff; border-bottom: 1px solid #e5e0ee; flex-wrap: wrap; }
  .bar .t { font-weight: 700; color: #3b1d5d; font-size: 14px; }
  .bar .s { margin-right: auto; font-size: 13px; color: #555; }
  .bar .s.ok { color: #15803d; font-weight: 600; }
  .bar .s.err { color: #b91c1c; font-weight: 600; }
  .bar button, .bar a { display: inline-flex; align-items: center; gap: 6px; border: 0; cursor: pointer;
         padding: 9px 16px; border-radius: 8px; font-weight: 600; font-size: 13px; text-decoration: none; }
  .b-dl { background: #5a2d8f; color: #fff; }
  .b-dl[disabled] { opacity: .6; cursor: progress; }
  .b-print { background: #eef0f4; color: #333; }
  .b-back { background: transparent; color: #5a2d8f; }
  .wrap { padding: 28px; }
  #cap { width: 100%; }

  @media print {
    @page { size: A4 landscape; margin: 0; }
    html, body { margin: 0; padding: 0; background: #fff; }
    .bar { display: none !important; }
    .wrap { padding: 0 !important; margin: 0 !important; }
    #cap { width: auto !important; }
    #cap [data-ktapj-stage] {
      width: {{ $pStageW }}px !important;
      height: {{ $pStageH }}px !important;
      overflow: hidden !important;
    }
    #cap [data-ktapj-card] {
      transform: scale({{ $pScale }}) !important;
      transform-origin: top left !important;
      box-shadow: none !important;
      -webkit-print-color-adjust: exact !important;
      print-color-adjust: exact !important;
      color-adjust: exact !important;
      page-break-inside: avoid !important;
      break-inside: avoid !important;
    }
  }
</style>
</head>
<body>
  <div class="bar">
    <span class="t">Kartu Anggota &mdash; {{ $cardName }}</span>
    <span class="s" id="status">Menyiapkan unduhan&hellip;</span>
    <button class="b-dl" id="btnDl" onclick="capture(this)">Unduh PNG</button>
    <button class="b-print" onclick="window.print()">Cetak / Simpan PDF</button>
    <a class="b-back" href="{{ route('admin.members.show', $member) }}">Kembali</a>
  </div>

  <div class="wrap">
    <div id="cap">
      @include('member.partials.kartu-anggota')
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script>
    var FILE = @json($cardFile);

    // Muat html2canvas; kalau cdnjs diblokir, coba jsdelivr.
    function loadH2C() {
      return new Promise(function (resolve) {
        if (typeof html2canvas !== 'undefined') return resolve(true);
        var s = document.createElement('script');
        s.src = 'https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js';
        s.onload = function () { resolve(typeof html2canvas !== 'undefined'); };
        s.onerror = function () { resolve(false); };
        document.head.appendChild(s);
      });
    }

    function setStatus(msg, cls) {
      var el = document.getElementById('status');
      el.textContent = msg; el.className = 's' + (cls ? ' ' + cls : '');
    }

    async function capture(btn) {
      var card  = document.querySelector('#cap [data-ktapj-card]');
      var stage = document.querySelector('#cap [data-ktapj-stage]');
      if (!card) { setStatus('Kartu tidak ditemukan.', 'err'); return; }
      if (btn) { btn.disabled = true; btn.textContent = 'Memproses…'; }
      setStatus('Membuat gambar kartu…');
      var ok = await loadH2C();
      if (!ok) {
        setStatus('Pustaka gambar gagal dimuat — pakai tombol "Cetak / Simpan PDF".', 'err');
        if (btn) { btn.disabled = false; btn.textContent = 'Unduh PNG'; }
        return;
      }
      try { if (document.fonts && document.fonts.ready) await document.fonts.ready; } catch (e) {}

      var sv = {
        t: card.style.transform,
        w: stage ? stage.style.width : '', h: stage ? stage.style.height : '',
        o: stage ? stage.style.overflow : ''
      };
      card.style.transform = 'none';
      if (stage) {
        stage.style.overflow = 'visible';
        stage.style.width  = card.offsetWidth + 'px';
        stage.style.height = card.offsetHeight + 'px';
      }
      try {
        var canvas = await html2canvas(card, { scale: 2, useCORS: true, backgroundColor: null, logging: false });
        var a = document.createElement('a');
        a.download = FILE;
        a.href = canvas.toDataURL('image/png');
        document.body.appendChild(a); a.click(); a.remove();
        setStatus('✓ Kartu terunduh (' + FILE + '). Tab ini boleh ditutup.', 'ok');
      } catch (e) {
        setStatus('Gagal membuat PNG — pakai tombol "Cetak / Simpan PDF".', 'err');
      } finally {
        card.style.transform = sv.t;
        if (stage) { stage.style.overflow = sv.o; stage.style.width = sv.w; stage.style.height = sv.h; }
        if (btn) { btn.disabled = false; btn.textContent = 'Unduh PNG'; }
      }
    }

    // Unduh otomatis begitu halaman & aset siap.
    window.addEventListener('load', function () { setTimeout(function () { capture(document.getElementById('btnDl')); }, 700); });
  </script>
</body>
</html>
