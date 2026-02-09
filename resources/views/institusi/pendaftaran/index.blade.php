@extends('layouts.dashboard')

@section('title', 'Pengajuan Magang - Dashboard Institusi')

@section('content')
<div x-data="applicationForm()">
    <div class="page-header">
        <div class="page-header-content">
            <div>
                <h1 class="page-title">Pengajuan Program Magang</h1>
                <p class="page-subtitle">Ajukan program magang baru untuk institusi Anda</p>
            </div>
        </div>
    </div>

    <!-- Application History -->
    <div class="history-section">
        <h3 class="section-title">
            <i class="fas fa-history"></i>
            Riwayat Pengajuan
        </h3>
        <div class="history-grid">
            <template x-for="app in applications" :key="app.id">
                <div class="history-card">
                    <div class="history-header">
                        <div class="history-date" x-text="formatDate(app.created_at)"></div>
                        <span class="history-status" :class="`status-${app.status}`" x-text="getStatusText(app.status)"></span>
                    </div>
                    <div class="history-body">
                        <div class="history-detail">
                            <i class="fas fa-users"></i>
                            <span><strong x-text="app.total_participants"></strong> peserta</span>
                        </div>
                        <div class="history-detail">
                            <i class="fas fa-clock"></i>
                            <span><strong x-text="app.duration_month"></strong> bulan</span>
                        </div>
                    </div>
                    <template x-if="app.admin_note">
                        <div class="history-note">
                            <i class="fas fa-comment"></i>
                            <span x-text="app.admin_note"></span>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>

    <!-- New Application Form -->
    <div class="form-card">
        <div class="form-header">
            <h3 class="form-title">
                <i class="fas fa-file-alt"></i>
                Pengajuan Baru
            </h3>
        </div>

        <form @submit.prevent="submitApplication">
            <div class="form-body">
                <div class="form-section">
                    <h4 class="form-section-title">Informasi Program</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                Jumlah Peserta
                                <span class="req">*</span>
                            </label>
                            <input type="number" class="form-input" x-model="formData.total_participants" min="1" required>
                            <div class="form-hint">Jumlah siswa/mahasiswa yang akan mengikuti magang</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Durasi Magang
                                <span class="req">*</span>
                            </label>
                            <select class="form-input" x-model="formData.duration_month" required>
                                <option value="">Pilih Durasi</option>
                                <option value="1">1 Bulan</option>
                                <option value="2">2 Bulan</option>
                                <option value="3">3 Bulan</option>
                                <option value="6">6 Bulan</option>
                                <option value="9">9 Bulan</option>
                                <option value="12">12 Bulan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Tanggal Mulai (Rencana)
                                <span class="req">*</span>
                            </label>
                            <input type="date" class="form-input" x-model="formData.start_date" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tanggal Selesai (Rencana)</label>
                            <input type="date" class="form-input" x-model="formData.end_date" readonly>
                            <div class="form-hint">Otomatis terisi berdasarkan durasi</div>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Catatan / Keterangan Tambahan</label>
                            <textarea class="form-textarea" x-model="formData.notes" rows="3" placeholder="Jelaskan program magang yang diajukan..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="form-section-title">Upload Dokumen</h4>
                    <div class="upload-grid">
                        <div class="upload-item">
                            <label class="upload-label">
                                <i class="fas fa-file-pdf"></i>
                                <span>Surat Pengajuan</span>
                                <span class="required-mark">*</span>
                            </label>
                            <input type="file" class="upload-input" @change="handleFileUpload($event, 'surat_pengajuan')" accept=".pdf" required>
                            <div class="upload-hint">Format PDF, max 5MB</div>
                        </div>

                        <div class="upload-item">
                            <label class="upload-label">
                                <i class="fas fa-file-pdf"></i>
                                <span>Proposal Program</span>
                                <span class="required-mark">*</span>
                            </label>
                            <input type="file" class="upload-input" @change="handleFileUpload($event, 'proposal')" accept=".pdf" required>
                            <div class="upload-hint">Format PDF, max 5MB</div>
                        </div>

                        <div class="upload-item">
                            <label class="upload-label">
                                <i class="fas fa-file-pdf"></i>
                                <span>Surat Rekomendasi</span>
                            </label>
                            <input type="file" class="upload-input" @change="handleFileUpload($event, 'rekomendasi')" accept=".pdf">
                            <div class="upload-hint">Opsional - Format PDF, max 5MB</div>
                        </div>

                        <div class="upload-item">
                            <label class="upload-label">
                                <i class="fas fa-file-excel"></i>
                                <span>Daftar Peserta</span>
                            </label>
                            <input type="file" class="upload-input" @change="handleFileUpload($event, 'daftar_peserta')" accept=".xlsx,.xls,.pdf">
                            <div class="upload-hint">Opsional - Format Excel/PDF, max 5MB</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <button type="button" class="btn btn-secondary" @click="resetForm">
                    <i class="fas fa-redo"></i>
                    Reset Form
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.page-header{margin-bottom:2rem}.page-header-content{display:flex;justify-content:space-between}.page-title{font-family:'Outfit',sans-serif;font-size:2rem;font-weight:800;color:var(--text-primary);margin-bottom:0.5rem}.page-subtitle{font-size:0.9375rem;color:var(--text-secondary)}.history-section{margin-bottom:2rem}.section-title{font-family:'Outfit',sans-serif;font-size:1.25rem;font-weight:700;color:var(--text-primary);margin-bottom:1.25rem;display:flex;align-items:center;gap:0.75rem}.section-title i{color:var(--accent-600)}.history-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.25rem}.history-card{background:var(--bg-primary);border-radius:12px;border:1px solid var(--border-primary);padding:1.25rem;box-shadow:var(--shadow-sm);transition:all 0.2s ease}.history-card:hover{box-shadow:var(--shadow-md);transform:translateY(-2px)}.history-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem}.history-date{font-size:0.875rem;font-weight:600;color:var(--text-secondary)}.history-status{display:inline-flex;padding:0.25rem 0.75rem;border-radius:9999px;font-size:0.75rem;font-weight:600}.status-pending{background:rgba(245,158,11,0.1);color:#f59e0b}.status-approved{background:rgba(16,185,129,0.1);color:var(--success-600)}.status-rejected{background:rgba(239,68,68,0.1);color:var(--danger-500)}.history-body{display:flex;gap:1.5rem;margin-bottom:0.75rem}.history-detail{display:flex;align-items:center;gap:0.5rem;font-size:0.875rem;color:var(--text-secondary)}.history-detail i{color:var(--accent-600)}.history-detail strong{color:var(--text-primary)}.history-note{padding:0.75rem;background:var(--bg-secondary);border-radius:8px;border-left:3px solid var(--accent-600);display:flex;gap:0.75rem;font-size:0.875rem;color:var(--text-secondary)}.history-note i{color:var(--accent-600);flex-shrink:0;margin-top:0.125rem}.form-card{background:var(--bg-primary);border-radius:16px;border:1px solid var(--border-primary);overflow:hidden;box-shadow:var(--shadow-sm)}.form-header{padding:1.5rem 2rem;border-bottom:1px solid var(--border-primary);background:linear-gradient(180deg,var(--gray-50) 0%,transparent 100%)}.form-title{font-family:'Outfit',sans-serif;font-size:1.25rem;font-weight:700;color:var(--text-primary);display:flex;align-items:center;gap:0.75rem}.form-title i{color:var(--accent-600)}.form-body{padding:2rem}.form-section{margin-bottom:2rem}.form-section:last-child{margin-bottom:0}.form-section-title{font-family:'Outfit',sans-serif;font-size:1rem;font-weight:700;color:var(--text-primary);margin-bottom:1.25rem;padding-bottom:0.75rem;border-bottom:1px solid var(--border-primary)}.form-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1.25rem}.form-group{display:flex;flex-direction:column}.form-group.full-width{grid-column:1/-1}.form-label{font-size:0.875rem;font-weight:600;color:var(--text-primary);margin-bottom:0.5rem}.form-label .req{color:var(--danger-500)}.form-input,.form-textarea{padding:0.875rem;border:1px solid var(--border-primary);border-radius:10px;font-size:0.9375rem;transition:all 0.2s ease;background:var(--bg-secondary)}.form-input:focus,.form-textarea:focus{outline:none;border-color:var(--accent-500);background:white;box-shadow:0 0 0 3px rgba(6,182,212,0.1)}.form-textarea{font-family:inherit;resize:vertical}.form-hint{font-size:0.8125rem;color:var(--text-secondary);margin-top:0.375rem}.upload-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1.25rem}.upload-item{background:var(--bg-secondary);border:2px dashed var(--border-primary);border-radius:12px;padding:1.25rem;text-align:center;transition:all 0.2s ease}.upload-item:hover{border-color:var(--accent-500);background:white}.upload-label{display:flex;flex-direction:column;align-items:center;gap:0.625rem;font-size:0.9375rem;font-weight:600;color:var(--text-primary);cursor:pointer}.upload-label i{font-size:2rem;color:var(--accent-600)}.required-mark{color:var(--danger-500);font-size:0.75rem}.upload-input{margin-top:0.75rem;font-size:0.875rem}.upload-hint{font-size:0.75rem;color:var(--text-secondary);margin-top:0.5rem}.form-footer{padding:1.5rem 2rem;border-top:1px solid var(--border-primary);display:flex;justify-content:flex-end;gap:0.75rem;background:var(--bg-secondary)}.btn{display:inline-flex;align-items:center;gap:0.625rem;padding:0.75rem 1.5rem;border-radius:10px;font-weight:600;font-size:0.9375rem;transition:all 0.2s ease;border:none;cursor:pointer}.btn-primary{background:var(--primary-800);color:white}.btn-primary:hover{background:var(--primary-700);transform:translateY(-2px);box-shadow:var(--shadow-md)}.btn-secondary{background:var(--gray-200);color:var(--text-primary)}.btn-secondary:hover{background:var(--gray-300)}@media(max-width:1024px){.form-grid,.upload-grid{grid-template-columns:1fr}.history-grid{grid-template-columns:1fr}}
</style>

<script>
function applicationForm(){return{applications:[{id:1,total_participants:20,duration_month:6,status:'approved',created_at:'2025-12-15',admin_note:'Disetujui untuk periode Januari-Juni 2026'},{id:2,total_participants:15,duration_month:3,status:'pending',created_at:'2026-02-01',admin_note:null}],formData:{total_participants:'',duration_month:'',start_date:'',end_date:'',notes:''},documents:{},init(){this.$watch('formData.duration_month',()=>this.calculateEndDate());this.$watch('formData.start_date',()=>this.calculateEndDate())},calculateEndDate(){if(this.formData.start_date&&this.formData.duration_month){const start=new Date(this.formData.start_date);const months=parseInt(this.formData.duration_month);start.setMonth(start.getMonth()+months);this.formData.end_date=start.toISOString().split('T')[0]}},handleFileUpload(event,type){const file=event.target.files[0];if(file){if(file.size>5*1024*1024){alert('Ukuran file maksimal 5MB!');event.target.value='';return}this.documents[type]=file;console.log(`Uploaded ${type}:`,file.name)}},submitApplication(){console.log('Submitting application:',this.formData,this.documents);if(!this.documents.surat_pengajuan||!this.documents.proposal){alert('Silakan upload dokumen yang wajib!');return}alert('Pengajuan berhasil dikirim!\n\nPengajuan Anda akan divalidasi oleh admin.');this.resetForm();window.location.reload()},resetForm(){this.formData={total_participants:'',duration_month:'',start_date:'',end_date:'',notes:''};this.documents={};document.querySelectorAll('.upload-input').forEach(input=>input.value='')},formatDate(dateString){return new Date(dateString).toLocaleDateString('id-ID',{year:'numeric',month:'long',day:'numeric'})},getStatusText(status){const map={'pending':'Menunggu Validasi','approved':'Disetujui','rejected':'Ditolak'};return map[status]||status}}}
</script>
@endsection
