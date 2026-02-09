@extends('layouts.dashboard')

@section('title', 'Detail Institusi - Admin Dashboard')

@section('content')
<div x-data="institutionDetail()">
    <!-- Status Banner -->
    <div 
        class="status-banner" 
        :class="{
            'status-active': institution.status === 'active',
            'status-pending': institution.status === 'pending',
            'status-rejected': institution.status === 'rejected'
        }"
    >
        <div class="status-content">
            <div class="status-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="status-info">
                <h2 x-text="institution.name"></h2>
                <p x-text="`${institution.institution_type} • ${institution.participants_count} Peserta Aktif`"></p>
            </div>
        </div>
        <div>
            <span 
                class="status-badge-large" 
                x-text="getStatusText(institution.status)"
            ></span>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="action-bar">
        <a href="/admin/dashboard/institusi" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
        <div class="action-bar-right">
            <button @click="showEditModal = true" class="btn btn-primary">
                <i class="fas fa-edit"></i>
                Edit Data
            </button>
            
            <template x-if="institution.status === 'pending'">
                <div class="approval-buttons">
                    <button @click="approveInstitution" class="btn btn-success">
                        <i class="fas fa-check"></i>
                        Setujui
                    </button>
                    <button @click="showRejectModal = true" class="btn btn-danger">
                        <i class="fas fa-times"></i>
                        Tolak
                    </button>
                </div>
            </template>
            
            <button @click="confirmDelete" class="btn btn-danger-outline">
                <i class="fas fa-trash"></i>
                Hapus
            </button>
        </div>
    </div>

    <!-- Detail Grid -->
    <div class="detail-grid">
        <!-- Main Information -->
        <div class="detail-column">
            <!-- Basic Info -->
            <div class="info-card">
                <div class="card-header">
                    <h3>
                        <span class="card-header-icon">
                            <i class="fas fa-info-circle"></i>
                        </span>
                        Informasi Institusi
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-building"></i>
                            Nama Institusi
                        </div>
                        <div class="info-value" x-text="institution.name"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-tag"></i>
                            Jenis Institusi
                        </div>
                        <div class="info-value">
                            <span class="badge badge-neutral" x-text="institution.institution_type"></span>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i>
                            Email
                        </div>
                        <div class="info-value" x-text="institution.email"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-phone"></i>
                            WhatsApp
                        </div>
                        <div class="info-value" x-text="institution.whatsapp"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Alamat
                        </div>
                        <div class="info-value" x-text="institution.address"></div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="info-card">
                <div class="card-header">
                    <h3>
                        <span class="card-header-icon">
                            <i class="fas fa-chart-bar"></i>
                        </span>
                        Statistik Magang
                    </h3>
                </div>
                <div class="card-body">
                    <div class="stats-row">
                        <div class="stat-item">
                            <div class="stat-item-icon" style="background: rgba(6, 182, 212, 0.1); color: var(--accent-600);">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-item-content">
                                <div class="stat-item-value" x-text="institution.participants_count"></div>
                                <div class="stat-item-label">Total Peserta</div>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-item-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success-600);">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div class="stat-item-content">
                                <div class="stat-item-value" x-text="institution.active_participants"></div>
                                <div class="stat-item-label">Peserta Aktif</div>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-item-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="stat-item-content">
                                <div class="stat-item-value" x-text="institution.total_applications"></div>
                                <div class="stat-item-label">Total Pengajuan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="info-card">
                <div class="card-header">
                    <h3>
                        <span class="card-header-icon">
                            <i class="fas fa-file"></i>
                        </span>
                        Dokumen Pengajuan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="document-list">
                        <template x-for="doc in institution.documents" :key="doc.id">
                            <div class="document-item">
                                <div class="document-icon">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <div class="document-info">
                                    <div class="document-name" x-text="doc.name"></div>
                                    <div class="document-size" x-text="doc.size"></div>
                                </div>
                                <a href="#" @click.prevent="downloadDocument(doc)" class="document-action">
                                    <i class="fas fa-download"></i>
                                    Download
                                </a>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="detail-sidebar">
            <!-- Timeline -->
            <div class="info-card">
                <div class="card-header">
                    <h3>
                        <span class="card-header-icon">
                            <i class="fas fa-history"></i>
                        </span>
                        Timeline Aktivitas
                    </h3>
                </div>
                <div class="card-body">
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">Institusi Terdaftar</div>
                            <div class="timeline-date">
                                <i class="fas fa-clock"></i>
                                <span x-text="formatDate(institution.created_at)"></span>
                            </div>
                        </div>
                    </div>
                    <template x-if="institution.validated_at">
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Divalidasi oleh Admin</div>
                                <div class="timeline-date">
                                    <i class="fas fa-clock"></i>
                                    <span x-text="formatDate(institution.validated_at)"></span>
                                </div>
                                <div class="timeline-validator" x-text="`oleh ${institution.validator_name}`"></div>
                            </div>
                        </div>
                    </template>
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">Terakhir Diupdate</div>
                            <div class="timeline-date">
                                <i class="fas fa-clock"></i>
                                <span x-text="formatDate(institution.updated_at)"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Notes -->
            <div class="info-card">
                <div class="card-header">
                    <h3>
                        <span class="card-header-icon">
                            <i class="fas fa-sticky-note"></i>
                        </span>
                        Catatan Admin
                    </h3>
                </div>
                <div class="card-body">
                    <div class="admin-note-section">
                        <template x-if="institution.admin_note">
                            <div class="admin-note-display">
                                <p x-text="institution.admin_note"></p>
                                <button @click="editNote = true" class="btn-edit-note">
                                    <i class="fas fa-edit"></i>
                                    Edit Catatan
                                </button>
                            </div>
                        </template>
                        <template x-if="!institution.admin_note || editNote">
                            <div class="admin-note-form">
                                <textarea 
                                    x-model="noteContent" 
                                    class="note-textarea"
                                    placeholder="Tambahkan catatan tentang institusi ini..."
                                    rows="4"
                                ></textarea>
                                <div class="note-actions">
                                    <button @click="saveNote" class="btn btn-primary btn-sm">
                                        <i class="fas fa-save"></i>
                                        Simpan
                                    </button>
                                    <template x-if="editNote">
                                        <button @click="editNote = false; noteContent = institution.admin_note" class="btn btn-ghost btn-sm">
                                            Batal
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div x-show="showEditModal" class="modal-overlay" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="showEditModal = false" style="opacity: 1; pointer-events: all;" x-cloak>
        <div class="modal-container" @click.stop x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Data Institusi
                </h3>
                <button @click="showEditModal = false" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form @submit.prevent="submitEdit">
                <div class="modal-body">
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
                                Email
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
                            <label class="form-label">
                                Status
                                <span class="form-label-required">*</span>
                            </label>
                            <select class="form-input" x-model="formData.status" required>
                                <option value="active">Aktif</option>
                                <option value="pending">Pending</option>
                                <option value="rejected">Ditolak</option>
                                <option value="inactive">Nonaktif</option>
                            </select>
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
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="showEditModal = false">
                        <i class="fas fa-times"></i>
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- REJECT MODAL -->
    <div x-show="showRejectModal" class="modal-overlay" x-transition x-cloak @click="showRejectModal = false">
        <div class="modal-container modal-sm" @click.stop>
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-times-circle"></i>
                    Tolak Institusi
                </h3>
                <button @click="showRejectModal = false" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form @submit.prevent="rejectInstitution">
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Perhatian!</strong>
                            <p>Anda akan menolak institusi <strong x-text="institution.name"></strong>. Berikan alasan penolakan.</p>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            Alasan Penolakan
                            <span class="form-label-required">*</span>
                        </label>
                        <textarea 
                            x-model="rejectReason"
                            class="form-textarea" 
                            rows="4"
                            placeholder="Jelaskan alasan penolakan..."
                            required
                        ></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="showRejectModal = false">
                        Batal
                    </button>
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
/* Status Banner */
.status-banner {
    border-radius: 16px;
    padding: 1.75rem 2rem;
    color: white;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.status-banner.status-active {
    background: linear-gradient(135deg, var(--success-500), var(--success-600));
}

.status-banner.status-pending {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.status-banner.status-rejected {
    background: linear-gradient(135deg, var(--danger-500), #dc2626);
}

.status-content {
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.status-icon {
    width: 56px;
    height: 56px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    flex-shrink: 0;
    backdrop-filter: blur(10px);
}

.status-info h2 {
    font-family: 'Outfit', sans-serif;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.375rem;
    letter-spacing: -0.02em;
}

.status-info p {
    font-size: 0.9375rem;
    opacity: 0.9;
}

.status-badge-large {
    padding: 0.625rem 1.5rem;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 9999px;
    font-weight: 700;
    font-size: 0.875rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

/* Action Bar */
.action-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    gap: 1rem;
}

.action-bar-right {
    display: flex;
    gap: 0.75rem;
}

.approval-buttons {
    display: flex;
    gap: 0.75rem;
}

/* Detail Grid */
.detail-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 1.5rem;
}

.detail-column {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.detail-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Info Card */
.info-card {
    background: var(--bg-primary);
    border-radius: 16px;
    border: 1px solid var(--border-primary);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.card-header {
    padding: 1.5rem 1.75rem;
    border-bottom: 1px solid var(--border-primary);
    background: linear-gradient(180deg, var(--gray-50) 0%, transparent 100%);
}

.card-header h3 {
    font-family: 'Outfit', sans-serif;
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 0.625rem;
}

.card-header-icon {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, var(--accent-500), var(--accent-700));
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.875rem;
}

.card-body {
    padding: 1.75rem;
}

/* Info Rows */
.info-row {
    display: grid;
    grid-template-columns: 140px 1fr;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-primary);
}

.info-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.info-row:first-child {
    padding-top: 0;
}

.info-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-label i {
    font-size: 0.875rem;
    color: var(--accent-600);
}

.info-value {
    font-size: 0.9375rem;
    font-weight: 500;
    color: var(--text-primary);
}

/* Stats Row */
.stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.stat-item {
    display: flex;
    gap: 1rem;
    padding: 1.25rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px solid var(--border-primary);
}

.stat-item-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.stat-item-content {
    flex: 1;
}

.stat-item-value {
    font-family: 'Outfit', sans-serif;
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--text-primary);
    line-height: 1;
    margin-bottom: 0.25rem;
}

.stat-item-label {
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--text-secondary);
}

/* Documents */
.document-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.document-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    border: 1px solid var(--border-primary);
    transition: all 0.2s ease;
}

.document-item:hover {
    background: white;
    border-color: var(--accent-500);
    box-shadow: var(--shadow-md);
}

.document-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05));
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.document-icon i {
    color: var(--danger-500);
    font-size: 1.125rem;
}

.document-info {
    flex: 1;
}

.document-name {
    font-weight: 600;
    font-size: 0.875rem;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.document-size {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

.document-action {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--primary-800);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 600;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.document-action:hover {
    background: var(--primary-700);
    transform: translateY(-1px);
}

/* Timeline */
.timeline-item {
    display: flex;
    gap: 1.25rem;
    padding: 1.25rem 0;
    border-bottom: 1px solid var(--border-primary);
}

.timeline-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.timeline-item:first-child {
    padding-top: 0;
}

.timeline-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(6, 182, 212, 0.05));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border: 2px solid var(--accent-500);
}

.timeline-icon i {
    color: var(--accent-600);
    font-size: 1.125rem;
}

.timeline-content {
    flex: 1;
}

.timeline-title {
    font-weight: 600;
    font-size: 0.9375rem;
    color: var(--text-primary);
    margin-bottom: 0.375rem;
}

.timeline-date {
    font-size: 0.8125rem;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.timeline-validator {
    font-size: 0.8125rem;
    color: var(--text-tertiary);
    margin-top: 0.25rem;
}

/* Admin Notes */
.admin-note-section {
    min-height: 100px;
}

.admin-note-display p {
    font-size: 0.9375rem;
    color: var(--text-primary);
    line-height: 1.6;
    margin-bottom: 1rem;
}

.btn-edit-note {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--gray-100);
    color: var(--text-primary);
    border: 1px solid var(--border-primary);
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-edit-note:hover {
    background: var(--gray-200);
    border-color: var(--accent-500);
}

.note-textarea {
    width: 100%;
    padding: 0.875rem;
    border: 1px solid var(--border-primary);
    border-radius: 10px;
    font-size: 0.9375rem;
    font-family: inherit;
    resize: vertical;
    transition: all 0.2s ease;
}

.note-textarea:focus {
    outline: none;
    border-color: var(--accent-500);
    box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1);
}

.note-actions {
    display: flex;
    gap: 0.75rem;
    margin-top: 0.75rem;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.625rem;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9375rem;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
    text-decoration: none;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.btn-primary {
    background: var(--primary-800);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-700);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-secondary {
    background: var(--gray-200);
    color: var(--text-primary);
}

.btn-secondary:hover {
    background: var(--gray-300);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-success {
    background: var(--success-500);
    color: white;
}

.btn-success:hover {
    background: var(--success-600);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-danger {
    background: var(--danger-500);
    color: white;
}

.btn-danger:hover {
    background: #dc2626;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-danger-outline {
    background: transparent;
    color: var(--danger-500);
    border: 1px solid var(--danger-500);
}

.btn-danger-outline:hover {
    background: var(--danger-500);
    color: white;
}

.btn-ghost {
    background: transparent;
    color: var(--text-secondary);
    border: 1px solid var(--border-primary);
}

.btn-ghost:hover {
    background: var(--bg-secondary);
    border-color: var(--accent-500);
    color: var(--accent-600);
}

.badge {
    display: inline-flex;
    padding: 0.375rem 0.875rem;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 600;
}

.badge-neutral {
    background: var(--gray-100);
    color: var(--gray-700);
}

/* Modal */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
    z-index: 9998;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.modal-container {
    background: white;
    border-radius: 20px;
    max-width: 800px;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.modal-container.modal-sm {
    max-width: 500px;
}

.modal-header {
    padding: 1.75rem 2rem;
    border-bottom: 1px solid var(--border-primary);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    font-family: 'Outfit', sans-serif;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.modal-close {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: none;
    background: var(--gray-100);
    color: var(--text-secondary);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: var(--gray-200);
    color: var(--text-primary);
}

.modal-body {
    padding: 2rem;
}

.modal-footer {
    padding: 1.5rem 2rem;
    border-top: 1px solid var(--border-primary);
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
}

/* Form */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.form-label-required {
    color: var(--danger-500);
}

.form-input, .form-textarea {
    padding: 0.875rem;
    border: 1px solid var(--border-primary);
    border-radius: 10px;
    font-size: 0.9375rem;
    transition: all 0.2s ease;
}

.form-input:focus, .form-textarea:focus {
    outline: none;
    border-color: var(--accent-500);
    box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1);
}

/* Alert */
.alert {
    padding: 1rem 1.25rem;
    border-radius: 12px;
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.alert-warning {
    background: rgba(245, 158, 11, 0.1);
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.alert i {
    font-size: 1.25rem;
    color: #f59e0b;
    flex-shrink: 0;
}

.alert strong {
    display: block;
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: var(--text-primary);
}

.alert p {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin: 0;
}

/* Responsive */
@media (max-width: 1024px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-row {
        grid-template-columns: 1fr;
    }
    
    .action-bar {
        flex-direction: column;
        align-items: stretch;
    }
    
    .action-bar-right {
        flex-direction: column;
    }
}

[x-cloak] {
    display: none !important;
}
</style>

<script>
function institutionDetail() {
    return {
        institution: {
            id: 1,
            name: 'SMK Negeri 1 Jakarta',
            institution_type: 'SMK',
            email: 'admin@smkn1jakarta.sch.id',
            whatsapp: '081234567890',
            address: 'Jl. Pendidikan No. 123, Jakarta Pusat, DKI Jakarta 10110',
            status: 'pending',
            participants_count: 45,
            active_participants: 38,
            total_applications: 12,
            created_at: '2025-01-15',
            updated_at: '2025-02-05',
            validated_at: null,
            validator_name: null,
            admin_note: '',
            documents: [
                { id: 1, name: 'Surat Pengajuan Kerjasama', size: '2.3 MB' },
                { id: 2, name: 'Proposal Program Magang', size: '1.8 MB' },
                { id: 3, name: 'Surat Rekomendasi', size: '1.2 MB' }
            ]
        },
        
        showEditModal: false,
        showRejectModal: false,
        editNote: false,
        noteContent: '',
        rejectReason: '',
        formData: {},
        
        init() {
            this.resetFormData();
            this.noteContent = this.institution.admin_note;
        },
        
        resetFormData() {
            this.formData = {
                name: this.institution.name,
                institution_type: this.institution.institution_type,
                email: this.institution.email,
                whatsapp: this.institution.whatsapp,
                address: this.institution.address,
                status: this.institution.status
            };
        },
        
        submitEdit() {
            console.log('Updating institution:', this.formData);
            
            // Update institution data
            Object.assign(this.institution, this.formData);
            this.institution.updated_at = new Date().toISOString().split('T')[0];
            
            alert('Data institusi berhasil diperbarui!');
            this.showEditModal = false;
        },
        
        saveNote() {
            this.institution.admin_note = this.noteContent;
            this.editNote = false;
            alert('Catatan berhasil disimpan!');
        },
        
        approveInstitution() {
            if (confirm(`Apakah Anda yakin ingin menyetujui institusi ${this.institution.name}?`)) {
                this.institution.status = 'active';
                this.institution.validated_at = new Date().toISOString().split('T')[0];
                this.institution.validator_name = 'Admin Sistem';
                alert('Institusi berhasil disetujui!');
            }
        },
        
        rejectInstitution() {
            console.log('Rejecting institution with reason:', this.rejectReason);
            
            this.institution.status = 'rejected';
            this.institution.admin_note = `DITOLAK: ${this.rejectReason}`;
            this.institution.validated_at = new Date().toISOString().split('T')[0];
            this.institution.validator_name = 'Admin Sistem';
            
            alert('Institusi telah ditolak.');
            this.showRejectModal = false;
            this.rejectReason = '';
        },
        
        confirmDelete() {
            if (confirm(`PERINGATAN!\n\nAnda akan menghapus institusi "${this.institution.name}" beserta semua data terkait.\n\nTindakan ini tidak dapat dibatalkan. Lanjutkan?`)) {
                console.log('Deleting institution:', this.institution.id);
                alert('Institusi berhasil dihapus!\n\n(Akan redirect ke halaman daftar institusi)');
                window.location.href = '/admin/dashboard/institusi';
            }
        },
        
        downloadDocument(doc) {
            alert(`Mengunduh dokumen: ${doc.name}`);
        },
        
        formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        },
        
        getStatusText(status) {
            const statusMap = {
                'active': 'Aktif',
                'pending': 'Menunggu Persetujuan',
                'rejected': 'Ditolak',
                'inactive': 'Nonaktif'
            };
            return statusMap[status] || status;
        }
    }
}
</script>
@endsection
