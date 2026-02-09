<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Membuat laporan untuk setiap peserta yang active atau finished
     * Setiap peserta bisa punya 1-5 laporan dengan status berbeda
     */
    public function run(): void
    {
        // Template judul laporan yang realistis
        $reportTitles = [
            'Laporan Kegiatan Minggu Pertama',
            'Laporan Kegiatan Minggu Kedua',
            'Laporan Progress Proyek Development',
            'Laporan Analisis Sistem',
            'Laporan Implementasi Database',
            'Laporan Testing dan Debugging',
            'Laporan Deployment Aplikasi',
            'Laporan Pembelajaran UI/UX Design',
            'Laporan Kegiatan Digital Marketing',
            'Laporan Riset Pasar',
            'Laporan Social Media Analytics',
            'Laporan Optimasi Website',
            'Laporan Network Configuration',
            'Laporan Server Monitoring',
            'Laporan Backup dan Recovery System',
            'Laporan Kegiatan Akhir Magang',
        ];

        $descriptions = [
            'Melakukan analisis kebutuhan sistem dan dokumentasi requirements.',
            'Mengimplementasikan fitur login dan registrasi dengan validasi form.',
            'Membuat database schema dan relasi antar tabel sesuai kebutuhan.',
            'Melakukan testing unit dan integration testing pada modul yang telah dibuat.',
            'Deploy aplikasi ke server production dan monitoring performa.',
            'Mempelajari framework Laravel dan membuat CRUD sederhana.',
            'Mengoptimasi query database dan memperbaiki performa aplikasi.',
            'Membuat wireframe dan mockup untuk halaman landing page.',
            'Melakukan riset kompetitor dan analisis market trends.',
            'Membuat konten social media dan scheduling posting.',
            'Menganalisis data traffic website menggunakan Google Analytics.',
            'Konfigurasi network devices dan troubleshooting koneksi.',
            'Setup backup system otomatis dan disaster recovery plan.',
            'Dokumentasi seluruh kegiatan magang dan lessons learned.',
        ];

        $adminNotes = [
            'Laporan sudah sesuai format. Lanjutkan kegiatan dengan baik.',
            'Perlu penambahan dokumentasi screenshot dan penjelasan lebih detail.',
            'Laporan kurang lengkap, mohon dilengkapi bagian kesimpulan.',
            'Sangat baik! Dokumentasi lengkap dan terstruktur.',
            'Approved. Teruskan pekerjaan dengan konsisten.',
            null,
            null,
        ];

        // Ambil semua participants yang active atau finished
        $participants = DB::table('participants')
            ->whereIn('status', ['active', 'finished'])
            ->get();

        $reports = [];
        $totalReports = 0;

        foreach ($participants as $participant) {
            // Jumlah laporan per peserta (1-5 laporan)
            $numReports = rand(1, 5);
            
            // Peserta yang finished biasanya punya lebih banyak laporan
            if ($participant->status === 'finished') {
                $numReports = rand(4, 8);
            }

            for ($i = 1; $i <= $numReports; $i++) {
                // Tentukan status laporan
                $status = $this->determineReportStatus($i, $numReports, $participant->status);
                
                // Admin note hanya ada jika status reviewed/approved/rejected
                $adminNote = in_array($status, ['reviewed', 'approved', 'rejected'])
                    ? $adminNotes[array_rand($adminNotes)]
                    : null;

                $title = $reportTitles[array_rand($reportTitles)];
                if ($i === $numReports && $participant->status === 'finished') {
                    $title = 'Laporan Kegiatan Akhir Magang';
                }

                $reports[] = [
                    'participant_id' => $participant->id,
                    'title' => $title . ' - ' . date('F Y', strtotime($participant->created_at . " +{$i} weeks")),
                    'description' => $descriptions[array_rand($descriptions)],
                    'file_path' => $status !== 'draft' 
                        ? 'reports/' . $participant->id . '/laporan_' . $i . '_' . time() . '.pdf'
                        : null,
                    'status' => $status,
                    'admin_note' => $adminNote,
                    'created_at' => now()->subDays(rand(1, 90)),
                    'updated_at' => now()->subDays(rand(0, 30)),
                ];

                $totalReports++;
            }
        }

        DB::table('reports')->insert($reports);
        
        // Hitung statistik
        $statusCounts = [];
        foreach ($reports as $report) {
            $status = $report['status'];
            $statusCounts[$status] = ($statusCounts[$status] ?? 0) + 1;
        }
        
        $this->command->info('   ✓ Created ' . $totalReports . ' Reports');
        $this->command->info('   ✓ Status breakdown:');
        foreach ($statusCounts as $status => $count) {
            $this->command->info("      - {$status}: {$count}");
        }
    }

    /**
     * Tentukan status laporan berdasarkan urutan dan status peserta
     */
    private function determineReportStatus($reportNumber, $totalReports, $participantStatus): string
    {
        // Laporan terakhir untuk peserta finished biasanya approved
        if ($reportNumber === $totalReports && $participantStatus === 'finished') {
            return 'approved';
        }

        // Laporan terbaru (80% dari total) biasanya masih draft/submitted
        if ($reportNumber > $totalReports * 0.8) {
            return ['draft', 'submitted'][array_rand(['draft', 'submitted'])];
        }

        // Laporan tengah (40-80%) biasanya reviewed/approved
        if ($reportNumber > $totalReports * 0.4) {
            return ['reviewed', 'approved'][array_rand(['reviewed', 'approved'])];
        }

        // Laporan awal biasanya sudah approved, ada yang rejected
        $statuses = ['approved', 'approved', 'approved', 'reviewed', 'rejected'];
        return $statuses[array_rand($statuses)];
    }
}
