@if(session()->has('impersonator_id') && auth()->check())
<div class="w-full bg-amber-500 text-white text-sm font-medium px-4 py-2 flex flex-wrap items-center justify-center gap-3 relative z-50">
    <span>
        🔎 Anda login sebagai <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }})
    </span>
    <form action="{{ route('impersonate.stop') }}" method="POST" class="inline-block">
        @csrf
        <button type="submit" class="px-3 py-1 bg-white text-amber-700 rounded-full font-semibold hover:bg-amber-50 transition">
            Kembali ke Admin
        </button>
    </form>
</div>
@endif
