<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            [
                'name' => 'Universitas Indonesia',
                'logo' => 'partners/ui-logo.png', // You need to upload actual logos
                'url' => 'https://ui.ac.id',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Institut Teknologi Bandung',
                'logo' => 'partners/itb-logo.png',
                'url' => 'https://itb.ac.id',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Universitas Gadjah Mada',
                'logo' => 'partners/ugm-logo.png',
                'url' => 'https://ugm.ac.id',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Institut Teknologi Sepuluh Nopember',
                'logo' => 'partners/its-logo.png',
                'url' => 'https://its.ac.id',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Universitas Airlangga',
                'logo' => 'partners/unair-logo.png',
                'url' => 'https://unair.ac.id',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Universitas Diponegoro',
                'logo' => 'partners/undip-logo.png',
                'url' => 'https://undip.ac.id',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Universitas Brawijaya',
                'logo' => 'partners/ub-logo.png',
                'url' => 'https://ub.ac.id',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Universitas Sebelas Maret',
                'logo' => 'partners/uns-logo.png',
                'url' => 'https://uns.ac.id',
                'order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($partners as $partner) {
            Partner::create($partner);
        }
    }
}
