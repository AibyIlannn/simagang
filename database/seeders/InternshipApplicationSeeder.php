<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InternshipApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Membuat pengajuan magang dari institusi yang sudah active
     * Setiap institusi active bisa punya 1-2 pengajuan dengan status berbeda
     */
    public function run(): void
    {
        // Ambil institusi yang statusnya active
        $activeInstitutions = DB::table('accounts')
            ->where('role', 'INSTITUSI')
            ->where('status', 'active')
            ->pluck('id')
            ->toArray();

        $applications = [];
        $durations = ['1', '2', '3', '6', '9', '12'];
        $statuses = ['pending', 'approved', 'rejected', 'draft'];

        // Buat 10 applications dari 8 institusi active
        // Beberapa institusi bisa punya lebih dari 1 pengajuan
        $applicationData = [
            // Institusi 1 - SMK Negeri 1 Jakarta
            [
                'institution_id' => $activeInstitutions[0],
                'duration_month' => '3',
                'total_participants' => 10,
                'status' => 'approved',
                'admin_note' => 'Pengajuan disetujui. Peserta dapat memulai magang bulan depan.',
                'created_at' => now()->subMonths(3),
                'updated_at' => now()->subMonths(2),
            ],
            
            // Institusi 2 - SMK Muhammadiyah 2 Bandung
            [
                'institution_id' => $activeInstitutions[1],
                'duration_month' => '6',
                'total_participants' => 8,
                'status' => 'approved',
                'admin_note' => 'Disetujui dengan catatan: peserta wajib mengikuti orientasi.',
                'created_at' => now()->subMonths(2),
                'updated_at' => now()->subMonths(1),
            ],
            
            // Institusi 3 - SMA Negeri 8 Jakarta
            [
                'institution_id' => $activeInstitutions[2],
                'duration_month' => '2',
                'total_participants' => 5,
                'status' => 'approved',
                'admin_note' => null,
                'created_at' => now()->subMonths(2),
                'updated_at' => now()->subWeeks(6),
            ],
            
            // Institusi 4 - SMA Taruna Nusantara
            [
                'institution_id' => $activeInstitutions[3],
                'duration_month' => '3',
                'total_participants' => 6,
                'status' => 'approved',
                'admin_note' => 'Pengajuan disetujui.',
                'created_at' => now()->subMonths(1),
                'updated_at' => now()->subWeeks(3),
            ],
            
            // Institusi 5 - MA Negeri 1 Yogyakarta
            [
                'institution_id' => $activeInstitutions[4],
                'duration_month' => '3',
                'total_participants' => 4,
                'status' => 'approved',
                'admin_note' => null,
                'created_at' => now()->subMonths(1),
                'updated_at' => now()->subWeeks(2),
            ],
            
            // Institusi 6 - Universitas Indonesia
            [
                'institution_id' => $activeInstitutions[5],
                'duration_month' => '6',
                'total_participants' => 12,
                'status' => 'approved',
                'admin_note' => 'Disetujui. Program magang untuk mahasiswa semester 6.',
                'created_at' => now()->subMonths(4),
                'updated_at' => now()->subMonths(3),
            ],
            [
                'institution_id' => $activeInstitutions[5],
                'duration_month' => '3',
                'total_participants' => 5,
                'status' => 'pending',
                'admin_note' => null,
                'created_at' => now()->subWeeks(2),
                'updated_at' => now()->subWeeks(2),
            ],
            
            // Institusi 7 - Universitas Gadjah Mada
            [
                'institution_id' => $activeInstitutions[6],
                'duration_month' => '6',
                'total_participants' => 10,
                'status' => 'approved',
                'admin_note' => 'Pengajuan disetujui.',
                'created_at' => now()->subMonths(3),
                'updated_at' => now()->subMonths(2),
            ],
            
            // Institusi 8 - Politeknik Negeri Jakarta
            [
                'institution_id' => $activeInstitutions[7],
                'duration_month' => '3',
                'total_participants' => 7,
                'status' => 'approved',
                'admin_note' => null,
                'created_at' => now()->subMonth(),
                'updated_at' => now()->subWeeks(2),
            ],
            [
                'institution_id' => $activeInstitutions[7],
                'duration_month' => '2',
                'total_participants' => 3,
                'status' => 'rejected',
                'admin_note' => 'Ditolak karena kuota peserta sudah penuh untuk periode ini.',
                'created_at' => now()->subWeeks(1),
                'updated_at' => now()->subDays(3),
            ],
        ];

        DB::table('internship_applications')->insert($applicationData);
        
        $this->command->info('   ✓ Created 10 Internship Applications');
        $this->command->info('   ✓ Status: 8 Approved, 1 Pending, 1 Rejected');
    }
}
