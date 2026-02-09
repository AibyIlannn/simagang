@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

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

    .stat-change.negative {
        color: var(--danger-color);
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

    .recent-activity {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
    }

    .activity-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .activity-title {
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

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.75rem;
        border-radius: 8px;
        transition: background 0.2s ease;
    }

    .activity-item:hover {
        background: var(--bg-main);
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 0.875rem;
    }

    .activity-icon.blue {
        background: #e0e7ff;
        color: #6366f1;
    }

    .activity-icon.green {
        background: #d1fae5;
        color: #10b981;
    }

    .activity-icon.orange {
        background: #fed7aa;
        color: #f59e0b;
    }

    .activity-content {
        flex: 1;
    }

    .activity-text {
        font-size: 0.875rem;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .activity-time {
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
                <i class="fas fa-school"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Institusi</div>
                <div class="stat-value">24</div>
            </div>
        </div>
        <div class="stat-footer">
            <span class="stat-change positive">
                <i class="fas fa-arrow-up"></i> 12%
            </span>
            <span class="stat-period">Last Month</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon green">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Peserta</div>
                <div class="stat-value">156</div>
            </div>
        </div>
        <div class="stat-footer">
            <span class="stat-change positive">
                <i class="fas fa-arrow-up"></i> 8%
            </span>
            <span class="stat-period">Last Month</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon orange">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Laporan</div>
                <div class="stat-value">89</div>
            </div>
        </div>
        <div class="stat-footer">
            <span class="stat-change positive">
                <i class="fas fa-arrow-up"></i> 15%
            </span>
            <span class="stat-period">Last Month</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon purple">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Pending Validasi</div>
                <div class="stat-value">12</div>
            </div>
        </div>
        <div class="stat-footer">
            <span class="stat-change negative">
                <i class="fas fa-arrow-down"></i> 3%
            </span>
            <span class="stat-period">Last Month</span>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="dashboard-row">
    <!-- Line Chart -->
    <div class="chart-card">
        <div class="chart-header">
            <h3 class="chart-title">Statistik Peserta</h3>
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
            <h3 class="chart-title">Distribusi Status</h3>
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
            <h3 class="chart-title">Laporan per Bulan</h3>
        </div>
        <div class="chart-container">
            <canvas id="barChart"></canvas>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="recent-activity">
        <div class="activity-header">
            <h3 class="activity-title">Aktivitas Terbaru</h3>
            <a href="#" class="see-all">Lihat Semua</a>
        </div>
        <div class="activity-list">
            <div class="activity-item">
                <div class="activity-icon blue">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-text">SMK Negeri 1 Serang mendaftar</div>
                    <div class="activity-time">2 jam yang lalu</div>
                </div>
            </div>

            <div class="activity-item">
                <div class="activity-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-text">Validasi institusi SMA Negeri 3 Serang disetujui</div>
                    <div class="activity-time">5 jam yang lalu</div>
                </div>
            </div>

            <div class="activity-item">
                <div class="activity-icon orange">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-text">Laporan baru dari Ahmad Fauzi</div>
                    <div class="activity-time">1 hari yang lalu</div>
                </div>
            </div>

            <div class="activity-item">
                <div class="activity-icon blue">
                    <i class="fas fa-users"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-text">15 peserta baru ditambahkan</div>
                    <div class="activity-time">2 hari yang lalu</div>
                </div>
            </div>

            <div class="activity-item">
                <div class="activity-icon green">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-text">10 peserta menyelesaikan magang</div>
                    <div class="activity-time">3 hari yang lalu</div>
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
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
        datasets: [{
            label: 'Peserta Aktif',
            data: [12, 19, 15, 25, 22, 30],
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
            data: [65, 20, 15],
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
            data: [8, 12, 15, 10, 18, 14],
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