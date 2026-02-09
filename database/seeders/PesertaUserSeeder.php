<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PesertaUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Membuat 50 user peserta yang nantinya akan di-link ke participants table
     * User ini bisa login ke dashboard peserta
     */
    public function run(): void
    {
        $firstNames = [
            'Ahmad', 'Budi', 'Citra', 'Dani', 'Eka', 'Fajar', 'Gita', 'Hadi', 'Indra', 'Joko',
            'Kartika', 'Lina', 'Maya', 'Nanda', 'Omar', 'Putri', 'Qori', 'Rina', 'Sari', 'Taufik',
            'Umar', 'Vina', 'Wulan', 'Xavier', 'Yanti', 'Zahra', 'Adi', 'Bella', 'Cahya', 'Dewi',
            'Eko', 'Fani', 'Galih', 'Hana', 'Ilham', 'Jihan', 'Kevin', 'Laila', 'Mira', 'Nurul',
            'Oki', 'Pramono', 'Qonita', 'Reza', 'Sinta', 'Tari', 'Ulfa', 'Vera', 'Wahyu', 'Yoga'
        ];

        $lastNames = [
            'Pratama', 'Wijaya', 'Saputra', 'Kusuma', 'Permana', 'Santoso', 'Hakim', 'Rahman', 
            'Hidayat', 'Setiawan', 'Putra', 'Putri', 'Lestari', 'Wibowo', 'Nugraha', 'Firmansyah',
            'Handoko', 'Budiman', 'Syahputra', 'Maulana'
        ];

        $pesertaUsers = [];
        
        for ($i = 1; $i <= 50; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $fullName = $firstName . ' ' . $lastName;
            $email = strtolower(str_replace(' ', '', $firstName . $lastName . $i)) . '@peserta.com';
            
            $status = 'pending';
            if ($i <= 40) {
                $status = 'active'; // 40 peserta sudah active
            } elseif ($i <= 45) {
                $status = 'pending'; // 5 peserta pending
            } else {
                $status = 'rejected'; // 5 peserta rejected
            }

            $pesertaUsers[] = [
                'role' => 'PESERTA',
                'name' => $fullName,
                'email' => $email,
                'whatsapp' => '08' . rand(1000000000, 9999999999),
                'password' => Hash::make('password123'),
                'institution_type' => null, // Peserta tidak punya institution_type
                'status' => $status,
                'created_at' => now()->subDays(rand(30, 120)),
                'updated_at' => now()->subDays(rand(1, 29)),
            ];
        }

        DB::table('accounts')->insert($pesertaUsers);
        
        $this->command->info('   ✓ Created 50 Peserta Users');
        $this->command->info('   ✓ Status: 40 Active, 5 Pending, 5 Rejected');
    }
}
