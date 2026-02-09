@extends('layouts.dashboard')

@section('title', 'Detail Laporan - Admin Dashboard')

@section('content')
<div x-data="reportDetail()">
    <!-- Status Banner -->
    <div class="status-banner" :class="`status-${report.status}`">
        <div class="status-content">
            <div class="status-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="status-info">
                <h2 x-text="report.title"></h2>
                <p x-text="`oleh ${report.participant_name} • ${report.institution_name}`"></p>
            </div>
        </div>
        <div>
            <span class="status-badge-large" x-text="getStatusText(report.status)"></span>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="action-bar">
        <a href="/admin/dashboard/laporan" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
        <div class="action-bar-right">
            <template x-if="report.status === 'submitted' || report.status === 'reviewed'">
                <div class="approval-buttons">
                    <button @click="approveReport" class="btn btn-success">
                        <i class="fas fa-check"></i>
                        Setujui Laporan
                    </button>
                    <button @click="showRejectModal = true" class="btn btn-danger">
                        <i class="fas fa-times"></i>
                        Tolak Laporan
                    </button>
                </div>
            </template>
            
            <a :href="report.file_url" download class="btn btn-primary">
                <i class="fas fa-download"></i>
                Download File
            </a>
            
            <button @click="confirmDelete" class="btn btn-danger-outline">
                <i class="fas fa-trash"></i>
                Hapus
            </button>
        </div>
    </div>

    <!-- Detail Grid -->
    <div class="detail-grid">
        <div class="detail-column">
            <!-- Report Info -->
            <div class="info-card">
                <div class="card-header">
                    <h3>
                        <span class="card-header-icon">
                            <i class="fas fa-info-circle"></i>
                        </span>
                        Informasi Laporan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-heading"></i> Judul Laporan</div>
                        <div class="info-value" x-text="report.title"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-calendar-alt"></i> Tanggal Submit</div>
                        <div class="info-value" x-text="formatDate(report.submitted_at)"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-file-pdf"></i> File</div>
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
                        <div class="info-label"><i class="fas fa-align-left"></i> Deskripsi</div>
                        <div class="info-value" x-text="report.description || 'Tidak ada deskripsi'"></div>
                    </div>
                </div>
            </div>

            <!-- Participant Info -->
            <div class="info-card">
                <div class="card-header">
                    <h3>
                        <span class="card-header-icon">
                            <i class="fas fa-user"></i>
                        </span>
                        Informasi Peserta
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-id-card"></i> Nama Peserta</div>
                        <div class="info-value">
                            <strong x-text="report.participant_name"></strong>
                            <span class="info-value-secondary" x-text="report.participant_id_number"></span>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-building"></i> Institusi</div>
                        <div class="info-value" x-text="report.institution_name"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-briefcase"></i> Bidang Magang</div>
                        <div class="info-value" x-text="report.division"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-door-open"></i> Lokasi</div>
                        <div class="info-value" x-text="`${report.room} - Lantai ${report.floor}`"></div>
                    </div>
                </div>
            </div>

            <!-- Admin Review (if exists) -->
            <div class="info-card" x-show="report.admin_note">
                <div class="card-header">
                    <h3>
                        <span class="card-header-icon">
                            <i class="fas fa-comment-dots"></i>
                        </span>
                        Review Admin
                    </h3>
                </div>
                <div class="card-body">
                    <div class="review-content">
                        <p x-text="report.admin_note"></p>
                        <div class="review-meta">
                            <span>Review oleh: <strong x-text="report.reviewer_name"></strong></span>
                            <span>•</span>
                            <span x-text="formatDate(report.reviewed_at)"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="detail-sidebar">
            <!-- Timeline -->
            <div class="info-card">
                <div class="card-header">
                    <h3>
                        <span class="card-header-icon">
                            <i class="fas fa-history"></i>
                        </span>
                        Timeline
                    </h3>
                </div>
                <div class="card-body">
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            <i class="fas fa-upload"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">Laporan Disubmit</div>
                            <div class="timeline-date">
                                <i class="fas fa-clock"></i>
                                <span x-text="formatDate(report.submitted_at)"></span>
                            </div>
                        </div>
                    </div>
                    <template x-if="report.reviewed_at">
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Direview Admin</div>
                                <div class="timeline-date">
                                    <i class="fas fa-clock"></i>
                                    <span x-text="formatDate(report.reviewed_at)"></span>
                                </div>
                                <div class="timeline-validator" x-text="`oleh ${report.reviewer_name}`"></div>
                            </div>
                        </div>
                    </template>
                    <template x-if="report.status === 'approved'">
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Laporan Disetujui</div>
                                <div class="timeline-date">
                                    <i class="fas fa-clock"></i>
                                    <span x-text="formatDate(report.approved_at)"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="info-card">
                <div class="card-header">
                    <h3>
                        <span class="card-header-icon">
                            <i class="fas fa-bolt"></i>
                        </span>
                        Aksi Cepat
                    </h3>
                </div>
                <div class="card-body">
                    <div class="quick-actions">
                        <a :href="`/admin/dashboard/peserta/${report.participant_id}`" class="quick-action-btn">
                            <i class="fas fa-user"></i>
                            <span>Lihat Profil Peserta</span>
                        </a>
                        <a :href="`/admin/dashboard/laporan?participant_id=${report.participant_id}`" class="quick-action-btn">
                            <i class="fas fa-list"></i>
                            <span>Laporan Lainnya</span>
                        </a>
                        <button @click="showNoteModal = true" class="quick-action-btn">
                            <i class="fas fa-sticky-note"></i>
                            <span>Tambah Catatan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- REJECT MODAL -->
    <div x-show="showRejectModal" class="modal-overlay" x-transition @click="showRejectModal = false" x-cloak>
        <div class="modal-container modal-sm" @click.stop>
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-times-circle"></i>
                    Tolak Laporan
                </h3>
                <button @click="showRejectModal = false" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form @submit.prevent="rejectReport">
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Perhatian!</strong>
                            <p>Anda akan menolak laporan "<strong x-text="report.title"></strong>". Berikan alasan penolakan.</p>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Alasan Penolakan <span class="form-label-required">*</span></label>
                        <textarea x-model="rejectReason" class="form-textarea" rows="4" placeholder="Jelaskan alasan penolakan..." required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="showRejectModal = false">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i>
                        Tolak Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- NOTE MODAL -->
    <div x-show="showNoteModal" class="modal-overlay" x-transition @click="showNoteModal = false" x-cloak>
        <div class="modal-container modal-sm" @click.stop>
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-sticky-note"></i>
                    Tambah Catatan
                </h3>
                <button @click="showNoteModal = false" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form @submit.prevent="saveNote">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Catatan <span class="form-label-required">*</span></label>
                        <textarea x-model="noteContent" class="form-textarea" rows="5" placeholder="Tambahkan catatan untuk laporan ini..." required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="showNoteModal = false">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Simpan Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.status-banner{border-radius:16px;padding:1.75rem 2rem;color:white;margin-bottom:1.5rem;display:flex;align-items:center;justify-content:space-between;box-shadow:0 8px 24px rgba(0,0,0,0.15)}.status-banner.status-submitted{background:linear-gradient(135deg,#3b82f6,#2563eb)}.status-banner.status-reviewed{background:linear-gradient(135deg,#8b5cf6,#6d28d9)}.status-banner.status-approved{background:linear-gradient(135deg,var(--success-500),var(--success-600))}.status-banner.status-rejected{background:linear-gradient(135deg,var(--danger-500),#dc2626)}.status-content{display:flex;align-items:center;gap:1.25rem}.status-icon{width:56px;height:56px;background:rgba(255,255,255,0.2);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.75rem;flex-shrink:0;backdrop-filter:blur(10px)}.status-info h2{font-family:'Outfit',sans-serif;font-size:1.5rem;font-weight:700;margin-bottom:0.375rem;letter-spacing:-0.02em}.status-info p{font-size:0.9375rem;opacity:0.9}.status-badge-large{padding:0.625rem 1.5rem;background:rgba(255,255,255,0.2);border-radius:9999px;font-weight:700;font-size:0.875rem;backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.3)}.action-bar{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;gap:1rem}.action-bar-right{display:flex;gap:0.75rem}.approval-buttons{display:flex;gap:0.75rem}.detail-grid{display:grid;grid-template-columns:1fr 400px;gap:1.5rem}.detail-column{display:flex;flex-direction:column;gap:1.5rem}.detail-sidebar{display:flex;flex-direction:column;gap:1.5rem}.info-card{background:var(--bg-primary);border-radius:16px;border:1px solid var(--border-primary);overflow:hidden;box-shadow:var(--shadow-sm)}.card-header{padding:1.5rem 1.75rem;border-bottom:1px solid var(--border-primary);background:linear-gradient(180deg,var(--gray-50) 0%,transparent 100%)}.card-header h3{font-family:'Outfit',sans-serif;font-size:1.125rem;font-weight:700;color:var(--text-primary);display:flex;align-items:center;gap:0.625rem}.card-header-icon{width:32px;height:32px;background:linear-gradient(135deg,var(--accent-500),var(--accent-700));border-radius:8px;display:flex;align-items:center;justify-content:center;color:white;font-size:0.875rem}.card-body{padding:1.75rem}.info-row{display:grid;grid-template-columns:140px 1fr;gap:1rem;padding:1rem 0;border-bottom:1px solid var(--border-primary)}.info-row:last-child{border-bottom:none;padding-bottom:0}.info-row:first-child{padding-top:0}.info-label{font-size:0.875rem;font-weight:600;color:var(--text-secondary);display:flex;align-items:center;gap:0.5rem}.info-label i{font-size:0.875rem;color:var(--accent-600)}.info-value{font-size:0.9375rem;font-weight:500;color:var(--text-primary)}.info-value strong{font-weight:700;color:var(--primary-800)}.info-value-secondary{display:block;font-size:0.8125rem;color:var(--text-secondary);margin-top:0.25rem}.file-display{display:flex;align-items:center;gap:1rem;padding:1rem;background:var(--bg-secondary);border-radius:10px;border:1px solid var(--border-primary)}.file-display i{font-size:1.5rem;color:var(--danger-500)}.file-size{font-size:0.8125rem;color:var(--text-secondary);margin-top:0.25rem}.review-content{font-size:0.9375rem;line-height:1.6;color:var(--text-primary)}.review-meta{margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border-primary);font-size:0.8125rem;color:var(--text-secondary);display:flex;gap:0.5rem}.timeline-item{display:flex;gap:1.25rem;padding:1.25rem 0;border-bottom:1px solid var(--border-primary)}.timeline-item:last-child{border-bottom:none;padding-bottom:0}.timeline-item:first-child{padding-top:0}.timeline-icon{width:48px;height:48px;background:linear-gradient(135deg,rgba(6,182,212,0.1),rgba(6,182,212,0.05));border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2px solid var(--accent-500)}.timeline-icon i{color:var(--accent-600);font-size:1.125rem}.timeline-content{flex:1}.timeline-title{font-weight:600;font-size:0.9375rem;color:var(--text-primary);margin-bottom:0.375rem}.timeline-date{font-size:0.8125rem;color:var(--text-secondary);display:flex;align-items:center;gap:0.375rem}.timeline-validator{font-size:0.8125rem;color:var(--text-tertiary);margin-top:0.25rem}.quick-actions{display:flex;flex-direction:column;gap:0.75rem}.quick-action-btn{display:flex;align-items:center;gap:0.875rem;padding:1rem;background:var(--bg-secondary);border:1px solid var(--border-primary);border-radius:10px;color:var(--text-primary);text-decoration:none;font-weight:500;transition:all 0.2s ease;cursor:pointer}.quick-action-btn:hover{background:white;border-color:var(--accent-500);box-shadow:var(--shadow-md)}.quick-action-btn i{width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,var(--accent-500),var(--accent-700));color:white;display:flex;align-items:center;justify-content:center}.btn{display:inline-flex;align-items:center;gap:0.625rem;padding:0.75rem 1.5rem;border-radius:10px;font-weight:600;font-size:0.9375rem;transition:all 0.2s ease;border:none;cursor:pointer;text-decoration:none}.btn-primary{background:var(--primary-800);color:white}.btn-primary:hover{background:var(--primary-700);transform:translateY(-2px);box-shadow:var(--shadow-md)}.btn-secondary{background:var(--gray-200);color:var(--text-primary)}.btn-secondary:hover{background:var(--gray-300);transform:translateY(-2px);box-shadow:var(--shadow-md)}.btn-success{background:var(--success-500);color:white}.btn-success:hover{background:var(--success-600);transform:translateY(-2px);box-shadow:var(--shadow-md)}.btn-danger{background:var(--danger-500);color:white}.btn-danger:hover{background:#dc2626;transform:translateY(-2px);box-shadow:var(--shadow-md)}.btn-danger-outline{background:transparent;color:var(--danger-500);border:1px solid var(--danger-500)}.btn-danger-outline:hover{background:var(--danger-500);color:white}.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);z-index:9998;display:flex;align-items:center;justify-content:center;padding:2rem}.modal-container{background:white;border-radius:20px;max-width:500px;width:100%;max-height:90vh;overflow-y:auto;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25)}.modal-header{padding:1.75rem 2rem;border-bottom:1px solid var(--border-primary);display:flex;justify-content:space-between;align-items:center}.modal-title{font-family:'Outfit',sans-serif;font-size:1.25rem;font-weight:700;color:var(--text-primary);display:flex;align-items:center;gap:0.75rem}.modal-close{width:36px;height:36px;border-radius:8px;border:none;background:var(--gray-100);color:var(--text-secondary);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s ease}.modal-close:hover{background:var(--gray-200);color:var(--text-primary)}.modal-body{padding:2rem}.modal-footer{padding:1.5rem 2rem;border-top:1px solid var(--border-primary);display:flex;justify-content:flex-end;gap:0.75rem}.form-group{display:flex;flex-direction:column}.form-label{font-size:0.875rem;font-weight:600;color:var(--text-primary);margin-bottom:0.5rem}.form-label-required{color:var(--danger-500)}.form-textarea{width:100%;padding:0.875rem;border:1px solid var(--border-primary);border-radius:10px;font-size:0.9375rem;font-family:inherit;resize:vertical;transition:all 0.2s ease}.form-textarea:focus{outline:none;border-color:var(--accent-500);box-shadow:0 0 0 3px rgba(6,182,212,0.1)}.alert{padding:1rem 1.25rem;border-radius:12px;display:flex;gap:1rem;margin-bottom:1.5rem}.alert-warning{background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.3)}.alert i{font-size:1.25rem;color:#f59e0b;flex-shrink:0}.alert strong{display:block;font-weight:700;margin-bottom:0.25rem;color:var(--text-primary)}.alert p{font-size:0.875rem;color:var(--text-secondary);margin:0}[x-cloak]{display:none!important}@media(max-width:1024px){.detail-grid{grid-template-columns:1fr}.action-bar{flex-direction:column;align-items:stretch}.action-bar-right{flex-direction:column}}
</style>

<script>
function reportDetail(){return{report:{id:1,title:'Laporan Kegiatan Magang Minggu ke-8',participant_id:1,participant_name:'Ahmad Fauzi Rahman',participant_id_number:'NIS0012345678',institution_name:'SMK Negeri 1 Jakarta',division:'IT & Development',room:'A101',floor:1,file_name:'laporan-minggu-8.pdf',file_size:'2.8 MB',file_url:'#',description:'Laporan kegiatan magang pada minggu ke-8 yang mencakup pembelajaran tentang pengembangan web dengan framework Laravel dan Vue.js',submitted_at:'2026-02-01',reviewed_at:null,approved_at:null,reviewer_name:null,admin_note:null,status:'submitted'},showRejectModal:!1,showNoteModal:!1,rejectReason:'',noteContent:'',approveReport(){if(confirm(`Setujui laporan "${this.report.title}"?`)){this.report.status='approved';this.report.approved_at=new Date().toISOString().split('T')[0];this.report.reviewed_at=new Date().toISOString().split('T')[0];this.report.reviewer_name='Admin Sistem';alert('Laporan berhasil disetujui!')}},rejectReport(){this.report.status='rejected';this.report.admin_note=`DITOLAK: ${this.rejectReason}`;this.report.reviewed_at=new Date().toISOString().split('T')[0];this.report.reviewer_name='Admin Sistem';alert('Laporan telah ditolak.');this.showRejectModal=!1;this.rejectReason=''},saveNote(){this.report.admin_note=this.noteContent;this.report.reviewed_at=new Date().toISOString().split('T')[0];this.report.reviewer_name='Admin Sistem';this.report.status='reviewed';alert('Catatan berhasil disimpan!');this.showNoteModal=!1;this.noteContent=''},confirmDelete(){if(confirm(`PERINGATAN!\n\nHapus laporan "${this.report.title}"?\n\nTindakan ini tidak dapat dibatalkan.`)){alert('Laporan berhasil dihapus!');window.location.href='/admin/dashboard/laporan'}},formatDate(dateString){return new Date(dateString).toLocaleDateString('id-ID',{year:'numeric',month:'long',day:'numeric'})},getStatusText(status){const map={'submitted':'Submitted','reviewed':'Reviewed','approved':'Disetujui','rejected':'Ditolak'};return map[status]||status}}}
</script>
@endsection
