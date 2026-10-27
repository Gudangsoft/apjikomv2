<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cooperation;
use App\Models\CooperationPhoto;
use Illuminate\Http\Request;

class CooperationPhotoController extends Controller
{
    /**
     * Halaman kelola galeri foto satu kerjasama.
     */
    public function index(Cooperation $cooperation)
    {
        $photos = $cooperation->photos()->ordered()->get();

        return view('admin.cooperations.photos', compact('cooperation', 'photos'));
    }

    /**
     * Upload beberapa foto sekaligus ke galeri kerjasama ini.
     */
    public function store(Request $request, Cooperation $cooperation)
    {
        $request->validate([
            'photos' => 'required|array|min:1',
            'photos.*' => 'image|mimes:jpeg,jpg,png,webp|max:4096',
        ], [
            'photos.*.image' => 'Setiap file harus berupa gambar (JPG, PNG, atau WebP).',
            'photos.*.max' => 'Ukuran tiap foto maksimal 4MB.',
        ]);

        $nextOrder = (int) $cooperation->photos()->max('order') + 1;

        foreach ($request->file('photos') as $file) {
            $path = $file->store('cooperations/gallery', 'public');

            CooperationPhoto::create([
                'cooperation_id' => $cooperation->id,
                'photo' => $path,
                'order' => $nextOrder++,
            ]);
        }

        $count = count($request->file('photos'));

        return back()->with('success', "{$count} foto berhasil ditambahkan ke galeri.");
    }

    /**
     * Update caption satu foto.
     */
    public function update(Request $request, Cooperation $cooperation, CooperationPhoto $photo)
    {
        abort_unless($photo->cooperation_id === $cooperation->id, 404);

        $validated = $request->validate([
            'caption' => 'nullable|string|max:255',
        ]);

        $photo->update($validated);

        return back()->with('success', 'Keterangan foto berhasil disimpan.');
    }

    /**
     * Hapus satu foto dari galeri.
     */
    public function destroy(Cooperation $cooperation, CooperationPhoto $photo)
    {
        abort_unless($photo->cooperation_id === $cooperation->id, 404);

        $photo->delete();

        return back()->with('success', 'Foto berhasil dihapus dari galeri.');
    }
}
