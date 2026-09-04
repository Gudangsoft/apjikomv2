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
  .b-print { background: #5a2d8f; color: #fff; }
  .b-back { background: transparent; color: #5a2d8f; }
  .wrap { padding: 28px; display: flex; justify-content: flex-start; overflow-x: auto; }
  #cap { display: inline-block; }
  @media print {
    .bar { display: none !important; }
    body { background: #fff; }
    .wrap { padding: 0; overflow: visible; }
    #cap [data-ktapj-card] { transform: none !important; box-shadow: none !important; }
    #cap [data-ktapj-stage] { height: auto !important; overflow: visible !important; }
    @page { size: landscape; margin: 8mm; }
  }
</style>
</head>
<body>
  <div class="bar">
    <span class="t">Kartu Anggota &mdash; {{ $member->member_number ?: ($member->user->name ?? '-') }}</span>
    <button class="b-print" onclick="window.print()">Cetak / Simpan PDF</button>
    <a class="b-back" href="{{ route('admin.members.show', $member) }}">Kembali</a>
  </div>

  <div class="wrap">
    <div id="cap">
      @include('member.partials.kartu-anggota')
    </div>
  </div>

  <script>
    // Langsung buka dialog cetak / simpan PDF setelah font & gambar siap.
    window.addEventListener('load', function () {
      var go = function () { setTimeout(function () { window.print(); }, 350); };
      if (document.fonts && document.fonts.ready) { document.fonts.ready.then(go, go); }
      else { go(); }
    });
  </script>
</body>
</html>
