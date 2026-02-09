<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * Urutan seeding sangat penting karena ada relasi antar tabel:
     * 1. Admin (independen)
     * 2. Users Institusi (independen)
     * 3. Users Peserta (independen, nanti dilink ke participants)
     * 4. Internship Applications (relasi ke institusi)
     * 5. Participants (relasi ke application dan user peserta)
     * 6. Reports (relasi ke participants)
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting database seeding...');
        $this->command->newLine();

        // 1. Seed Admins (Superadmin & Admin)
        $this->command->info('👤 Seeding Admins...');
        $this->call(AdminSeeder::class);
        
        // 2. Seed Users Institusi
        $this->command->info('🏫 Seeding Institusi...');
        $this->call(InstitusiSeeder::class);
        
        // 3. Seed Users Peserta
        $this->command->info('👨‍🎓 Seeding Peserta Users...');
        $this->call(PesertaUserSeeder::class);
        
        // 4. Seed Internship Applications
        $this->command->info('📝 Seeding Internship Applications...');
        $this->call(InternshipApplicationSeeder::class);
        
        // 5. Seed Participants (link ke users dan applications)
        $this->command->info('👥 Seeding Participants...');
        $this->call(ParticipantSeeder::class);
        
        // 6. Seed Reports
        $this->command->info('📄 Seeding Reports...');
        $this->call(ReportSeeder::class);

        $this->command->newLine();
        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->newLine();
        
        // Summary
        $this->displaySummary();
    }

    /**
     * Display seeding summary
     */
    private function displaySummary(): void
    {
        $this->command->table(
            ['Entity', 'Count', 'Status'],
            [
                ['Superadmin', '1', '✓'],
                ['Admin', '2', '✓'],
                ['Institusi', '10', '✓'],
                ['Peserta Users', '50', '✓'],
                ['Applications', '10', '✓'],
                ['Participants', '50', '✓'],
                ['Reports', '~150', '✓'],
            ]
        );
        
        $this->command->newLine();
        $this->command->warn('📌 Default Credentials:');
        $this->command->line('   Superadmin: superadmin@magang.id / password123');
        $this->command->line('   Admin: admin@magang.id / password123');
        $this->command->line('   Institusi: institusi1@example.com / password123');
        $this->command->line('   Peserta: peserta1@example.com / password123');
        $this->command->newLine();
    }
}
