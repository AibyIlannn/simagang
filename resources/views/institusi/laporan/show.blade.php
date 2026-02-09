@extends('layouts.dashboard')
@section('title', 'Detail Laporan - Dashboard Institusi')
@section('content')
<div x-data="reportDetail()">
    <div class="status-banner" :class="`status-${report.status}`">
        <div class="status-content">
            <div class="status-icon"><i class="fas fa-file-alt"></i></div>
            <div class="status-info">
                <h2 x-text="report.title"></h2>
                <p x-text="`oleh ${report.participant_name}`"></p>
            </div>
        </div>
        <span class="status-badge-large" x-text="getStatusText(report.status)"></span>
    </div>

    <div class="action-bar">
        <a href="/institusi/dashboard/laporan" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
        <a :href="report.file_url" download class="btn btn-primary">
            <i class="fas fa-download"></i>
            Download File
        </a>
    </div>

    <div class="detail-grid">
        <div class="detail-column">
            <div class="info-card">
                <div class="card-header">
                    <h3><span class="card-icon"><i class="fas fa-info-circle"></i></span>Informasi Laporan</h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-heading"></i>Judul</div>
                        <div class="info-value" x-text="report.title"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-calendar"></i>Tanggal Submit</div>
                        <div class="info-value" x-text="formatDate(report.submitted_at)"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-file-pdf"></i>File</div>
                        <div class="info-value">
                            <div class="file-display">
                                <i class="fas fa-file-pdf"></i>
                                <div>
                                    <div x-text="report.file_name"></div>
                                    <div class="file-size" x-text="report.file_size"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-align-left"></i>Deskripsi</div>
                        <div class="info-value" x-text="report.description||'Tidak ada deskripsi'"></div>
                    </div>
                </div>
            </div>

            <div class="info-card" x-show="report.admin_note">
                <div class="card-header">
                    <h3><span class="card-icon"><i class="fas fa-comment"></i></span>Catatan Admin</h3>
                </div>
                <div class="card-body">
                    <div class="admin-note" x-text="report.admin_note"></div>
                </div>
            </div>
        </div>

        <div class="detail-sidebar">
            <div class="info-card">
                <div class="card-header">
                    <h3><span class="card-icon"><i class="fas fa-user"></i></span>Peserta</h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label">Nama</div>
                        <div class="info-value" x-text="report.participant_name"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">NIS/NIM</div>
                        <div class="info-value" x-text="report.participant_id_number"></div>
                    </div>
                    <a :href="`/institusi/dashboard/peserta/${report.participant_id}`" class="btn btn-primary btn-block">
                        <i class="fas fa-eye"></i>
                        Lihat Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.status-banner{border-radius:16px;padding:1.75rem 2rem;color:white;margin-bottom:1.5rem;display:flex;align-items:center;justify-content:space-between;box-shadow:0 8px 24px rgba(0,0,0,0.15)}.status-banner.status-submitted{background:linear-gradient(135deg,#3b82f6,#2563eb)}.status-banner.status-approved{background:linear-gradient(135deg,var(--success-500),var(--success-600))}.status-banner.status-rejected{background:linear-gradient(135deg,var(--danger-500),#dc2626)}.status-content{display:flex;align-items:center;gap:1.25rem}.status-icon{width:56px;height:56px;background:rgba(255,255,255,0.2);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.75rem;backdrop-filter:blur(10px)}.status-info h2{font-family:'Outfit',sans-serif;font-size:1.5rem;font-weight:700;margin-bottom:0.375rem}.status-info p{font-size:0.9375rem;opacity:0.9}.status-badge-large{padding:0.625rem 1.5rem;background:rgba(255,255,255,0.2);border-radius:9999px;font-weight:700;font-size:0.875rem}.action-bar{display:flex;gap:0.75rem;margin-bottom:1.5rem}.detail-grid{display:grid;grid-template-columns:1fr 400px;gap:1.5rem}.detail-column{display:flex;flex-direction:column;gap:1.5rem}.detail-sidebar{display:flex;flex-direction:column;gap:1.5rem}.info-card{background:var(--bg-primary);border-radius:16px;border:1px solid var(--border-primary);overflow:hidden}.card-header{padding:1.5rem;border-bottom:1px solid var(--border-primary);background:linear-gradient(180deg,var(--gray-50) 0%,transparent 100%)}.card-header h3{font-family:'Outfit',sans-serif;font-size:1.125rem;font-weight:700;display:flex;align-items:center;gap:0.625rem}.card-icon{width:32px;height:32px;background:linear-gradient(135deg,var(--accent-500),var(--accent-700));border-radius:8px;display:flex;align-items:center;justify-content:center;color:white}.card-body{padding:1.75rem}.info-row{display:grid;grid-template-columns:140px 1fr;gap:1rem;padding:1rem 0;border-bottom:1px solid var(--border-primary)}.info-row:last-child{border-bottom:none;padding-bottom:0}.info-row:first-child{padding-top:0}.info-label{font-size:0.875rem;font-weight:600;color:var(--text-secondary);display:flex;align-items:center;gap:0.5rem}.info-label i{color:var(--accent-600)}.info-value{font-size:0.9375rem;font-weight:500}.file-display{display:flex;align-items:center;gap:1rem;padding:1rem;background:var(--bg-secondary);border-radius:10px}.file-display i{font-size:1.5rem;color:var(--danger-500)}.file-size{font-size:0.8125rem;color:var(--text-secondary);margin-top:0.25rem}.admin-note{font-size:0.9375rem;line-height:1.6}.btn{display:inline-flex;align-items:center;gap:0.625rem;padding:0.75rem 1.5rem;border-radius:10px;font-weight:600;border:none;cursor:pointer;text-decoration:none}.btn-primary{background:var(--primary-800);color:white}.btn-primary:hover{background:var(--primary-700)}.btn-secondary{background:var(--gray-200);color:var(--text-primary)}.btn-block{width:100%;justify-content:center}@media(max-width:1024px){.detail-grid{grid-template-columns:1fr}}
</style>

<script>
function reportDetail(){return{report:{id:1,title:'Laporan Kegiatan Magang Minggu ke-8',participant_id:1,participant_name:'Ahmad Fauzi',participant_id_number:'NIS0012345678',file_name:'laporan-minggu-8.pdf',file_size:'2.8 MB',file_url:'#',description:'Laporan kegiatan magang pada minggu ke-8',submitted_at:'2026-02-01',status:'submitted',admin_note:null},formatDate(dateString){return new Date(dateString).toLocaleDateString('id-ID',{year:'numeric',month:'long',day:'numeric'})},getStatusText(status){const map={'submitted':'Submitted','approved':'Disetujui','rejected':'Ditolak'};return map[status]||status}}}
</script>
@endsection
