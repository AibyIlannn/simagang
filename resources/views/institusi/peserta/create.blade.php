@extends('layouts.dashboard')
@section('title', 'Tambah Peserta - Dashboard Institusi')
@section('content')
<div x-data="createParticipant()">
    <div class="page-header">
        <div class="page-header-content">
            <div>
                <h1 class="page-title">Tambah Peserta Baru</h1>
                <p class="page-subtitle">Daftarkan peserta magang dari institusi Anda</p>
            </div>
        </div>
    </div>

    <form @submit.prevent="submitForm" class="form-card">
        <div class="form-section">
            <h3 class="form-section-title">
                <i class="fas fa-user"></i>
                Data Pribadi
            </h3>
            <div class="form-grid">
                <div class="form-group full-width">
                    <label class="form-label">Nama Lengkap <span class="req">*</span></label>
                    <input type="text" class="form-input" x-model="formData.name" required>
                </div>
                <div class="form-group">
                    <label class="form-label">NIS / NIM <span class="req">*</span></label>
                    <input type="text" class="form-input" x-model="formData.identity_number" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Kelamin <span class="req">*</span></label>
                    <select class="form-input" x-model="formData.gender" required>
                        <option value="">Pilih</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Email <span class="req">*</span></label>
                    <input type="email" class="form-input" x-model="formData.email" required>
                </div>
                <div class="form-group">
                    <label class="form-label">No. Telepon <span class="req">*</span></label>
                    <input type="tel" class="form-input" x-model="formData.phone" required>
                </div>
                <div class="form-group full-width">
                    <label class="form-label">Alamat <span class="req">*</span></label>
                    <textarea class="form-textarea" x-model="formData.address" rows="3" required></textarea>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">
                <i class="fas fa-graduation-cap"></i>
                Data Pendidikan
            </h3>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Jurusan <span class="req">*</span></label>
                    <input type="text" class="form-input" x-model="formData.major" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Kelas / Program Studi <span class="req">*</span></label>
                    <input type="text" class="form-input" x-model="formData.class_or_program" required>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">
                <i class="fas fa-briefcase"></i>
                Data Magang
            </h3>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Bidang Kerja <span class="req">*</span></label>
                    <select class="form-input" x-model="formData.division" required>
                        <option value="">Pilih Bidang</option>
                        <option value="IT">IT & Development</option>
                        <option value="ADMIN">Administrasi</option>
                        <option value="FINANCE">Keuangan</option>
                        <option value="HR">SDM</option>
                        <option value="MARKETING">Marketing</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Ruangan <span class="req">*</span></label>
                    <input type="text" class="form-input" x-model="formData.room" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Lantai <span class="req">*</span></label>
                    <select class="form-input" x-model="formData.floor" required>
                        <option value="">Pilih Lantai</option>
                        <option value="1">Lantai 1</option>
                        <option value="2">Lantai 2</option>
                        <option value="3">Lantai 3</option>
                        <option value="4">Lantai 4</option>
                        <option value="5">Lantai 5</option>
                        <option value="6">Lantai 6</option>
                        <option value="7">Lantai 7</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Mulai <span class="req">*</span></label>
                    <input type="date" class="form-input" x-model="formData.start_date" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Selesai <span class="req">*</span></label>
                    <input type="date" class="form-input" x-model="formData.end_date" required>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="/institusi/dashboard/peserta" class="btn btn-secondary">
                <i class="fas fa-times"></i>
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Simpan Peserta
            </button>
        </div>
    </form>
</div>

<style>
.page-header{margin-bottom:2rem}.page-header-content{display:flex;justify-content:space-between}.page-title{font-family:'Outfit',sans-serif;font-size:2rem;font-weight:800;color:var(--text-primary);margin-bottom:0.5rem}.page-subtitle{font-size:0.9375rem;color:var(--text-secondary)}.form-card{background:var(--bg-primary);border-radius:16px;border:1px solid var(--border-primary);padding:2rem;box-shadow:var(--shadow-sm)}.form-section{margin-bottom:2rem}.form-section:last-of-type{margin-bottom:0}.form-section-title{font-family:'Outfit',sans-serif;font-size:1.125rem;font-weight:700;color:var(--text-primary);margin-bottom:1.5rem;padding-bottom:0.75rem;border-bottom:2px solid var(--border-primary);display:flex;align-items:center;gap:0.75rem}.form-section-title i{color:var(--accent-600)}.form-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1.25rem}.form-group{display:flex;flex-direction:column}.form-group.full-width{grid-column:1/-1}.form-label{font-size:0.875rem;font-weight:600;color:var(--text-primary);margin-bottom:0.5rem}.form-label .req{color:var(--danger-500)}.form-input,.form-textarea{padding:0.875rem;border:1px solid var(--border-primary);border-radius:10px;font-size:0.9375rem;transition:all 0.2s ease;background:var(--bg-secondary)}.form-input:focus,.form-textarea:focus{outline:none;border-color:var(--accent-500);background:white;box-shadow:0 0 0 3px rgba(6,182,212,0.1)}.form-textarea{font-family:inherit;resize:vertical}.form-actions{display:flex;justify-content:flex-end;gap:0.75rem;padding-top:2rem;border-top:1px solid var(--border-primary);margin-top:2rem}.btn{display:inline-flex;align-items:center;gap:0.625rem;padding:0.75rem 1.5rem;border-radius:10px;font-weight:600;font-size:0.9375rem;transition:all 0.2s ease;border:none;cursor:pointer;text-decoration:none}.btn-primary{background:var(--primary-800);color:white}.btn-primary:hover{background:var(--primary-700);transform:translateY(-2px);box-shadow:var(--shadow-md)}.btn-secondary{background:var(--gray-200);color:var(--text-primary)}.btn-secondary:hover{background:var(--gray-300)}@media(max-width:768px){.form-grid{grid-template-columns:1fr}}
</style>

<script>
function createParticipant(){return{formData:{name:'',identity_number:'',gender:'',email:'',phone:'',address:'',major:'',class_or_program:'',division:'',room:'',floor:'',start_date:'',end_date:''},submitForm(){console.log('Submitting:',this.formData);alert('Peserta berhasil ditambahkan!\n\n(Data akan dikirim ke backend untuk approval admin)');window.location.href='/institusi/dashboard/peserta'}}}
</script>
@endsection
