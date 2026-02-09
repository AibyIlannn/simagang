@extends('layouts.dashboard')

@section('title', 'Dashboard Peserta')
@section('page-title', 'Dashboard Peserta')

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .stat-icon.blue {
        background: #e0e7ff;
        color: #6366f1;
    }

    .stat-icon.green {
        background: #d1fae5;
        color: #10b981;
    }

    .stat-icon.orange {
        background: #fed7aa;
        color: #f59e0b;
    }

    .stat-icon.purple {
        background: #e9d5ff;
        color: #a855f7;
    }

    .stat-info {
        text-align: right;
    }

    .stat-label {
        font-size: 0.875rem;
        color: var(--text-gray);
        margin-bottom: 0.25rem;
    }

    .stat-value {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1;
    }

    .stat-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }

    .stat-change {
        font-size: 0.75rem;
        font-weight: 600;
    }

    .stat-change.positive {
        color: var(--success-color);
    }

    .stat-period {
        font-size: 0.75rem;
        color: var(--text-light);
    }

    .dashboard-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .chart-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
    }

    .chart-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .chart-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .chart-container {
        position: relative;
        height: 300px;
    }

    .bottom-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .info-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
    }

    .info-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .info-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .see-all {
        font-size: 0.8125rem;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
    }

    .status-card {
        padding: 1.25rem;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        border-radius: 12px;
        color: white;
        margin-bottom: 1.5rem;
    }

    .status-label {
        font-size: 0.875rem;
        opacity: 0.9;
        margin-bottom: 0.5rem;
    }

    .status-value {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .status-badge {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 600;
    }

    .schedule-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .schedule-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--bg-main);
        border-radius: 8px;
        border-left: 3px solid var(--primary-color);
    }

    .schedule-time {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--primary-color);
        min-width: 70px;
    }

    .schedule-content {
        flex: 1;
    }

    .schedule-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .schedule-desc {
        font-size: 0.8125rem;
        color: var(--text-gray);
    }

    @media (max-width: 1280px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 1024px) {
        .dashboard-row, .bottom-row {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<!-- Status Card -->
<div class="status-card">
    <div class="status-label">Status Magang Anda</div>
    <div class="status-value">Aktif - Periode Februari 2026</div>
    <span class="status-badge">
        <i class="fas fa-check-circle"></i> Disetujui
    </span>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon blue">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Hari Magang</div>
                <div class="stat-value">45</div>
            </div>
        </div>
        <div class="stat-footer">
            <span class="stat-change positive">
                <i class="fas fa-arrow-up"></i> On Track
            </span>
            <span class="stat-period">dari 90 hari</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon green">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Laporan Disetujui</div>
                <div class="stat-value">12</div>
            </div>
        </div>
        <div class="stat-footer">
            <span class="stat-change positive">
                <i class="fas fa-arrow-up"></i> 100%
            </span>
            <span class="stat-period">Bulan Ini</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon orange">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Menunggu Review</div>
                <div class="stat-value">2</div>
            </div>
        </div>
        <div class="stat-footer">
            <span class="stat-change positive">
                <i class="fas fa-arrow-up"></i> 2
            </span>
            <span class="stat-period">Laporan</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon purple">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Pencapaian</div>
                <div class="stat-value">85%</div>
            </div>
        </div>
        <div class="stat-footer">
            <span class="stat-change positive">
                <i class="fas fa-arrow-up"></i> Baik
            </span>
            <span class="stat-period">Progress</span>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="dashboard-row">
    <!-- Line Chart -->
    <div class="chart-card">
        <div class="chart-header">
            <h3 class="chart-title">Progres Laporan Mingguan</h3>
        </div>
        <div class="chart-container">
            <canvas id="lineChart"></canvas>
        </div>
    </div>

    <!-- Donut Chart -->
    <div class="chart-card">
        <div class="chart-header">
            <h3 class="chart-title">Status Laporan</h3>
        </div>
        <div class="chart-container">
            <canvas id="donutChart"></canvas>
        </div>
    </div>
</div>

<!-- Bottom Row -->
<div class="bottom-row">
    <!-- Bar Chart -->
    <div class="chart-card">
        <div class="chart-header">
            <h3 class="chart-title">Kehadiran Bulanan</h3>
        </div>
        <div class="chart-container">
            <canvas id="barChart"></canvas>
        </div>
    </div>

    <!-- Jadwal -->
    <div class="info-card">
        <div class="info-header">
            <h3 class="info-title">Jadwal Hari Ini</h3>
            <a href="#" class="see-all">Lihat Semua</a>
        </div>
        <div class="schedule-list">
            <div class="schedule-item">
                <div class="schedule-time">08:00 WIB</div>
                <div class="schedule-content">
                    <div class="schedule-title">Briefing Pagi</div>
                    <div class="schedule-desc">Ruang Meeting Lt. 3</div>
                </div>
            </div>

            <div class="schedule-item">
                <div class="schedule-time">10:00 WIB</div>
                <div class="schedule-content">
                    <div class="schedule-title">Praktik Lapangan</div>
                    <div class="schedule-desc">Site Proyek Jalan Raya</div>
                </div>
            </div>

            <div class="schedule-item">
                <div class="schedule-time">13:00 WIB</div>
                <div class="schedule-content">
                    <div class="schedule-title">Monitoring Harian</div>
                    <div class="schedule-desc">Dengan Pembimbing</div>
                </div>
            </div>

            <div class="schedule-item">
                <div class="schedule-time">15:00 WIB</div>
                <div class="schedule-content">
                    <div class="schedule-title">Review Laporan</div>
                    <div class="schedule-desc">Submit Laporan Mingguan</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Line Chart
const lineCtx = document.getElementById('lineChart').getContext('2d');
new Chart(lineCtx, {
    type: 'line',
    data: {
        labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5', 'Minggu 6'],
        datasets: [{
            label: 'Laporan Selesai',
            data: [2, 3, 2, 4, 3, 2],
            borderColor: '#6366f1',
            backgroundColor: 'rgba(99, 102, 241, 0.1)',
            tension: 0.4,
            fill: true,
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: '#f3f4f6'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Donut Chart
const donutCtx = document.getElementById('donutChart').getContext('2d');
new Chart(donutCtx, {
    type: 'doughnut',
    data: {
        labels: ['Disetujui', 'Pending', 'Revisi'],
        datasets: [{
            data: [12, 2, 1],
            backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    font: {
                        size: 12
                    }
                }
            }
        }
    }
});

// Bar Chart
const barCtx = document.getElementById('barChart').getContext('2d');
new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
        datasets: [{
            label: 'Kehadiran',
            data: [20, 22, 21, 20, 15, 5],
            backgroundColor: '#6366f1',
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: '#f3f4f6'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});
</script>
@endpush