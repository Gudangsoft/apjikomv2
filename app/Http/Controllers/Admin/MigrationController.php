<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class MigrationController extends Controller
{
    public function showMigrationForm()
    {
        return view('admin.migration.run');
    }

    public function runMigration(Request $request)
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output();
            
            return redirect()->route('admin.run-migration')
                ->with('success', 'Migration berhasil dijalankan!<br><br><pre class="mt-2 text-xs bg-gray-900 text-green-400 p-3 rounded overflow-auto">' . htmlspecialchars($output) . '</pre><br><a href="' . route('admin.partners.index') . '" class="inline-block mt-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">Buka Halaman Partners</a>');
        } catch (\Exception $e) {
            return redirect()->route('admin.run-migration')
                ->with('error', 'Migration gagal: ' . $e->getMessage());
        }
    }
}
