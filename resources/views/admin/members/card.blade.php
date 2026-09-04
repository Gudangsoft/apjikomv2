<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kartu Anggota — {{ $member->member_number ?: ($member->user->name ?? 'Anggota') }}</title>
<style>
  * { box-sizing: border-box; }
  body { margin: 0; background: #e9e4f1; font-family: system-ui, 'Segoe UI', sans-serif; }
  .bar { position: sticky; top: 0; z-index: 10; display: flex; gap: 10px; align-items: center;
         padding: 12px 18px; background: #fff; border-bottom: 1px solid #e5e0ee; flex-wrap: wrap; }
  .bar .t { font-weight: 700; color: #3b1d5d; margin-right: auto; font-size: 14px; }
  .bar button, .bar a { display: inline-flex; align-items: center; gap: 6px; border: 0; cursor: pointer;
         padding: 9px 16px; border-radius: 8px; font-weight: 600; font-size: 13px; text-decoration: none; }
  .b-dl { background: #5a2d8f; color: #fff; }
  .b-dl[disabled] { opacity: .6; cursor: progress; }
  .b-print { background: #eef0f4; color: #333; }
  .b-back { background: transparent; color: #5a2d8f; }
  .wrap { padding: 28px; display: flex; justify-content: flex-start; overflow-x: auto; }
  #cap { display: inline-block; }
  @media print {
    .bar { display: none !important; }
    body { background: #fff; }
    .wrap { padding: 0; overflow: visible; }
    #cap [data-ktapj-card] { transform: none !important; box-shadow: none !important; }
    #cap [data-ktapj-stage] { height: auto !important; overflow: visible !important; }
  }
</style>
</head>
<body>
  <div class="bar">
    <span class="t">Kartu Anggota &mdash; {{ $member->member_number ?: ($member->user->name ?? '-') }}</span>
    <button class="b-dl" id="btnDl" onclick="dlPng(this)">Download PNG</button>
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
    async function dlPng(btn) {
      var card  = document.querySelector('#cap [data-ktapj-card]');
      var stage = document.querySelector('#cap [data-ktapj-stage]');
      if (!card || typeof html2canvas === 'undefined') { window.print(); return; }
      if (btn) { btn.disabled = true; btn.textContent = 'Memproses…'; }
      if (document.fonts && document.fonts.ready) { try { await document.fonts.ready; } catch (e) {} }

      var saved = {
        t: card.style.transform,
        w: stage ? stage.style.width : '',
        h: stage ? stage.style.height : '',
        o: stage ? stage.style.overflow : ''
      };
      card.style.transform = 'none';
      if (stage) {
        stage.style.overflow = 'visible';
        stage.style.width  = card.offsetWidth + 'px';
        stage.style.height = card.offsetHeight + 'px';
      }
      try {
        var canvas = await html2canvas(card, { scale: 2, useCORS: true, logging: false, backgroundColor: null });
        var a = document.createElement('a');
        a.download = @json('kartu-' . \Illuminate\Support\Str::slug($member->member_number ?: ($member->user->name ?? 'anggota')) . '.png');
        a.href = canvas.toDataURL('image/png');
        document.body.appendChild(a); a.click(); a.remove();
      } catch (e) {
        alert('Gagal membuat PNG. Silakan pakai tombol "Cetak / Simpan PDF".');
      } finally {
        card.style.transform = saved.t;
        if (stage) { stage.style.overflow = saved.o; stage.style.width = saved.w; stage.style.height = saved.h; }
        if (btn) { btn.disabled = false; btn.textContent = 'Download PNG'; }
      }
    }
  </script>
</body>
</html>
