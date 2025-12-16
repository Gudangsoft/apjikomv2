<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    /**
     * Handle TinyMCE image uploads
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,jpg,png,gif|max:5120', // 5MB max
        ]);

        try {
            $file = $request->file('file');
            $path = $file->store('editor-images', 'public');
            
            return response()->json([
                'location' => Storage::url($path)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Image upload failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
