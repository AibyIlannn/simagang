@extends('layouts.dashboard')
@section('title', 'Laporan Peserta - Dashboard Institusi')
@section('content')
<div x-data="reportList()">
    <div class="page-header">
        <div class="page-header-content">
            <div>
                <h1 class="page-title">Laporan Peserta Magang</h1>
                <p class="page-subtitle">Monitor laporan dari seluruh peserta magang</p>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,rgba(6,182,212,0.15),rgba(6,182,212,0.05))">
                <i class="fas fa-file-alt" style="color:var(--accent-600)"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" x-text="stats.total"></div>
                <div class="stat-label">Total Laporan</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,rgba(16,185,129,0.15),rgba(16,185,129,0.05))">
                <i class="fas fa-check-circle" style="color:var(--success-600)"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" x-text="stats.approved"></div>
                <div class="stat-label">Disetujui</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,rgba(245,158,11,0.15),rgba(245,158,11,0.05))">
                <i class="fas fa-clock" style="color:#f59e0b"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" x-text="stats.pending"></div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
    </div>

    <div class="filter-section">
        <div class="filter-group">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Cari judul laporan atau nama peserta..." x-model="filters.search" @input.debounce.300ms="applyFilters">
            </div>
            <select x-model="filters.status" @change="applyFilters" class="filter-select">
                <option value="">Semua Status</option>
                <option value="submitted">Submitted</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
            <button @click="resetFilters" class="btn btn-ghost">
                <i class="fas fa-redo"></i>
                Reset
            </button>
        </div>
    </div>

    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Laporan</th>
                    <th>Peserta</th>
                    <th>Tanggal Submit</th>
                    <th>Status</th>
                    <th style="width:100px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="r in paginatedData" :key="r.id">
                    <tr>
                        <td>
                            <div class="report-info">
                                <div class="report-title" x-text="r.title"></div>
                                <div class="report-meta">
                                    <i class="fas fa-file-pdf"></i>
                                    <span x-text="r.file_size"></span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="participant-info" x-text="r.participant_name"></div>
                        </td>
                        <td>
                            <div class="date-info" x-text="formatDate(r.submitted_at)"></div>
                        </td>
                        <td>
                            <span class="status-badge" :class="`status-${r.status}`" x-text="getStatusText(r.status)"></span>
                        </td>
                        <td>
                            <a :href="`/institusi/dashboard/laporan/${r.id}`" class="btn-action btn-action-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
        <div x-show="filteredData.length===0" class="empty-state">
            <div class="empty-state-icon"><i class="fas fa-file-alt"></i></div>
            <div class="empty-state-title">Tidak ada laporan</div>
        </div>
    </div>

    <div class="pagination-container" x-show="filteredData.length>0">
        <div class="pagination-info">Menampilkan <strong x-text="paginationStart"></strong> - <strong x-text="paginationEnd"></strong> dari <strong x-text="filteredData.length"></strong></div>
        <div class="pagination">
            <button @click="currentPage--" :disabled="currentPage===1" class="pagination-btn"><i class="fas fa-chevron-left"></i></button>
            <template x-for="page in totalPages" :key="page">
                <button @click="currentPage=page" class="pagination-btn" :class="{'active':currentPage===page}" x-text="page"></button>
            </template>
            <button @click="currentPage++" :disabled="currentPage===totalPages" class="pagination-btn"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</div>

<style>
.page-header{margin-bottom:2rem}.page-header-content{display:flex;justify-content:space-between}.page-title{font-family:'Outfit',sans-serif;font-size:2rem;font-weight:800;color:var(--text-primary);margin-bottom:0.5rem}.page-subtitle{font-size:0.9375rem;color:var(--text-secondary)}.stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;margin-bottom:2rem}.stat-card{background:var(--bg-primary);border-radius:16px;border:1px solid var(--border-primary);padding:1.5rem;display:flex;gap:1.25rem;align-items:center;box-shadow:var(--shadow-sm);transition:all 0.2s ease}.stat-card:hover{border-color:var(--accent-500);box-shadow:var(--shadow-md);transform:translateY(-2px)}.stat-icon{width:56px;height:56px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.5rem}.stat-value{font-family:'Outfit',sans-serif;font-size:2rem;font-weight:800;color:var(--text-primary);margin-bottom:0.375rem}.stat-label{font-size:0.875rem;color:var(--text-secondary)}.filter-section{background:var(--bg-primary);border-radius:16px;border:1px solid var(--border-primary);padding:1.25rem 1.5rem;margin-bottom:1.5rem}.filter-group{display:flex;gap:0.75rem}.search-box{flex:1;position:relative}.search-box i{position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:var(--text-tertiary)}.search-box input{width:100%;padding:0.75rem 1rem 0.75rem 2.75rem;border:1px solid var(--border-primary);border-radius:10px;background:var(--bg-secondary)}.search-box input:focus{outline:none;border-color:var(--accent-500);background:white;box-shadow:0 0 0 3px rgba(6,182,212,0.1)}.filter-select{padding:0.75rem 1rem;border:1px solid var(--border-primary);border-radius:10px;background:var(--bg-secondary);min-width:150px}.btn{display:inline-flex;align-items:center;gap:0.625rem;padding:0.75rem 1.5rem;border-radius:10px;font-weight:600;border:none;cursor:pointer}.btn-ghost{background:transparent;color:var(--text-secondary);border:1px solid var(--border-primary)}.btn-ghost:hover{background:var(--bg-secondary);border-color:var(--accent-500)}.data-table-container{background:var(--bg-primary);border-radius:16px;border:1px solid var(--border-primary);overflow:hidden}.data-table{width:100%;border-collapse:collapse}.data-table thead{background:linear-gradient(180deg,var(--gray-50) 0%,transparent 100%);border-bottom:2px solid var(--border-primary)}.data-table th{padding:1rem 1.25rem;text-align:left;font-size:0.8125rem;font-weight:700;color:var(--text-secondary);text-transform:uppercase}.data-table tbody tr{border-bottom:1px solid var(--border-primary)}.data-table tbody tr:hover{background:var(--bg-secondary)}.data-table td{padding:1.25rem;font-size:0.9375rem}.report-info{}.report-title{font-weight:600;margin-bottom:0.25rem}.report-meta{font-size:0.8125rem;color:var(--text-secondary);display:flex;align-items:center;gap:0.5rem}.report-meta i{color:var(--danger-500)}.participant-info{font-size:0.875rem}.date-info{font-size:0.875rem;color:var(--text-secondary)}.status-badge{display:inline-flex;padding:0.375rem 0.875rem;border-radius:9999px;font-size:0.8125rem;font-weight:600}.status-submitted{background:rgba(59,130,246,0.1);color:#3b82f6}.status-approved{background:rgba(16,185,129,0.1);color:var(--success-600)}.status-rejected{background:rgba(239,68,68,0.1);color:var(--danger-500)}.btn-action{width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:all 0.2s ease}.btn-action-primary{background:linear-gradient(135deg,var(--accent-500),var(--accent-700));color:white}.btn-action-primary:hover{transform:translateY(-2px);box-shadow:0 4px 12px rgba(6,182,212,0.4)}.empty-state{padding:4rem 2rem;text-align:center}.empty-state-icon{font-size:4rem;color:var(--gray-300);margin-bottom:1.5rem}.empty-state-title{font-family:'Outfit',sans-serif;font-size:1.25rem;font-weight:700}.pagination-container{display:flex;justify-content:space-between;align-items:center;padding:1.5rem;background:var(--bg-primary);border-radius:16px;border:1px solid var(--border-primary);margin-top:1.5rem}.pagination-info{font-size:0.875rem;color:var(--text-secondary)}.pagination{display:flex;gap:0.5rem}.pagination-btn{min-width:36px;height:36px;border-radius:8px;border:1px solid var(--border-primary);background:white;cursor:pointer}.pagination-btn:hover:not(:disabled){border-color:var(--accent-500);background:var(--accent-500);color:white}.pagination-btn.active{background:var(--accent-500);color:white}.pagination-btn:disabled{opacity:0.4;cursor:not-allowed}@media(max-width:768px){.stats-grid{grid-template-columns:1fr}.filter-group{flex-direction:column}}
</style>

<script>
function reportList(){return{reports:[],filters:{search:'',status:''},currentPage:1,perPage:10,stats:{total:156,approved:120,pending:36},init(){this.loadData()},loadData(){const statuses=['submitted','approved','rejected'];for(let i=1;i<=156;i++){this.reports.push({id:i,title:`Laporan Kegiatan Minggu ke-${Math.ceil(i/10)}`,participant_name:`Peserta ${i}`,file_size:`${(Math.random()*3+1).toFixed(1)} MB`,submitted_at:new Date(2026,Math.floor(Math.random()*2),Math.floor(Math.random()*28)+1),status:statuses[Math.floor(Math.random()*statuses.length)]})}},get filteredData(){return this.reports.filter(item=>{const matchSearch=!this.filters.search||item.title.toLowerCase().includes(this.filters.search.toLowerCase())||item.participant_name.toLowerCase().includes(this.filters.search.toLowerCase());const matchStatus=!this.filters.status||item.status===this.filters.status;return matchSearch&&matchStatus})},get paginatedData(){const start=(this.currentPage-1)*this.perPage;return this.filteredData.slice(start,start+this.perPage)},get totalPages(){return Math.ceil(this.filteredData.length/this.perPage)},get paginationStart(){return(this.currentPage-1)*this.perPage+1},get paginationEnd(){const end=this.currentPage*this.perPage;return end>this.filteredData.length?this.filteredData.length:end},applyFilters(){this.currentPage=1},resetFilters(){this.filters={search:'',status:''};this.currentPage=1},formatDate(date){return new Date(date).toLocaleDateString('id-ID',{year:'numeric',month:'long',day:'numeric'})},getStatusText(status){const map={'submitted':'Submitted','approved':'Disetujui','rejected':'Ditolak'};return map[status]||status}}}
</script>
@endsection
