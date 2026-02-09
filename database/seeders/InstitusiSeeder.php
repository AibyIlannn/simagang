<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InstitusiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Membuat 10 institusi dengan berbagai jenis dan status
     * Status: pending, active, rejected
     */
    public function run(): void
    {
        $institusi = [
            // SMK (3 institusi)
            [
                'role' => 'INSTITUSI',
                'name' => 'SMK Negeri 1 Jakarta',
                'email' => 'smkn1jakarta@example.com',
                'whatsapp' => '081234567801',
                'password' => Hash::make('password123'),
                'institution_type' => 'SMK',
                'status' => 'active',
                'created_at' => now()->subMonths(4),
                'updated_at' => now()->subMonth(),
            ],
            [
                'role' => 'INSTITUSI',
                'name' => 'SMK Muhammadiyah 2 Bandung',
                'email' => 'smkmuh2bdg@example.com',
                'whatsapp' => '081234567802',
                'password' => Hash::make('password123'),
                'institution_type' => 'SMK',
                'status' => 'active',
                'created_at' => now()->subMonths(3),
                'updated_at' => now()->subWeeks(2),
            ],
            [
                'role' => 'INSTITUSI',
                'name' => 'SMK Telkom Purwokerto',
                'email' => 'smktelkompwt@example.com',
                'whatsapp' => '081234567803',
                'password' => Hash::make('password123'),
                'institution_type' => 'SMK',
                'status' => 'pending',
                'created_at' => now()->subWeek(),
                'updated_at' => now()->subWeek(),
            ],
            
            // SMA (2 institusi)
            [
                'role' => 'INSTITUSI',
                'name' => 'SMA Negeri 8 Jakarta',
                'email' => 'sman8jakarta@example.com',
                'whatsapp' => '081234567804',
                'password' => Hash::make('password123'),
                'institution_type' => 'SMA',
                'status' => 'active',
                'created_at' => now()->subMonths(3),
                'updated_at' => now()->subMonth(),
            ],
            [
                'role' => 'INSTITUSI',
                'name' => 'SMA Taruna Nusantara',
                'email' => 'smatarnus@example.com',
                'whatsapp' => '081234567805',
                'password' => Hash::make('password123'),
                'institution_type' => 'SMA',
                'status' => 'active',
                'created_at' => now()->subMonths(2),
                'updated_at' => now()->subWeeks(3),
            ],
            
            // MA (1 institusi)
            [
                'role' => 'INSTITUSI',
                'name' => 'MA Negeri 1 Yogyakarta',
                'email' => 'man1yogya@example.com',
                'whatsapp' => '081234567806',
                'password' => Hash::make('password123'),
                'institution_type' => 'MA',
                'status' => 'active',
                'created_at' => now()->subMonths(2),
                'updated_at' => now()->subWeeks(2),
            ],
            
            // UNIVERSITAS (2 institusi)
            [
                'role' => 'INSTITUSI',
                'name' => 'Universitas Indonesia',
                'email' => 'ui@example.com',
                'whatsapp' => '081234567807',
                'password' => Hash::make('password123'),
                'institution_type' => 'UNIVERSITAS',
                'status' => 'active',
                'created_at' => now()->subMonths(5),
                'updated_at' => now()->subWeeks(2),
            ],
            [
                'role' => 'INSTITUSI',
                'name' => 'Universitas Gadjah Mada',
                'email' => 'ugm@example.com',
                'whatsapp' => '081234567808',
                'password' => Hash::make('password123'),
                'institution_type' => 'UNIVERSITAS',
                'status' => 'active',
                'created_at' => now()->subMonths(4),
                'updated_at' => now()->subMonth(),
            ],
            
            // POLITEKNIK (2 institusi)
            [
                'role' => 'INSTITUSI',
                'name' => 'Politeknik Negeri Jakarta',
                'email' => 'pnj@example.com',
                'whatsapp' => '081234567809',
                'password' => Hash::make('password123'),
                'institution_type' => 'POLITEKNIK',
                'status' => 'active',
                'created_at' => now()->subMonths(3),
                'updated_at' => now()->subWeeks(3),
            ],
            [
                'role' => 'INSTITUSI',
                'name' => 'Politeknik Elektronika Negeri Surabaya',
                'email' => 'pens@example.com',
                'whatsapp' => '081234567810',
                'password' => Hash::make('password123'),
                'institution_type' => 'POLITEKNIK',
                'status' => 'rejected',
                'created_at' => now()->subMonths(1),
                'updated_at' => now()->subWeeks(2),
            ],
        ];

        DB::table('accounts')->insert($institusi);
        
        $this->command->info('   ✓ Created 10 Institusi (3 SMK, 2 SMA, 1 MA, 2 Univ, 2 Poltek)');
        $this->command->info('   ✓ Status: 8 Active, 1 Pending, 1 Rejected');
    }
}
