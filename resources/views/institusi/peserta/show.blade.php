
@extends('layouts.dashboard')
@section('title', 'Detail Peserta - Dashboard Institusi')
@section('content')
<div x-data="participantDetail()">
    <div class="status-banner" :class="`status-${participant.status}`">
        <div class="status-content">
            <div class="status-icon"><i class="fas fa-user-graduate"></i></div>
            <div class="status-info">
                <h2 x-text="participant.name"></h2>
                <p x-text="participant.identity_number"></p>
            </div>
        </div>
        <span class="status-badge-large" x-text="getStatusText(participant.status)"></span>
    </div>

    <div class="action-bar">
        <a href="/institusi/dashboard/peserta" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="detail-grid">
        <div class="detail-column">
            <div class="info-card">
                <div class="card-header">
                    <h3><span class="card-icon"><i class="fas fa-user"></i></span>Data Pribadi</h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-id-card"></i>Nama</div>
                        <div class="info-value" x-text="participant.name"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-hashtag"></i>NIS/NIM</div>
                        <div class="info-value" x-text="participant.identity_number"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-envelope"></i>Email</div>
                        <div class="info-value" x-text="participant.email"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-phone"></i>Telepon</div>
                        <div class="info-value" x-text="participant.phone"></div>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <div class="card-header">
                    <h3><span class="card-icon"><i class="fas fa-briefcase"></i></span>Data Magang</h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-building"></i>Bidang</div>
                        <div class="info-value" x-text="participant.division"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-door-open"></i>Lokasi</div>
                        <div class="info-value" x-text="`${participant.room} - Lantai ${participant.floor}`"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-calendar"></i>Periode</div>
                        <div class="info-value" x-text="formatPeriod(participant.start_date,participant.end_date)"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="detail-sidebar">
            <div class="info-card">
                <div class="card-header">
                    <h3><span class="card-icon"><i class="fas fa-file-alt"></i></span>Laporan</h3>
                </div>
                <div class="card-body">
                    <div class="stats-mini">
                        <div class="stat-mini">
                            <div class="stat-mini-value" x-text="participant.reports_count"></div>
                            <div class="stat-mini-label">Total Laporan</div>
                        </div>
                        <div class="stat-mini">
                            <div class="stat-mini-value" x-text="participant.approved_reports"></div>
                            <div class="stat-mini-label">Disetujui</div>
                        </div>
                    </div>
                    <a :href="`/institusi/dashboard/laporan?participant_id=${participant.id}`" class="btn btn-primary btn-block">
                        <i class="fas fa-list"></i>
                        Lihat Semua Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.status-banner{border-radius:16px;padding:1.75rem 2rem;color:white;margin-bottom:1.5rem;display:flex;align-items:center;justify-content:space-between;box-shadow:0 8px 24px rgba(0,0,0,0.15)}.status-banner.status-active{background:linear-gradient(135deg,var(--success-500),var(--success-600))}.status-banner.status-pending{background:linear-gradient(135deg,#f59e0b,#d97706)}.status-banner.status-finished{background:linear-gradient(135deg,#8b5cf6,#6d28d9)}.status-content{display:flex;align-items:center;gap:1.25rem}.status-icon{width:56px;height:56px;background:rgba(255,255,255,0.2);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.75rem;backdrop-filter:blur(10px)}.status-info h2{font-family:'Outfit',sans-serif;font-size:1.5rem;font-weight:700;margin-bottom:0.375rem}.status-info p{font-size:0.9375rem;opacity:0.9}.status-badge-large{padding:0.625rem 1.5rem;background:rgba(255,255,255,0.2);border-radius:9999px;font-weight:700;font-size:0.875rem;backdrop-filter:blur(10px)}.action-bar{margin-bottom:1.5rem}.detail-grid{display:grid;grid-template-columns:1fr 400px;gap:1.5rem}.detail-column{display:flex;flex-direction:column;gap:1.5rem}.detail-sidebar{display:flex;flex-direction:column;gap:1.5rem}.info-card{background:var(--bg-primary);border-radius:16px;border:1px solid var(--border-primary);overflow:hidden;box-shadow:var(--shadow-sm)}.card-header{padding:1.5rem;border-bottom:1px solid var(--border-primary);background:linear-gradient(180deg,var(--gray-50) 0%,transparent 100%)}.card-header h3{font-family:'Outfit',sans-serif;font-size:1.125rem;font-weight:700;display:flex;align-items:center;gap:0.625rem}.card-icon{width:32px;height:32px;background:linear-gradient(135deg,var(--accent-500),var(--accent-700));border-radius:8px;display:flex;align-items:center;justify-content:center;color:white;font-size:0.875rem}.card-body{padding:1.75rem}.info-row{display:grid;grid-template-columns:140px 1fr;gap:1rem;padding:1rem 0;border-bottom:1px solid var(--border-primary)}.info-row:last-child{border-bottom:none;padding-bottom:0}.info-row:first-child{padding-top:0}.info-label{font-size:0.875rem;font-weight:600;color:var(--text-secondary);display:flex;align-items:center;gap:0.5rem}.info-label i{color:var(--accent-600)}.info-value{font-size:0.9375rem;font-weight:500;color:var(--text-primary)}.stats-mini{display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;margin-bottom:1rem}.stat-mini{text-align:center;padding:1rem;background:var(--bg-secondary);border-radius:10px}.stat-mini-value{font-family:'Outfit',sans-serif;font-size:1.75rem;font-weight:800;color:var(--text-primary)}.stat-mini-label{font-size:0.8125rem;color:var(--text-secondary);margin-top:0.25rem}.btn{display:inline-flex;align-items:center;gap:0.625rem;padding:0.75rem 1.5rem;border-radius:10px;font-weight:600;font-size:0.9375rem;transition:all 0.2s ease;border:none;cursor:pointer;text-decoration:none}.btn-primary{background:var(--primary-800);color:white}.btn-primary:hover{background:var(--primary-700)}.btn-secondary{background:var(--gray-200);color:var(--text-primary)}.btn-block{width:100%;justify-content:center}@media(max-width:1024px){.detail-grid{grid-template-columns:1fr}}
</style>

<script>
function participantDetail(){return{participant:{id:1,name:'Ahmad Fauzi',identity_number:'NIS0012345678',email:'ahmad@example.com',phone:'081234567890',division:'IT & Development',room:'A101',floor:1,start_date:'2026-01-15',end_date:'2026-06-30',status:'active',reports_count:12,approved_reports:10},formatPeriod(start,end){const opts={year:'numeric',month:'long',day:'numeric'};return`${new Date(start).toLocaleDateString('id-ID',opts)} - ${new Date(end).toLocaleDateString('id-ID',opts)}`},getStatusText(status){const map={'active':'Aktif','pending':'Pending','finished':'Selesai'};return map[status]||status}}}
</script>
@endsection
