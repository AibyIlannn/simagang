<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Membuat 50 participants yang terhubung ke:
     * - internship_applications (pengajuan dari institusi)
     * - users dengan role PESERTA (untuk login)
     */
    public function run(): void
    {
        // Data master untuk generate participants
        $divisions = [
            'IT & Software Development',
            'Network & Infrastructure',
            'Digital Marketing',
            'Graphic Design',
            'Human Resources',
            'Finance & Accounting',
            'Customer Service',
            'Product Management',
            'Data Analytics',
            'Business Development'
        ];

        $rooms = [
            'Lab Komputer 1', 'Lab Komputer 2', 'Lab Komputer 3',
            'Ruang Server', 'Ruang Meeting A', 'Ruang Meeting B',
            'Co-Working Space', 'Development Room', 'Design Studio',
            'Training Room', 'Open Space Area'
        ];

        $majorsSMK = [
            'Rekayasa Perangkat Lunak',
            'Teknik Komputer dan Jaringan',
            'Multimedia',
            'Sistem Informasi Jaringan dan Aplikasi',
            'Akuntansi dan Keuangan Lembaga'
        ];

        $majorsSMA = [
            'IPA',
            'IPS',
            'Bahasa'
        ];

        $majorsUniversity = [
            'Teknik Informatika',
            'Sistem Informasi',
            'Ilmu Komputer',
            'Teknik Elektro',
            'Manajemen',
            'Akuntansi',
            'Desain Komunikasi Visual',
            'Ilmu Komunikasi'
        ];

        // Ambil semua applications yang approved
        $approvedApplications = DB::table('internship_applications')
            ->where('status', 'approved')
            ->get();

        // Ambil peserta users yang active
        $pesertaUsers = DB::table('accounts')
            ->where('role', 'PESERTA')
            ->where('status', 'active')
            ->pluck('id')
            ->toArray();

        $participants = [];
        $userIndex = 0;

        foreach ($approvedApplications as $application) {
            // Ambil data institusi
            $institution = DB::table('accounts')->find($application->institution_id);
            
            // Tentukan tipe peserta berdasarkan institusi
            $participantType = in_array($institution->institution_type, ['SMK', 'SMA', 'MA']) 
                ? 'SISWA' 
                : 'MAHASISWA';

            // Buat participants sesuai total_participants di application
            for ($i = 0; $i < $application->total_participants; $i++) {
                if ($userIndex >= count($pesertaUsers)) {
                    break; // Jika user habis, stop
                }

                $userId = $pesertaUsers[$userIndex];
                $userName = DB::table('accounts')->where('id', $userId)->value('name');
                
                // Generate data berdasarkan tipe
                if ($participantType === 'SISWA') {
                    $major = $institution->institution_type === 'SMK' 
                        ? $majorsSMK[array_rand($majorsSMK)]
                        : $majorsSMA[array_rand($majorsSMA)];
                    
                    $class = $institution->institution_type === 'SMK'
                        ? 'XII ' . ['RPL 1', 'RPL 2', 'TKJ 1', 'TKJ 2', 'MM 1'][rand(0, 4)]
                        : 'XII ' . ['IPA 1', 'IPA 2', 'IPS 1', 'IPS 2'][rand(0, 3)];
                    
                    $semester = null;
                } else {
                    $major = $majorsUniversity[array_rand($majorsUniversity)];
                    $class = 'S1 ' . $major;
                    $semester = rand(5, 7);
                }

                // Generate identity number
                $identityNumber = $participantType === 'SISWA'
                    ? 'NIS' . rand(100000, 999999)
                    : 'NIM' . rand(10000000, 99999999);

                // Status peserta
                $status = 'active';
                if ($i < $application->total_participants * 0.8) {
                    $status = 'active';
                } elseif ($i < $application->total_participants * 0.9) {
                    $status = 'finished';
                } else {
                    $status = 'pending';
                }

                $participants[] = [
                    'application_id' => $application->id,
                    'user_id' => $userId,
                    'name' => $userName,
                    'participant_type' => $participantType,
                    'identity_number' => $identityNumber,
                    'major' => $major,
                    'class_or_program' => $class,
                    'semester' => $semester,
                    'division' => $divisions[array_rand($divisions)],
                    'room' => $rooms[array_rand($rooms)],
                    'floor' => rand(1, 7),
                    'status' => $status,
                    'created_at' => $application->created_at,
                    'updated_at' => now()->subDays(rand(1, 30)),
                ];

                $userIndex++;
            }
        }

        DB::table('participants')->insert($participants);
        
        $totalActive = count(array_filter($participants, fn($p) => $p['status'] === 'active'));
        $totalFinished = count(array_filter($participants, fn($p) => $p['status'] === 'finished'));
        $totalPending = count(array_filter($participants, fn($p) => $p['status'] === 'pending'));
        
        $this->command->info('   ✓ Created ' . count($participants) . ' Participants');
        $this->command->info("   ✓ Status: {$totalActive} Active, {$totalFinished} Finished, {$totalPending} Pending");
    }
}
