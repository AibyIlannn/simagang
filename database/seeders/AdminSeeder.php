<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Membuat 1 Superadmin dan 2 Admin dengan status active
     */
    public function run(): void
    {
        $admins = [
            [
                'role' => 'SUPERADMIN',
                'name' => 'Super Administrator',
                'email' => 'superadmin@magang.id',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'created_at' => now()->subMonths(6),
                'updated_at' => now()->subMonths(6),
            ],
            [
                'role' => 'ADMIN',
                'name' => 'Ahmad Fauzi',
                'email' => 'admin@magang.id',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'created_at' => now()->subMonths(5),
                'updated_at' => now()->subMonths(5),
            ],
            [
                'role' => 'ADMIN',
                'name' => 'Siti Nurhaliza',
                'email' => 'admin.siti@magang.id',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'created_at' => now()->subMonths(4),
                'updated_at' => now()->subMonths(4),
            ],
        ];

        DB::table('admins')->insert($admins);
        
        $this->command->info('   ✓ Created 1 Superadmin and 2 Admins');
    }
}
