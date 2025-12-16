<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin APJIKOM',
            'email' => 'admin@apjikom.or.id',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);

        // Create Member User
        $memberUser = User::create([
            'name' => 'John Doe',
            'email' => 'member@apjikom.or.id',
            'password' => Hash::make('member123'),
            'email_verified_at' => now(),
            'role' => 'member',
        ]);

        // Create Member Profile
        Member::create([
            'user_id' => $memberUser->id,
            'member_type' => 'individual',
            'institution_name' => 'Universitas Indonesia',
            'position' => 'Dosen',
            'address' => 'Jakarta, Indonesia',
            'phone' => '081234567890',
            'website' => 'https://example.com',
            'status' => 'active',
            'join_date' => now(),
            'expiry_date' => now()->addYear(),
        ]);

        echo "✓ Admin created: admin@apjikom.or.id / admin123\n";
        echo "✓ Member created: member@apjikom.or.id / member123\n";
    }
}
