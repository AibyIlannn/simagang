@extends('layouts.dashboard')

@section('title', 'Dashboard Institusi')
@section('page-title', 'Dashboard Institusi')

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

    .stat-icon.red {
        background: #fee2e2;
        color: #ef4444;
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

    .chart-filter {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-btn {
        padding: 0.5rem 1rem;
        background: var(--bg-main);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 500;
        color: var(--text-gray);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .filter-btn:hover, .filter-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
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

    .notice-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .notice-item {
        padding: 1rem;
        background: var(--bg-main);
        border-radius: 8px;
        border-left: 3px solid var(--primary-color);
    }

    .notice-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .notice-text {
        font-size: 0.8125rem;
        color: var(--text-gray);
        margin-bottom: 0.5rem;
    }

    .notice-time {
        font-size: 0.75rem;
        color: var(--text-light);
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
<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Peserta</div>
                <div class="stat-value">45</div>
            </div>
        </div>
        <div class="stat-footer">
            <span class="stat-change positive">
                <i class="fas fa-arrow-up"></i> 10%
            </span>
            <span class="stat-period">Bulan Ini</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon green">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Peserta Aktif</div>
                <div class="stat-value">38</div>
            </div>
        </div>
        <div class="stat-footer">
            <span class="stat-change positive">
                <i class="fas fa-arrow-up"></i> 5%
            </span>
            <span class="stat-period">Bulan Ini</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon orange">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Laporan</div>
                <div class="stat-value">124</div>
            </div>
        </div>
        <div class="stat-footer">
            <span class="stat-change positive">
                <i class="fas fa-arrow-up"></i> 12%
            </span>
            <span class="stat-period">Bulan Ini</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon red">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Menunggu Review</div>
                <div class="stat-value">8</div>
            </div>
        </div>
        <div class="stat-footer">
            <span class="stat-change positive">
                <i class="fas fa-arrow-up"></i> 2%
            </span>
            <span class="stat-period">Bulan Ini</span>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="dashboard-row">
    <!-- Line Chart -->
    <div class="chart-card">
        <div class="chart-header">
            <h3 class="chart-title">Perkembangan Peserta</h3>
            <div class="chart-filter">
                <button class="filter-btn active">Bulanan</button>
                <button class="filter-btn">Tahunan</button>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="lineChart"></canvas>
        </div>
    </div>

    <!-- Donut Chart -->
    <div class="chart-card">
        <div class="chart-header">
            <h3 class="chart-title">Status Peserta</h3>
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
            <h3 class="chart-title">Laporan Bulanan</h3>
        </div>
        <div class="chart-container">
            <canvas id="barChart"></canvas>
        </div>
    </div>

    <!-- Pemberitahuan -->
    <div class="info-card">
        <div class="info-header">
            <h3 class="info-title">Pemberitahuan</h3>
            <a href="#" class="see-all">Lihat Semua</a>
        </div>
        <div class="notice-list">
            <div class="notice-item">
                <div class="notice-title">Pengajuan Disetujui</div>
                <div class="notice-text">Pengajuan magang periode Februari 2026 telah disetujui</div>
                <div class="notice-time">2 jam yang lalu</div>
            </div>

            <div class="notice-item">
                <div class="notice-title">Reminder Laporan</div>
                <div class="notice-text">8 peserta belum mengumpulkan laporan minggu ini</div>
                <div class="notice-time">1 hari yang lalu</div>
            </div>

            <div class="notice-item">
                <div class="notice-title">Peserta Selesai</div>
                <div class="notice-text">5 peserta telah menyelesaikan program magang</div>
                <div class="notice-time">2 hari yang lalu</div>
            </div>

            <div class="notice-item">
                <div class="notice-title">Validasi Dokumen</div>
                <div class="notice-text">Dokumen tambahan perlu dilengkapi</div>
                <div class="notice-time">3 hari yang lalu</div>
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
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
        datasets: [{
            label: 'Peserta',
            data: [5, 10, 8, 15, 12, 18],
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
        labels: ['Aktif', 'Pending', 'Selesai'],
        datasets: [{
            data: [38, 7, 10],
            backgroundColor: ['#10b981', '#f59e0b', '#6366f1'],
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
            label: 'Laporan',
            data: [15, 22, 18, 25, 20, 24],
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