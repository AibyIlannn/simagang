@extends('layouts.dashboard')

@section('title', 'Profil Institusi - Dashboard')

@section('content')
<div x-data="institutionProfile()">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div>
                <h1 class="page-title">Profil Institusi</h1>
                <p class="page-subtitle">Kelola informasi dan data institusi Anda</p>
            </div>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar-section">
                <div class="profile-avatar">
                    <i class="fas fa-building"></i>
                </div>
                <div class="profile-info">
                    <h2 x-text="institution.name"></h2>
                    <p class="profile-type" x-text="institution.institution_type"></p>
                    <div class="profile-status">
                        <span 
                            class="status-badge" 
                            :class="`status-${institution.status}`"
                            x-text="getStatusText(institution.status)"
                        ></span>
                        <span class="profile-date">Terdaftar sejak <span x-text="formatDate(institution.created_at)"></span></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-body">
            <!-- Navigation Tabs -->
            <div class="profile-tabs">
                <button 
                    class="profile-tab" 
                    :class="{ 'active': activeTab === 'info' }"
                    @click="activeTab = 'info'"
                >
                    <i class="fas fa-info-circle"></i>
                    Informasi Dasar
                </button>
                <button 
                    class="profile-tab" 
                    :class="{ 'active': activeTab === 'contact' }"
                    @click="activeTab = 'contact'"
                >
                    <i class="fas fa-address-book"></i>
                    Kontak
                </button>
                <button 
                    class="profile-tab" 
                    :class="{ 'active': activeTab === 'stats' }"
                    @click="activeTab = 'stats'"
                >
                    <i class="fas fa-chart-bar"></i>
                    Statistik
                </button>
                <button 
                    class="profile-tab" 
                    :class="{ 'active': activeTab === 'password' }"
                    @click="activeTab = 'password'"
                >
                    <i class="fas fa-lock"></i>
                    Keamanan
                </button>
            </div>

            <!-- Tab Content: Info -->
            <div x-show="activeTab === 'info'" x-transition class="tab-content">
                <form @submit.prevent="saveBasicInfo">
                    <div class="form-section">
                        <h3 class="form-section-title">Informasi Institusi</h3>
                        
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label class="form-label">
                                    Nama Institusi
                                    <span class="form-label-required">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-input" 
                                    x-model="formData.name"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Jenis Institusi
                                    <span class="form-label-required">*</span>
                                </label>
                                <select class="form-input" x-model="formData.institution_type" required>
                                    <option value="SMK">SMK</option>
                                    <option value="SMA">SMA</option>
                                    <option value="MA">MA</option>
                                    <option value="UNIVERSITAS">Universitas</option>
                                    <option value="POLITEKNIK">Politeknik</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    NPSN / Nomor Identitas
                                </label>
                                <input 
                                    type="text" 
                                    class="form-input" 
                                    x-model="formData.npsn"
                                    placeholder="Contoh: 20100001"
                                >
                            </div>

                            <div class="form-group full-width">
                                <label class="form-label">
                                    Alamat Lengkap
                                    <span class="form-label-required">*</span>
                                </label>
                                <textarea 
                                    class="form-textarea" 
                                    x-model="formData.address"
                                    rows="3"
                                    required
                                ></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Provinsi</label>
                                <input type="text" class="form-input" x-model="formData.province">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Kota/Kabupaten</label>
                                <input type="text" class="form-input" x-model="formData.city">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Kode Pos</label>
                                <input type="text" class="form-input" x-model="formData.postal_code" placeholder="12345">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Website</label>
                                <input type="url" class="form-input" x-model="formData.website" placeholder="https://example.com">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tab Content: Contact -->
            <div x-show="activeTab === 'contact'" x-transition class="tab-content">
                <form @submit.prevent="saveContactInfo">
                    <div class="form-section">
                        <h3 class="form-section-title">Informasi Kontak</h3>
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    Email Institusi
                                    <span class="form-label-required">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    class="form-input" 
                                    x-model="formData.email"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Nomor Telepon
                                </label>
                                <input 
                                    type="tel" 
                                    class="form-input" 
                                    x-model="formData.phone"
                                    placeholder="(021) 1234567"
                                >
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    WhatsApp
                                    <span class="form-label-required">*</span>
                                </label>
                                <input 
                                    type="tel" 
                                    class="form-input" 
                                    x-model="formData.whatsapp"
                                    placeholder="08xxxxxxxxxx"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label class="form-label">Fax</label>
                                <input type="tel" class="form-input" x-model="formData.fax" placeholder="(021) 7654321">
                            </div>

                            <div class="form-group full-width">
                                <label class="form-label">Nama Penanggung Jawab</label>
                                <input type="text" class="form-input" x-model="formData.pic_name" placeholder="Nama lengkap">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Jabatan Penanggung Jawab</label>
                                <input type="text" class="form-input" x-model="formData.pic_position" placeholder="Kepala Sekolah, Rektor, dll">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Email Penanggung Jawab</label>
                                <input type="email" class="form-input" x-model="formData.pic_email">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tab Content: Stats -->
            <div x-show="activeTab === 'stats'" x-transition class="tab-content">
                <div class="stats-overview">
                    <h3 class="form-section-title">Statistik Program Magang</h3>
                    
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: linear-gradient(135deg, rgba(6, 182, 212, 0.15), rgba(6, 182, 212, 0.05));">
                                <i class="fas fa-users" style="color: var(--accent-600);"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value" x-text="stats.total_participants"></div>
                                <div class="stat-label">Total Peserta</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05));">
                                <i class="fas fa-user-check" style="color: var(--success-600);"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value" x-text="stats.active_participants"></div>
                                <div class="stat-label">Peserta Aktif</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.15), rgba(139, 92, 246, 0.05));">
                                <i class="fas fa-check-double" style="color: #8b5cf6;"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value" x-text="stats.finished_participants"></div>
                                <div class="stat-label">Selesai</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(245, 158, 11, 0.05));">
                                <i class="fas fa-file-alt" style="color: #f59e0b;"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value" x-text="stats.total_reports"></div>
                                <div class="stat-label">Laporan Submitted</div>
                            </div>
                        </div>
                    </div>

                    <div class="history-section">
                        <h4 class="history-title">Riwayat Pengajuan</h4>
                        <div class="history-list">
                            <template x-for="application in stats.applications" :key="application.id">
                                <div class="history-item">
                                    <div class="history-date" x-text="formatDate(application.date)"></div>
                                    <div class="history-content">
                                        <div class="history-text">
                                            Pengajuan <strong x-text="application.participants"></strong> peserta 
                                            untuk durasi <strong x-text="`${application.duration} bulan`"></strong>
                                        </div>
                                        <span 
                                            class="history-status"
                                            :class="`status-${application.status}`"
                                            x-text="getStatusText(application.status)"
                                        ></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content: Password -->
            <div x-show="activeTab === 'password'" x-transition class="tab-content">
                <form @submit.prevent="changePassword">
                    <div class="form-section">
                        <h3 class="form-section-title">Ubah Password</h3>
                        
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label class="form-label">
                                    Password Lama
                                    <span class="form-label-required">*</span>
                                </label>
                                <input 
                                    type="password" 
                                    class="form-input" 
                                    x-model="passwordData.current_password"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Password Baru
                                    <span class="form-label-required">*</span>
                                </label>
                                <input 
                                    type="password" 
                                    class="form-input" 
                                    x-model="passwordData.new_password"
                                    required
                                    minlength="8"
                                >
                                <div class="form-hint">Minimal 8 karakter</div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    Konfirmasi Password Baru
                                    <span class="form-label-required">*</span>
                                </label>
                                <input 
                                    type="password" 
                                    class="form-input" 
                                    x-model="passwordData.confirm_password"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-lock"></i>
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.page-header{margin-bottom:2rem}.page-header-content{display:flex;justify-content:space-between;align-items:flex-start}.page-title{font-family:'Outfit',sans-serif;font-size:2rem;font-weight:800;color:var(--text-primary);margin-bottom:0.5rem;letter-spacing:-0.02em}.page-subtitle{font-size:0.9375rem;color:var(--text-secondary)}.profile-card{background:var(--bg-primary);border-radius:16px;border:1px solid var(--border-primary);overflow:hidden;box-shadow:var(--shadow-sm)}.profile-header{padding:2rem;background:linear-gradient(135deg,var(--primary-800),var(--primary-700));color:white}.profile-avatar-section{display:flex;gap:1.5rem;align-items:center}.profile-avatar{width:96px;height:96px;background:rgba(255,255,255,0.2);border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:3rem;backdrop-filter:blur(10px);border:3px solid rgba(255,255,255,0.3)}.profile-info h2{font-family:'Outfit',sans-serif;font-size:1.75rem;font-weight:800;margin-bottom:0.5rem}.profile-type{font-size:1rem;opacity:0.9;margin-bottom:0.75rem}.profile-status{display:flex;align-items:center;gap:1rem}.profile-date{font-size:0.875rem;opacity:0.8}.status-badge{display:inline-flex;padding:0.375rem 0.875rem;border-radius:9999px;font-size:0.8125rem;font-weight:600}.status-badge.status-active{background:rgba(16,185,129,0.2);color:#fff;border:1px solid rgba(255,255,255,0.3)}.status-badge.status-pending{background:rgba(245,158,11,0.2);color:#fff;border:1px solid rgba(255,255,255,0.3)}.profile-body{padding:0}.profile-tabs{display:flex;border-bottom:2px solid var(--border-primary);padding:0 2rem;gap:0.5rem}.profile-tab{padding:1rem 1.5rem;background:transparent;border:none;color:var(--text-secondary);font-weight:600;font-size:0.9375rem;cursor:pointer;position:relative;transition:all 0.2s ease;display:flex;align-items:center;gap:0.625rem}.profile-tab:hover{color:var(--text-primary);background:var(--bg-secondary)}.profile-tab.active{color:var(--accent-600)}.profile-tab.active::after{content:'';position:absolute;bottom:-2px;left:0;right:0;height:2px;background:var(--accent-600)}.tab-content{padding:2rem}.form-section{margin-bottom:2rem}.form-section-title{font-family:'Outfit',sans-serif;font-size:1.25rem;font-weight:700;color:var(--text-primary);margin-bottom:1.5rem;padding-bottom:0.75rem;border-bottom:2px solid var(--border-primary)}.form-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1.25rem}.form-group{display:flex;flex-direction:column}.form-group.full-width{grid-column:1/-1}.form-label{font-size:0.875rem;font-weight:600;color:var(--text-primary);margin-bottom:0.5rem}.form-label-required{color:var(--danger-500)}.form-input,.form-textarea{padding:0.875rem;border:1px solid var(--border-primary);border-radius:10px;font-size:0.9375rem;transition:all 0.2s ease;background:var(--bg-secondary)}.form-input:focus,.form-textarea:focus{outline:none;border-color:var(--accent-500);background:white;box-shadow:0 0 0 3px rgba(6,182,212,0.1)}.form-textarea{font-family:inherit;resize:vertical}.form-hint{font-size:0.8125rem;color:var(--text-secondary);margin-top:0.375rem}.form-actions{display:flex;justify-content:flex-end;padding-top:1.5rem;border-top:1px solid var(--border-primary)}.btn{display:inline-flex;align-items:center;gap:0.625rem;padding:0.75rem 1.5rem;border-radius:10px;font-weight:600;font-size:0.9375rem;transition:all 0.2s ease;border:none;cursor:pointer;text-decoration:none}.btn-primary{background:var(--primary-800);color:white}.btn-primary:hover{background:var(--primary-700);transform:translateY(-2px);box-shadow:var(--shadow-md)}.stats-overview{}.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem;margin-bottom:2rem}.stat-card{background:var(--bg-secondary);border-radius:12px;border:1px solid var(--border-primary);padding:1.5rem;display:flex;gap:1.25rem;align-items:center}.stat-icon{width:56px;height:56px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;flex-shrink:0}.stat-content{flex:1}.stat-value{font-family:'Outfit',sans-serif;font-size:2rem;font-weight:800;color:var(--text-primary);line-height:1;margin-bottom:0.375rem}.stat-label{font-size:0.875rem;font-weight:500;color:var(--text-secondary)}.history-section{background:var(--bg-secondary);border-radius:12px;padding:1.5rem}.history-title{font-family:'Outfit',sans-serif;font-size:1.125rem;font-weight:700;color:var(--text-primary);margin-bottom:1.25rem}.history-list{display:flex;flex-direction:column;gap:1rem}.history-item{display:flex;gap:1.5rem;padding:1rem;background:white;border-radius:10px;border:1px solid var(--border-primary)}.history-date{font-size:0.8125rem;font-weight:600;color:var(--text-secondary);min-width:120px;padding-top:0.25rem}.history-content{flex:1;display:flex;justify-content:space-between;align-items:center;gap:1rem}.history-text{font-size:0.9375rem;color:var(--text-primary)}.history-text strong{font-weight:700;color:var(--primary-800)}.history-status{display:inline-flex;padding:0.375rem 0.875rem;border-radius:9999px;font-size:0.8125rem;font-weight:600}.history-status.status-approved{background:rgba(16,185,129,0.1);color:var(--success-600)}.history-status.status-pending{background:rgba(245,158,11,0.1);color:#f59e0b}.history-status.status-rejected{background:rgba(239,68,68,0.1);color:var(--danger-500)}@media(max-width:1024px){.stats-grid{grid-template-columns:repeat(2,1fr)}.form-grid{grid-template-columns:1fr}}@media(max-width:768px){.stats-grid{grid-template-columns:1fr}.profile-tabs{overflow-x:auto}.history-item{flex-direction:column;gap:0.75rem}.history-date{min-width:auto}}
</style>

<script>
function institutionProfile(){return{institution:{id:1,name:'SMK Negeri 1 Jakarta',institution_type:'SMK',email:'admin@smkn1jakarta.sch.id',whatsapp:'081234567890',status:'active',created_at:'2025-01-15'},formData:{},passwordData:{current_password:'',new_password:'',confirm_password:''},activeTab:'info',stats:{total_participants:45,active_participants:38,finished_participants:5,total_reports:156,applications:[{id:1,date:'2025-12-15',participants:20,duration:6,status:'approved'},{id:2,date:'2026-01-10',participants:15,duration:3,status:'approved'},{id:3,date:'2026-02-01',participants:10,duration:3,status:'pending'}]},init(){this.resetFormData()},resetFormData(){this.formData={name:this.institution.name,institution_type:this.institution.institution_type,npsn:'',address:'Jl. Pendidikan No. 123, Jakarta Pusat, DKI Jakarta 10110',province:'DKI Jakarta',city:'Jakarta Pusat',postal_code:'10110',website:'https://smkn1jakarta.sch.id',email:this.institution.email,phone:'(021) 1234567',whatsapp:this.institution.whatsapp,fax:'',pic_name:'Dr. Ahmad Wijaya, S.Pd., M.Pd.',pic_position:'Kepala Sekolah',pic_email:'kepala@smkn1jakarta.sch.id'}},saveBasicInfo(){console.log('Saving basic info:',this.formData);Object.assign(this.institution,{name:this.formData.name,institution_type:this.formData.institution_type});alert('Informasi dasar berhasil disimpan!')},saveContactInfo(){console.log('Saving contact info:',this.formData);Object.assign(this.institution,{email:this.formData.email,whatsapp:this.formData.whatsapp});alert('Informasi kontak berhasil disimpan!')},changePassword(){if(this.passwordData.new_password!==this.passwordData.confirm_password){alert('Password baru dan konfirmasi password tidak sama!');return}if(this.passwordData.new_password.length<8){alert('Password baru minimal 8 karakter!');return}console.log('Changing password');alert('Password berhasil diubah!');this.passwordData={current_password:'',new_password:'',confirm_password:''}},formatDate(dateString){return new Date(dateString).toLocaleDateString('id-ID',{year:'numeric',month:'long',day:'numeric'})},getStatusText(status){const map={'active':'Aktif','pending':'Pending','approved':'Disetujui','rejected':'Ditolak'};return map[status]||status}}}
</script>
@endsection
