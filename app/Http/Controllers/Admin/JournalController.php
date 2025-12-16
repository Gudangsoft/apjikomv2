<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $query = Journal::query();

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('authors', 'like', '%' . $request->search . '%')
                  ->orWhere('keywords', 'like', '%' . $request->search . '%')
                  ->orWhere('abstract', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status == 'published') {
                $query->where('is_published', true);
            } else {
                $query->where('is_published', false);
            }
        }

        // Year filter
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // Date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting
        switch ($request->input('sort', 'latest')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'views':
                $query->orderBy('views', 'desc');
                break;
            case 'downloads':
                $query->orderBy('downloads', 'desc');
                break;
            case 'year':
                $query->orderBy('year', 'desc');
                break;
            default:
                $query->latest();
        }

        $perPage = $request->input('per_page', 15);
        $journals = $query->paginate($perPage)->withQueryString();

        return view('admin.journals.index', compact('journals'));
    }

    public function create()
    {
        return view('admin.journals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'authors' => 'required|string',
            'abstract' => 'required|string',
            'volume' => 'nullable|string|max:50',
            'issue' => 'nullable|string|max:50',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'pages' => 'nullable|string|max:50',
            'doi' => 'nullable|string|max:255',
            'keywords' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf|max:10240',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'published_date' => 'nullable|date',
            'is_published' => 'boolean',
            'category' => 'nullable|string|max:100',
        ]);

        // Upload file PDF
        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('journals', 'public');
        }

        // Upload cover image
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('journal-covers', 'public');
        }

        Journal::create($validated);

        return redirect()->route('admin.journals.index')
            ->with('success', 'Jurnal berhasil ditambahkan!');
    }

    public function show(Journal $journal)
    {
        return view('admin.journals.show', compact('journal'));
    }

    public function edit(Journal $journal)
    {
        return view('admin.journals.edit', compact('journal'));
    }

    public function update(Request $request, Journal $journal)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'authors' => 'required|string',
            'abstract' => 'required|string',
            'volume' => 'nullable|string|max:50',
            'issue' => 'nullable|string|max:50',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'pages' => 'nullable|string|max:50',
            'doi' => 'nullable|string|max:255',
            'keywords' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf|max:10240',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'published_date' => 'nullable|date',
            'is_published' => 'boolean',
            'category' => 'nullable|string|max:100',
        ]);

        // Upload file PDF baru
        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($journal->file_path) {
                Storage::disk('public')->delete($journal->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('journals', 'public');
        }

        // Upload cover image baru
        if ($request->hasFile('cover_image')) {
            // Hapus cover lama
            if ($journal->cover_image) {
                Storage::disk('public')->delete($journal->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('journal-covers', 'public');
        }

        $journal->update($validated);

        return redirect()->route('admin.journals.index')
            ->with('success', 'Jurnal berhasil diperbarui!');
    }

    public function destroy(Journal $journal)
    {
        // Hapus file
        if ($journal->file_path) {
            Storage::disk('public')->delete($journal->file_path);
        }
        
        // Hapus cover
        if ($journal->cover_image) {
            Storage::disk('public')->delete($journal->cover_image);
        }

        $journal->delete();

        return redirect()->route('admin.journals.index')
            ->with('success', 'Jurnal berhasil dihapus!');
    }

    public function download(Journal $journal)
    {
        if (!$journal->file_path) {
            return redirect()->back()->with('error', 'File tidak tersedia!');
        }

        $journal->increment('downloads');

        return Storage::disk('public')->download($journal->file_path, $journal->title . '.pdf');
    }
}
