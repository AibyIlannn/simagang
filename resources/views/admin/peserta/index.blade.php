@extends('layouts.dashboard')

@section('title', 'Data Peserta - Admin Dashboard')

@section('content')
<div x-data="participantList()">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div>
                <h1 class="page-title">Data Peserta Magang</h1>
                <p class="page-subtitle">Kelola dan monitor seluruh peserta magang yang terdaftar</p>
            </div>
            <div class="page-actions">
                <button @click="exportData" class="btn btn-secondary">
                    <i class="fas fa-download"></i>
                    Export Excel
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, rgba(6, 182, 212, 0.15), rgba(6, 182, 212, 0.05));">
                <i class="fas fa-users" style="color: var(--accent-600);"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" x-text="stats.total"></div>
                <div class="stat-label">Total Peserta</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05));">
                <i class="fas fa-user-check" style="color: var(--success-600);"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" x-text="stats.active"></div>
                <div class="stat-label">Aktif</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.15), rgba(139, 92, 246, 0.05));">
                <i class="fas fa-check-double" style="color: #8b5cf6;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" x-text="stats.finished"></div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(245, 158, 11, 0.05));">
                <i class="fas fa-clock" style="color: #f59e0b;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" x-text="stats.pending"></div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="filter-section">
        <div class="filter-group">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input 
                    type="text" 
                    placeholder="Cari nama peserta, NISN, atau institusi..." 
                    x-model="filters.search"
                    @input.debounce.300ms="applyFilters"
                >
            </div>
            
            <select x-model="filters.type" @change="applyFilters" class="filter-select">
                <option value="">Semua Jenis</option>
                <option value="SISWA">Siswa</option>
                <option value="MAHASISWA">Mahasiswa</option>
            </select>

            <select x-model="filters.division" @change="applyFilters" class="filter-select">
                <option value="">Semua Bidang</option>
                <option value="IT">IT & Development</option>
                <option value="ADMIN">Administrasi</option>
                <option value="FINANCE">Keuangan</option>
                <option value="HR">SDM</option>
                <option value="MARKETING">Marketing</option>
            </select>

            <select x-model="filters.status" @change="applyFilters" class="filter-select">
                <option value="">Semua Status</option>
                <option value="active">Aktif</option>
                <option value="pending">Pending</option>
                <option value="finished">Selesai</option>
                <option value="rejected">Ditolak</option>
            </select>

            <button @click="resetFilters" class="btn btn-ghost">
                <i class="fas fa-redo"></i>
                Reset
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 50px;">
                        <input type="checkbox" class="checkbox-input" @change="toggleSelectAll" :checked="selectedAll">
                    </th>
                    <th>Peserta</th>
                    <th>Jenis</th>
                    <th>Institusi</th>
                    <th>Bidang Kerja</th>
                    <th>Lokasi</th>
                    <th>Periode</th>
                    <th>Status</th>
                    <th style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="participant in paginatedData" :key="participant.id">
                    <tr>
                        <td>
                            <input type="checkbox" class="checkbox-input" :value="participant.id" x-model="selected">
                        </td>
                        <td>
                            <div class="table-user-info">
                                <div class="user-avatar" :style="`background: linear-gradient(135deg, ${participant.color}, ${participant.colorDark})`">
                                    <span x-text="participant.name.charAt(0)"></span>
                                </div>
                                <div>
                                    <div class="user-name" x-text="participant.name"></div>
                                    <div class="user-meta" x-text="participant.identity_number"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge" :class="participant.participant_type === 'SISWA' ? 'badge-blue' : 'badge-purple'" x-text="participant.participant_type"></span>
                        </td>
                        <td>
                            <div class="institution-info">
                                <div x-text="participant.institution_name"></div>
                                <div class="institution-meta" x-text="participant.major"></div>
                            </div>
                        </td>
                        <td>
                            <div class="division-info" x-text="participant.division"></div>
                        </td>
                        <td>
                            <div class="location-info">
                                <i class="fas fa-door-open"></i>
                                <span x-text="`${participant.room} (Lt. ${participant.floor})`"></span>
                            </div>
                        </td>
                        <td>
                            <div class="period-info">
                                <div x-text="formatPeriod(participant.start_date, participant.end_date)"></div>
                                <div class="period-meta" x-text="`${participant.duration} hari`"></div>
                            </div>
                        </td>
                        <td>
                            <span 
                                class="status-badge" 
                                :class="{
                                    'status-active': participant.status === 'active',
                                    'status-pending': participant.status === 'pending',
                                    'status-finished': participant.status === 'finished',
                                    'status-rejected': participant.status === 'rejected'
                                }"
                                x-text="getStatusText(participant.status)"
                            ></span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a :href="`/admin/dashboard/peserta/${participant.id}`" class="btn-action btn-action-primary" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>

        <div x-show="filteredData.length === 0" class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-user-slash"></i>
            </div>
            <div class="empty-state-title">Tidak ada data peserta</div>
            <div class="empty-state-text">Belum ada peserta yang terdaftar atau hasil filter tidak ditemukan</div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="pagination-container" x-show="filteredData.length > 0">
        <div class="pagination-info">
            Menampilkan <strong x-text="paginationStart"></strong> - <strong x-text="paginationEnd"></strong> dari <strong x-text="filteredData.length"></strong> peserta
        </div>
        <div class="pagination">
            <button @click="currentPage--" :disabled="currentPage === 1" class="pagination-btn">
                <i class="fas fa-chevron-left"></i>
            </button>
            <template x-for="page in totalPages" :key="page">
                <button 
                    @click="currentPage = page" 
                    class="pagination-btn" 
                    :class="{ 'active': currentPage === page }"
                    x-text="page"
                ></button>
            </template>
            <button @click="currentPage++" :disabled="currentPage === totalPages" class="pagination-btn">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<style>
.page-header { margin-bottom: 2rem; }
.page-header-content { display: flex; justify-content: space-between; align-items: flex-start; gap: 1.5rem; }
.page-title { font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 800; color: var(--text-primary); margin-bottom: 0.5rem; letter-spacing: -0.02em; }
.page-subtitle { font-size: 0.9375rem; color: var(--text-secondary); }
.page-actions { display: flex; gap: 0.75rem; }
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 2rem; }
.stat-card { background: var(--bg-primary); border-radius: 16px; border: 1px solid var(--border-primary); padding: 1.5rem; display: flex; gap: 1.25rem; align-items: center; box-shadow: var(--shadow-sm); transition: all 0.2s ease; }
.stat-card:hover { border-color: var(--accent-500); box-shadow: var(--shadow-md); transform: translateY(-2px); }
.stat-icon { width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; }
.stat-content { flex: 1; }
.stat-value { font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 800; color: var(--text-primary); line-height: 1; margin-bottom: 0.375rem; }
.stat-label { font-size: 0.875rem; font-weight: 500; color: var(--text-secondary); }
.filter-section { background: var(--bg-primary); border-radius: 16px; border: 1px solid var(--border-primary); padding: 1.25rem 1.5rem; margin-bottom: 1.5rem; box-shadow: var(--shadow-sm); }
.filter-group { display: flex; gap: 0.75rem; align-items: center; }
.search-box { flex: 1; position: relative; }
.search-box i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-tertiary); font-size: 0.875rem; }
.search-box input { width: 100%; padding: 0.75rem 1rem 0.75rem 2.75rem; border: 1px solid var(--border-primary); border-radius: 10px; font-size: 0.9375rem; transition: all 0.2s ease; background: var(--bg-secondary); }
.search-box input:focus { outline: none; border-color: var(--accent-500); background: white; box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1); }
.filter-select { padding: 0.75rem 1rem; border: 1px solid var(--border-primary); border-radius: 10px; font-size: 0.9375rem; font-weight: 500; background: var(--bg-secondary); color: var(--text-primary); cursor: pointer; transition: all 0.2s ease; min-width: 150px; }
.filter-select:focus { outline: none; border-color: var(--accent-500); background: white; box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1); }
.btn { display: inline-flex; align-items: center; gap: 0.625rem; padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 600; font-size: 0.9375rem; transition: all 0.2s ease; border: none; cursor: pointer; text-decoration: none; }
.btn-secondary { background: var(--gray-200); color: var(--text-primary); }
.btn-secondary:hover { background: var(--gray-300); transform: translateY(-2px); box-shadow: var(--shadow-md); }
.btn-ghost { background: transparent; color: var(--text-secondary); border: 1px solid var(--border-primary); }
.btn-ghost:hover { background: var(--bg-secondary); border-color: var(--accent-500); color: var(--accent-600); }
.data-table-container { background: var(--bg-primary); border-radius: 16px; border: 1px solid var(--border-primary); overflow: hidden; box-shadow: var(--shadow-sm); }
.data-table { width: 100%; border-collapse: collapse; }
.data-table thead { background: linear-gradient(180deg, var(--gray-50) 0%, transparent 100%); border-bottom: 2px solid var(--border-primary); }
.data-table th { padding: 1rem 1.25rem; text-align: left; font-size: 0.8125rem; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; }
.data-table tbody tr { border-bottom: 1px solid var(--border-primary); transition: all 0.2s ease; }
.data-table tbody tr:hover { background: var(--bg-secondary); }
.data-table tbody tr:last-child { border-bottom: none; }
.data-table td { padding: 1.25rem; font-size: 0.9375rem; color: var(--text-primary); }
.checkbox-input { width: 18px; height: 18px; border: 2px solid var(--border-secondary); border-radius: 4px; cursor: pointer; accent-color: var(--accent-600); }
.table-user-info { display: flex; align-items: center; gap: 0.875rem; }
.user-avatar { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.875rem; flex-shrink: 0; }
.user-name { font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem; }
.user-meta { font-size: 0.8125rem; color: var(--text-secondary); }
.badge { display: inline-flex; padding: 0.375rem 0.875rem; border-radius: 6px; font-size: 0.8125rem; font-weight: 600; }
.badge-blue { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
.badge-purple { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }
.institution-info { font-size: 0.875rem; }
.institution-meta { font-size: 0.8125rem; color: var(--text-secondary); margin-top: 0.25rem; }
.division-info { font-size: 0.875rem; color: var(--text-primary); font-weight: 500; }
.location-info { font-size: 0.875rem; color: var(--text-secondary); display: flex; align-items: center; gap: 0.375rem; }
.location-info i { color: var(--accent-600); }
.period-info { font-size: 0.875rem; }
.period-meta { font-size: 0.8125rem; color: var(--text-secondary); margin-top: 0.25rem; }
.status-badge { display: inline-flex; align-items: center; padding: 0.375rem 0.875rem; border-radius: 9999px; font-size: 0.8125rem; font-weight: 600; }
.status-active { background: rgba(16, 185, 129, 0.1); color: var(--success-600); }
.status-pending { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
.status-finished { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }
.status-rejected { background: rgba(239, 68, 68, 0.1); color: var(--danger-500); }
.action-buttons { display: flex; gap: 0.5rem; }
.btn-action { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.2s ease; text-decoration: none; }
.btn-action-primary { background: linear-gradient(135deg, var(--accent-500), var(--accent-700)); color: white; }
.btn-action-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(6, 182, 212, 0.4); }
.empty-state { padding: 4rem 2rem; text-align: center; }
.empty-state-icon { font-size: 4rem; color: var(--gray-300); margin-bottom: 1.5rem; }
.empty-state-title { font-family: 'Outfit', sans-serif; font-size: 1.25rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem; }
.empty-state-text { font-size: 0.9375rem; color: var(--text-secondary); }
.pagination-container { display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; background: var(--bg-primary); border-radius: 16px; border: 1px solid var(--border-primary); margin-top: 1.5rem; box-shadow: var(--shadow-sm); }
.pagination-info { font-size: 0.875rem; color: var(--text-secondary); }
.pagination-info strong { color: var(--text-primary); font-weight: 600; }
.pagination { display: flex; gap: 0.5rem; }
.pagination-btn { min-width: 36px; height: 36px; padding: 0 0.75rem; border-radius: 8px; border: 1px solid var(--border-primary); background: white; color: var(--text-primary); font-weight: 600; font-size: 0.875rem; cursor: pointer; transition: all 0.2s ease; }
.pagination-btn:hover:not(:disabled) { border-color: var(--accent-500); background: var(--accent-500); color: white; }
.pagination-btn.active { background: var(--accent-500); border-color: var(--accent-500); color: white; }
.pagination-btn:disabled { opacity: 0.4; cursor: not-allowed; }

@media (max-width: 1200px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .stats-grid { grid-template-columns: 1fr; }
    .filter-group { flex-direction: column; }
    .filter-select { width: 100%; }
}
</style>

<script>
function participantList() {
    return {
        participants: [],
        selected: [],
        selectedAll: false,
        filters: { search: '', type: '', division: '', status: '' },
        currentPage: 1,
        perPage: 10,
        stats: { total: 128, active: 95, finished: 25, pending: 8 },
        
        init() { this.loadData(); },
        
        loadData() {
            const types = ['SISWA', 'MAHASISWA'];
            const statuses = ['active', 'pending', 'finished', 'rejected'];
            const divisions = ['IT', 'ADMIN', 'FINANCE', 'HR', 'MARKETING'];
            const rooms = ['A101', 'A102', 'B201', 'B202', 'C301', 'C302'];
            const colors = [
                { light: '#06b6d4', dark: '#0e7490' },
                { light: '#8b5cf6', dark: '#6d28d9' },
                { light: '#ec4899', dark: '#be185d' },
                { light: '#f59e0b', dark: '#d97706' },
                { light: '#10b981', dark: '#059669' }
            ];
            
            for (let i = 1; i <= 128; i++) {
                const color = colors[Math.floor(Math.random() * colors.length)];
                const type = types[Math.floor(Math.random() * types.length)];
                const startDate = new Date(2026, 0, Math.floor(Math.random() * 28) + 1);
                const duration = [30, 60, 90, 120, 180][Math.floor(Math.random() * 5)];
                const endDate = new Date(startDate.getTime() + duration * 24 * 60 * 60 * 1000);
                
                this.participants.push({
                    id: i,
                    name: `${type === 'SISWA' ? 'Siswa' : 'Mahasiswa'} Magang ${i}`,
                    identity_number: type === 'SISWA' ? `00${String(i).padStart(8, '0')}` : `NIM${String(i).padStart(9, '0')}`,
                    participant_type: type,
                    institution_name: `${type === 'SISWA' ? 'SMK' : 'Universitas'} Negeri ${Math.ceil(i/10)}`,
                    major: type === 'SISWA' ? 'Rekayasa Perangkat Lunak' : 'Teknik Informatika',
                    division: divisions[Math.floor(Math.random() * divisions.length)],
                    room: rooms[Math.floor(Math.random() * rooms.length)],
                    floor: Math.floor(Math.random() * 7) + 1,
                    start_date: startDate,
                    end_date: endDate,
                    duration: duration,
                    status: statuses[Math.floor(Math.random() * statuses.length)],
                    color: color.light,
                    colorDark: color.dark
                });
            }
        },
        
        get filteredData() {
            return this.participants.filter(item => {
                const matchSearch = !this.filters.search || 
                    item.name.toLowerCase().includes(this.filters.search.toLowerCase()) ||
                    item.identity_number.toLowerCase().includes(this.filters.search.toLowerCase()) ||
                    item.institution_name.toLowerCase().includes(this.filters.search.toLowerCase());
                
                const matchType = !this.filters.type || item.participant_type === this.filters.type;
                const matchDivision = !this.filters.division || item.division === this.filters.division;
                const matchStatus = !this.filters.status || item.status === this.filters.status;
                
                return matchSearch && matchType && matchDivision && matchStatus;
            });
        },
        
        get paginatedData() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.filteredData.slice(start, start + this.perPage);
        },
        
        get totalPages() {
            return Math.ceil(this.filteredData.length / this.perPage);
        },
        
        get paginationStart() {
            return (this.currentPage - 1) * this.perPage + 1;
        },
        
        get paginationEnd() {
            const end = this.currentPage * this.perPage;
            return end > this.filteredData.length ? this.filteredData.length : end;
        },
        
        applyFilters() {
            this.currentPage = 1;
        },
        
        resetFilters() {
            this.filters = { search: '', type: '', division: '', status: '' };
            this.currentPage = 1;
        },
        
        toggleSelectAll(e) {
            if (e.target.checked) {
                this.selected = this.paginatedData.map(item => item.id);
                this.selectedAll = true;
            } else {
                this.selected = [];
                this.selectedAll = false;
            }
        },
        
        formatPeriod(start, end) {
            const opts = { day: 'numeric', month: 'short', year: 'numeric' };
            return `${new Date(start).toLocaleDateString('id-ID', opts)} - ${new Date(end).toLocaleDateString('id-ID', opts)}`;
        },
        
        getStatusText(status) {
            const map = { 'active': 'Aktif', 'pending': 'Pending', 'finished': 'Selesai', 'rejected': 'Ditolak' };
            return map[status] || status;
        },
        
        exportData() {
            alert('Export to Excel');
        }
    }
}
</script>
@endsection
