<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Berita Umum',
                'slug' => 'berita-umum',
                'description' => 'Berita umum seputar APJIKOM',
            ],
            [
                'name' => 'Kegiatan',
                'slug' => 'kegiatan',
                'description' => 'Informasi kegiatan APJIKOM',
            ],
            [
                'name' => 'Publikasi',
                'slug' => 'publikasi',
                'description' => 'Publikasi jurnal dan artikel ilmiah',
            ],
            [
                'name' => 'Kerjasama',
                'slug' => 'kerjasama',
                'description' => 'Berita kerjasama dengan institusi lain',
            ],
            [
                'name' => 'Pengumuman',
                'slug' => 'pengumuman',
                'description' => 'Pengumuman penting dari APJIKOM',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
