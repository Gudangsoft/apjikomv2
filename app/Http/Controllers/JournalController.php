<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index()
    {
        $journals = Journal::where('is_published', true)
            ->latest('published_date')
            ->paginate(12);
            
        return view('journals.index', compact('journals'));
    }

    public function show(Journal $journal)
    {
        // Increment views
        $journal->increment('views');
        
        return view('journals.show', compact('journal'));
    }

    public function download(Journal $journal)
    {
        if (!$journal->file_path) {
            return redirect()->back()->with('error', 'File tidak tersedia!');
        }

        $journal->increment('downloads');

        return \Storage::disk('public')->download($journal->file_path, $journal->title . '.pdf');
    }
}
