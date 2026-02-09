@extends('layouts.dashboard')

@section('title', 'Validasi Institusi - Admin Dashboard')

@section('content')
<div x-data="validationList()">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div>
                <h1 class="page-title">Validasi Institusi</h1>
                <p class="page-subtitle">Review dan validasi institusi yang mendaftar untuk program magang</p>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="stats-grid-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(245, 158, 11, 0.05));">
                <i class="fas fa-clock" style="color: #f59e0b;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" x-text="stats.pending"></div>
                <div class="stat-label">Menunggu Validasi</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05));">
                <i class="fas fa-check-circle" style="color: var(--success-600);"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" x-text="stats.approved_today"></div>
                <div class="stat-label">Disetujui Hari Ini</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(239, 68, 68, 0.05));">
                <i class="fas fa-times-circle" style="color: var(--danger-500);"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value" x-text="stats.rejected_today"></div>
                <div class="stat-label">Ditolak Hari Ini</div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-group">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Cari nama institusi..." x-model="filters.search" @input.debounce.300ms="applyFilters">
            </div>
            
            <select x-model="filters.type" @change="applyFilters" class="filter-select">
                <option value="">Semua Jenis</option>
                <option value="SMK">SMK</option>
                <option value="SMA">SMA</option>
                <option value="MA">MA</option>
                <option value="UNIVERSITAS">Universitas</option>
                <option value="POLITEKNIK">Politeknik</option>
            </select>

            <select x-model="filters.sortBy" @change="applyFilters" class="filter-select">
                <option value="newest">Terbaru</option>
                <option value="oldest">Terlama</option>
                <option value="name">Nama A-Z</option>
            </select>

            <button @click="resetFilters" class="btn btn-ghost">
                <i class="fas fa-redo"></i>
                Reset
            </button>
        </div>
    </div>

    <!-- Validation Grid -->
    <div class="validation-grid">
        <template x-for="institution in paginatedData" :key="institution.id">
            <div class="validation-card">
                <div class="validation-header">
                    <div class="institution-avatar" :style="`background: linear-gradient(135deg, ${institution.color}, ${institution.colorDark})`">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="institution-info">
                        <h3 class="institution-name" x-text="institution.name"></h3>
                        <span class="institution-type" x-text="institution.institution_type"></span>
                    </div>
                </div>

                <div class="validation-body">
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <span x-text="institution.email"></span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <span x-text="institution.whatsapp"></span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-users"></i>
                        <span x-text="`${institution.proposed_participants} peserta diajukan`"></span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-calendar"></i>
                        <span x-text="`Didaftar ${formatDate(institution.created_at)}`"></span>
                    </div>

                    <!-- Documents -->
                    <div class="documents-section">
                        <div class="documents-title">
                            <i class="fas fa-file"></i>
                            Dokumen Pengajuan
                        </div>
                        <div class="documents-list">
                            <template x-for="doc in institution.documents" :key="doc.id">
                                <div class="document-badge">
                                    <i class="fas fa-file-pdf"></i>
                                    <span x-text="doc.name"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Proposed Duration -->
                    <div class="duration-badge">
                        <i class="fas fa-clock"></i>
                        <span x-text="`Durasi ${institution.duration_months} bulan`"></span>
                    </div>
                </div>

                <div class="validation-footer">
                    <button @click="viewDetail(institution)" class="btn btn-detail">
                        <i class="fas fa-eye"></i>
                        Lihat Detail
                    </button>
                    <div class="validation-actions">
                        <button @click="showApproveModal(institution)" class="btn btn-approve">
                            <i class="fas fa-check"></i>
                            Setujui
                        </button>
                        <button @click="showRejectModal(institution)" class="btn btn-reject">
                            <i class="fas fa-times"></i>
                            Tolak
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Empty State -->
    <div x-show="filteredData.length === 0" class="empty-state-large">
        <div class="empty-icon">
            <i class="fas fa-check-double"></i>
        </div>
        <div class="empty-title">Semua institusi telah divalidasi</div>
        <div class="empty-text">Tidak ada institusi yang menunggu validasi saat ini</div>
    </div>

    <!-- Pagination -->
    <div class="pagination-container" x-show="filteredData.length > 0">
        <div class="pagination-info">
            Menampilkan <strong x-text="paginationStart"></strong> - <strong x-text="paginationEnd"></strong> dari <strong x-text="filteredData.length"></strong> institusi
        </div>
        <div class="pagination">
            <button @click="currentPage--" :disabled="currentPage === 1" class="pagination-btn"><i class="fas fa-chevron-left"></i></button>
            <template x-for="page in totalPages" :key="page">
                <button @click="currentPage = page" class="pagination-btn" :class="{ 'active': currentPage === page }" x-text="page"></button>
            </template>
            <button @click="currentPage++" :disabled="currentPage === totalPages" class="pagination-btn"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>

    <!-- APPROVE MODAL -->
    <div x-show="approveModal.show" class="modal-overlay" x-transition @click="approveModal.show = false" x-cloak>
        <div class="modal-container modal-sm" @click.stop>
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-check-circle"></i>
                    Setujui Institusi
                </h3>
                <button @click="approveModal.show = false" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form @submit.prevent="approveInstitution">
                <div class="modal-body">
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <strong>Konfirmasi Persetujuan</strong>
                            <p>Anda akan menyetujui institusi <strong x-text="approveModal.institution?.name"></strong> untuk mengikuti program magang.</p>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea x-model="approveModal.note" class="form-textarea" rows="3" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="approveModal.show = false">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i>
                        Setujui Institusi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- REJECT MODAL -->
    <div x-show="rejectModal.show" class="modal-overlay" x-transition @click="rejectModal.show = false" x-cloak>
        <div class="modal-container modal-sm" @click.stop>
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-times-circle"></i>
                    Tolak Institusi
                </h3>
                <button @click="rejectModal.show = false" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form @submit.prevent="rejectInstitution">
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Perhatian!</strong>
                            <p>Anda akan menolak institusi <strong x-text="rejectModal.institution?.name"></strong>. Berikan alasan penolakan yang jelas.</p>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Alasan Penolakan <span class="form-label-required">*</span></label>
                        <textarea x-model="rejectModal.reason" class="form-textarea" rows="4" placeholder="Jelaskan alasan penolakan..." required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="rejectModal.show = false">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i>
                        Tolak Institusi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.page-header{margin-bottom:2rem}.page-header-content{display:flex;justify-content:space-between;align-items:flex-start}.page-title{font-family:'Outfit',sans-serif;font-size:2rem;font-weight:800;color:var(--text-primary);margin-bottom:0.5rem;letter-spacing:-0.02em}.page-subtitle{font-size:0.9375rem;color:var(--text-secondary)}.stats-grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;margin-bottom:2rem}.stat-card{background:var(--bg-primary);border-radius:16px;border:1px solid var(--border-primary);padding:1.5rem;display:flex;gap:1.25rem;align-items:center;box-shadow:var(--shadow-sm);transition:all 0.2s ease}.stat-card:hover{border-color:var(--accent-500);box-shadow:var(--shadow-md);transform:translateY(-2px)}.stat-icon{width:56px;height:56px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;flex-shrink:0}.stat-content{flex:1}.stat-value{font-family:'Outfit',sans-serif;font-size:2rem;font-weight:800;color:var(--text-primary);line-height:1;margin-bottom:0.375rem}.stat-label{font-size:0.875rem;font-weight:500;color:var(--text-secondary)}.filter-section{background:var(--bg-primary);border-radius:16px;border:1px solid var(--border-primary);padding:1.25rem 1.5rem;margin-bottom:1.5rem;box-shadow:var(--shadow-sm)}.filter-group{display:flex;gap:0.75rem;align-items:center}.search-box{flex:1;position:relative}.search-box i{position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:var(--text-tertiary);font-size:0.875rem}.search-box input{width:100%;padding:0.75rem 1rem 0.75rem 2.75rem;border:1px solid var(--border-primary);border-radius:10px;font-size:0.9375rem;transition:all 0.2s ease;background:var(--bg-secondary)}.search-box input:focus{outline:none;border-color:var(--accent-500);background:white;box-shadow:0 0 0 3px rgba(6,182,212,0.1)}.filter-select{padding:0.75rem 1rem;border:1px solid var(--border-primary);border-radius:10px;font-size:0.9375rem;font-weight:500;background:var(--bg-secondary);color:var(--text-primary);cursor:pointer;transition:all 0.2s ease;min-width:150px}.filter-select:focus{outline:none;border-color:var(--accent-500);background:white;box-shadow:0 0 0 3px rgba(6,182,212,0.1)}.validation-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(380px,1fr));gap:1.5rem;margin-bottom:2rem}.validation-card{background:var(--bg-primary);border-radius:16px;border:1px solid var(--border-primary);overflow:hidden;box-shadow:var(--shadow-sm);transition:all 0.3s ease;display:flex;flex-direction:column}.validation-card:hover{border-color:var(--accent-500);box-shadow:var(--shadow-lg);transform:translateY(-4px)}.validation-header{padding:1.5rem;border-bottom:1px solid var(--border-primary);display:flex;gap:1rem;align-items:center;background:linear-gradient(180deg,var(--gray-50) 0%,transparent 100%)}.institution-avatar{width:56px;height:56px;border-radius:14px;display:flex;align-items:center;justify-content:center;color:white;font-size:1.5rem;flex-shrink:0;box-shadow:0 4px 12px rgba(0,0,0,0.1)}.institution-info{flex:1}.institution-name{font-family:'Outfit',sans-serif;font-size:1.125rem;font-weight:700;color:var(--text-primary);margin-bottom:0.25rem}.institution-type{display:inline-block;padding:0.25rem 0.75rem;background:var(--gray-100);color:var(--gray-700);border-radius:6px;font-size:0.75rem;font-weight:600}.validation-body{padding:1.5rem;flex:1}.info-item{display:flex;align-items:center;gap:0.75rem;padding:0.75rem 0;border-bottom:1px solid var(--border-primary);font-size:0.875rem;color:var(--text-secondary)}.info-item:last-of-type{border-bottom:none}.info-item i{width:20px;color:var(--accent-600);text-align:center}.documents-section{margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid var(--border-primary)}.documents-title{display:flex;align-items:center;gap:0.5rem;font-size:0.875rem;font-weight:600;color:var(--text-primary);margin-bottom:0.75rem}.documents-title i{color:var(--accent-600)}.documents-list{display:flex;flex-direction:column;gap:0.5rem}.document-badge{display:flex;align-items:center;gap:0.5rem;padding:0.5rem 0.75rem;background:var(--bg-secondary);border-radius:8px;font-size:0.8125rem;color:var(--text-secondary)}.document-badge i{color:var(--danger-500);font-size:0.875rem}.duration-badge{display:inline-flex;align-items:center;gap:0.5rem;padding:0.625rem 1rem;background:linear-gradient(135deg,rgba(139,92,246,0.1),rgba(139,92,246,0.05));border:1px solid rgba(139,92,246,0.3);border-radius:9999px;color:#8b5cf6;font-size:0.8125rem;font-weight:600;margin-top:1rem}.duration-badge i{font-size:0.75rem}.validation-footer{padding:1.25rem 1.5rem;border-top:1px solid var(--border-primary);display:flex;gap:0.75rem}.validation-actions{display:flex;gap:0.5rem;margin-left:auto}.btn{display:inline-flex;align-items:center;gap:0.5rem;padding:0.625rem 1.25rem;border-radius:8px;font-weight:600;font-size:0.875rem;transition:all 0.2s ease;border:none;cursor:pointer;text-decoration:none}.btn-detail{background:var(--gray-100);color:var(--text-primary)}.btn-detail:hover{background:var(--gray-200)}.btn-approve{background:var(--success-500);color:white}.btn-approve:hover{background:var(--success-600);transform:translateY(-1px);box-shadow:0 4px 12px rgba(16,185,129,0.3)}.btn-reject{background:var(--danger-500);color:white}.btn-reject:hover{background:#dc2626;transform:translateY(-1px);box-shadow:0 4px 12px rgba(239,68,68,0.3)}.btn-secondary{background:var(--gray-200);color:var(--text-primary)}.btn-secondary:hover{background:var(--gray-300)}.btn-success{background:var(--success-500);color:white}.btn-success:hover{background:var(--success-600);transform:translateY(-2px);box-shadow:var(--shadow-md)}.btn-danger{background:var(--danger-500);color:white}.btn-danger:hover{background:#dc2626;transform:translateY(-2px);box-shadow:var(--shadow-md)}.btn-ghost{background:transparent;color:var(--text-secondary);border:1px solid var(--border-primary)}.btn-ghost:hover{background:var(--bg-secondary);border-color:var(--accent-500);color:var(--accent-600)}.empty-state-large{padding:6rem 2rem;text-align:center}.empty-icon{width:120px;height:120px;margin:0 auto 2rem;background:linear-gradient(135deg,var(--accent-500),var(--accent-700));border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:3rem;color:white;box-shadow:0 20px 40px rgba(6,182,212,0.3)}.empty-title{font-family:'Outfit',sans-serif;font-size:1.5rem;font-weight:800;color:var(--text-primary);margin-bottom:0.75rem}.empty-text{font-size:1rem;color:var(--text-secondary)}.pagination-container{display:flex;justify-content:space-between;align-items:center;padding:1.5rem;background:var(--bg-primary);border-radius:16px;border:1px solid var(--border-primary);box-shadow:var(--shadow-sm)}.pagination-info{font-size:0.875rem;color:var(--text-secondary)}.pagination-info strong{color:var(--text-primary);font-weight:600}.pagination{display:flex;gap:0.5rem}.pagination-btn{min-width:36px;height:36px;padding:0 0.75rem;border-radius:8px;border:1px solid var(--border-primary);background:white;color:var(--text-primary);font-weight:600;font-size:0.875rem;cursor:pointer;transition:all 0.2s ease}.pagination-btn:hover:not(:disabled){border-color:var(--accent-500);background:var(--accent-500);color:white}.pagination-btn.active{background:var(--accent-500);border-color:var(--accent-500);color:white}.pagination-btn:disabled{opacity:0.4;cursor:not-allowed}.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);z-index:9998;display:flex;align-items:center;justify-content:center;padding:2rem}.modal-container{background:white;border-radius:20px;max-width:500px;width:100%;max-height:90vh;overflow-y:auto;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25)}.modal-header{padding:1.75rem 2rem;border-bottom:1px solid var(--border-primary);display:flex;justify-content:space-between;align-items:center}.modal-title{font-family:'Outfit',sans-serif;font-size:1.25rem;font-weight:700;color:var(--text-primary);display:flex;align-items:center;gap:0.75rem}.modal-close{width:36px;height:36px;border-radius:8px;border:none;background:var(--gray-100);color:var(--text-secondary);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s ease}.modal-close:hover{background:var(--gray-200);color:var(--text-primary)}.modal-body{padding:2rem}.modal-footer{padding:1.5rem 2rem;border-top:1px solid var(--border-primary);display:flex;justify-content:flex-end;gap:0.75rem}.form-group{display:flex;flex-direction:column}.form-label{font-size:0.875rem;font-weight:600;color:var(--text-primary);margin-bottom:0.5rem}.form-label-required{color:var(--danger-500)}.form-textarea{width:100%;padding:0.875rem;border:1px solid var(--border-primary);border-radius:10px;font-size:0.9375rem;font-family:inherit;resize:vertical;transition:all 0.2s ease}.form-textarea:focus{outline:none;border-color:var(--accent-500);box-shadow:0 0 0 3px rgba(6,182,212,0.1)}.alert{padding:1rem 1.25rem;border-radius:12px;display:flex;gap:1rem;margin-bottom:1.5rem}.alert-success{background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3)}.alert-success i{color:var(--success-600)}.alert-warning{background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.3)}.alert-warning i{color:#f59e0b}.alert i{font-size:1.25rem;flex-shrink:0}.alert strong{display:block;font-weight:700;margin-bottom:0.25rem;color:var(--text-primary)}.alert p{font-size:0.875rem;color:var(--text-secondary);margin:0}[x-cloak]{display:none!important}@media(max-width:1200px){.stats-grid-3{grid-template-columns:repeat(2,1fr)}.validation-grid{grid-template-columns:1fr}}@media(max-width:768px){.stats-grid-3{grid-template-columns:1fr}.filter-group{flex-direction:column}.filter-select{width:100%}.validation-footer{flex-direction:column}.validation-actions{margin-left:0;width:100%}.validation-actions .btn{flex:1}}
</style>

<script>
function validationList(){return{institutions:[],filters:{search:'',type:'',sortBy:'newest'},currentPage:1,perPage:6,stats:{pending:12,approved_today:3,rejected_today:1},approveModal:{show:!1,institution:null,note:''},rejectModal:{show:!1,institution:null,reason:''},init(){this.loadData()},loadData(){const types=['SMK','SMA','MA','UNIVERSITAS','POLITEKNIK'];const colors=[{light:'#06b6d4',dark:'#0e7490'},{light:'#8b5cf6',dark:'#6d28d9'},{light:'#ec4899',dark:'#be185d'},{light:'#f59e0b',dark:'#d97706'},{light:'#10b981',dark:'#059669'}];for(let i=1;i<=12;i++){const color=colors[Math.floor(Math.random()*colors.length)];const type=types[Math.floor(Math.random()*types.length)];this.institutions.push({id:i,name:`${type} Negeri ${i}`,institution_type:type,email:`admin.institusi${i}@example.com`,whatsapp:`08123456${String(i).padStart(4,'0')}`,proposed_participants:Math.floor(Math.random()*30)+10,duration_months:Math.floor(Math.random()*6)+1,created_at:new Date(2026,Math.floor(Math.random()*2),Math.floor(Math.random()*28)+1),documents:[{id:1,name:'Surat Pengajuan'},{id:2,name:'Proposal Program'}],color:color.light,colorDark:color.dark})}},get filteredData(){let data=this.institutions.filter(item=>{const matchSearch=!this.filters.search||item.name.toLowerCase().includes(this.filters.search.toLowerCase());const matchType=!this.filters.type||item.institution_type===this.filters.type;return matchSearch&&matchType});if(this.filters.sortBy==='newest')data.sort((a,b)=>new Date(b.created_at)-new Date(a.created_at));else if(this.filters.sortBy==='oldest')data.sort((a,b)=>new Date(a.created_at)-new Date(b.created_at));else if(this.filters.sortBy==='name')data.sort((a,b)=>a.name.localeCompare(b.name));return data},get paginatedData(){const start=(this.currentPage-1)*this.perPage;return this.filteredData.slice(start,start+this.perPage)},get totalPages(){return Math.ceil(this.filteredData.length/this.perPage)},get paginationStart(){return(this.currentPage-1)*this.perPage+1},get paginationEnd(){const end=this.currentPage*this.perPage;return end>this.filteredData.length?this.filteredData.length:end},applyFilters(){this.currentPage=1},resetFilters(){this.filters={search:'',type:'',sortBy:'newest'};this.currentPage=1},viewDetail(institution){window.location.href=`/admin/dashboard/institusi/${institution.id}`},showApproveModal(institution){this.approveModal.institution=institution;this.approveModal.note='';this.approveModal.show=!0},showRejectModal(institution){this.rejectModal.institution=institution;this.rejectModal.reason='';this.rejectModal.show=!0},approveInstitution(){console.log('Approving:',this.approveModal.institution,this.approveModal.note);this.institutions=this.institutions.filter(i=>i.id!==this.approveModal.institution.id);this.stats.pending--;this.stats.approved_today++;alert(`Institusi "${this.approveModal.institution.name}" berhasil disetujui!`);this.approveModal.show=!1},rejectInstitution(){console.log('Rejecting:',this.rejectModal.institution,this.rejectModal.reason);this.institutions=this.institutions.filter(i=>i.id!==this.rejectModal.institution.id);this.stats.pending--;this.stats.rejected_today++;alert(`Institusi "${this.rejectModal.institution.name}" telah ditolak.`);this.rejectModal.show=!1},formatDate(date){return new Date(date).toLocaleDateString('id-ID',{year:'numeric',month:'long',day:'numeric'})}}}
</script>
@endsection
