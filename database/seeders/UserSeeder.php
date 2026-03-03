<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Puspita Indah',
            'email' => 'admin@puspita.com',
            'role' => 'admin',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // Create Staff Users
        User::create([
            'name' => 'Staff Produksi 1',
            'email' => 'staff1@puspita.com',
            'role' => 'staff',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Staff Produksi 2',
            'email' => 'staff2@puspita.com',
            'role' => 'staff',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ Users seeded successfully!');
        $this->command->info('📧 Admin: admin@puspita.com | Password: password123');
        $this->command->info('📧 Staff: staff1@puspita.com | Password: password123');
    }
}