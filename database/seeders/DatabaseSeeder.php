<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin APJIKOM',
            'email' => 'admin@apjikom.or.id',
            'role' => 'admin',
        ]);

        // Create test users
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user',
        ]);

        // Create member user
        User::factory()->create([
            'name' => 'Member APJIKOM',
            'email' => 'member@example.com',
            'role' => 'member',
        ]);

        $this->call([
            CategorySeeder::class,
            NewsSeeder::class,
            EventSeeder::class,
            MemberSeeder::class,
        ]);
    }
}
