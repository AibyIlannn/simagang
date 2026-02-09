@extends('layouts.dashboard')

@section('title', 'Detail Peserta - Admin Dashboard')

@section('content')
<div x-data="participantDetail()">
    <!-- Status Banner -->
    <div class="status-banner" :class="`status-${participant.status}`">
        <div class="status-content">
            <div class="status-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="status-info">
                <h2 x-text="participant.name"></h2>
                <p x-text="`${participant.participant_type} • ${participant.institution_name}`"></p>
            </div>
        </div>
        <div>
            <span class="status-badge-large" x-text="getStatusText(participant.status)"></span>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="action-bar">
        <a href="/admin/dashboard/peserta" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
        <div class="action-bar-right">
            <button @click="showEditModal = true" class="btn btn-primary">
                <i class="fas fa-edit"></i>
                Edit Data
            </button>
            
            <template x-if="participant.status === 'pending'">
                <div class="approval-buttons">
                    <button @click="approveParticipant" class="btn btn-success">
                        <i class="fas fa-check"></i>
                        Setujui
                    </button>
                    <button @click="showRejectModal = true" class="btn btn-danger">
                        <i class="fas fa-times"></i>
                        Tolak
                    </button>
                </div>
            </template>
            
            <template x-if="participant.status === 'active'">
                <button @click="finishInternship" class="btn btn-success">
                    <i class="fas fa-check-double"></i>
                    Selesaikan Magang
                </button>
            </template>
            
            <button @click="confirmDelete" class="btn btn-danger-outline">
                <i class="fas fa-trash"></i>
                Hapus
            </button>
        </div>
    </div>

    <!-- Detail Grid -->
    <div class="detail-grid">
        <div class="detail-column">
            <!-- Personal Info -->
            <div class="info-card">
                <div class="card-header">
                    <h3>
                        <span class="card-header-icon">
                            <i class="fas fa-user"></i>
                        </span>
                        Data Pribadi
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-id-card"></i> Nama Lengkap</div>
                        <div class="info-value" x-text="participant.name"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-hashtag"></i> <span x-text="participant.participant_type === 'SISWA' ? 'NISN' : 'NIM'"></span></div>
                        <div class="info-value" x-text="participant.identity_number"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-venus-mars"></i> Jenis Kelamin</div>
                        <div class="info-value" x-text="participant.gender === 'L' ? 'Laki-laki' : 'Perempuan'"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-envelope"></i> Email</div>
                        <div class="info-value" x-text="participant.email"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-phone"></i> No. Telepon</div>
                        <div class="info-value" x-text="participant.phone"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-map-marker-alt"></i> Alamat</div>
                        <div class="info-value" x-text="participant.address"></div>
                    </div>
                </div>
            </div>

            <!-- Education Info -->
            <div class="info-card">
                <div class="card-header">
                    <h3>
                        <span class="card-header-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </span>
                        Data Pendidikan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-building"></i> Institusi</div>
                        <div class="info-value" x-text="participant.institution_name"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-book"></i> Jurusan</div>
                        <div class="info-value" x-text="participant.major"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-chalkboard"></i> <span x-text="participant.participant_type === 'SISWA' ? 'Kelas' : 'Program Studi'"></span></div>
                        <div class="info-value" x-text="participant.class_or_program"></div>
                    </div>
                    <template x-if="participant.participant_type === 'MAHASISWA'">
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-layer-group"></i> Semester</div>
                            <div class="info-value" x-text="participant.semester"></div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Internship Info -->
            <div class="info-card">
                <div class="card-header">
                    <h3>
                        <span class="card-header-icon">
                            <i class="fas fa-briefcase"></i>
                        </span>
                        Data Magang
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-building"></i> Bidang Kerja</div>
                        <div class="info-value" x-text="participant.division"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-door-open"></i> Ruangan</div>
                        <div class="info-value" x-text="participant.room"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-layer-group"></i> Lantai</div>
                        <div class="info-value" x-text="`Lantai ${participant.floor}`"></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-calendar-alt"></i> Periode Magang</div>
                        <div class="info-value">
                            <strong x-text="formatDate(participant.start_date)"></strong> s/d <strong x-text="formatDate(participant.end_date)"></strong>
                            <span class="info-value-secondary" x-text="`${participant.duration} hari`"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports -->
            <div class="info-card">
                <div class="card-header">
                    <h3>
                        <span class="card-header-icon">
                            <i class="fas fa-file-alt"></i>
                        </span>
                        Laporan Magang
                    </h3>
                </div>
                <div class="card-body">
                    <div class="stats-row">
                        <div class="stat-item">
                            <div class="stat-item-icon" style="background: rgba(6, 182, 212, 0.1); color: var(--accent-600);">
                                <i class="fas fa-file"></i>
                            </div>
                            <div class="stat-item-content">
                                <div class="stat-item-value" x-text="participant.reports_count"></div>
                                <div class="stat-item-label">Total Laporan</div>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-item-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success-600);">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-item-content">
                                <div class="stat-item-value" x-text="participant.approved_reports"></div>
                                <div class="stat-item-label">Disetujui</div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 1rem;">
                        <a href="/admin/dashboard/laporan?participant_id=${participant.id}" class="btn btn-primary btn-block">
                            <i class="fas fa-list"></i>
                            Lihat Semua Laporan
                        </a>
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
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">Peserta Terdaftar</div>
                            <div class="timeline-date">
                                <i class="fas fa-clock"></i>
                                <span x-text="formatDate(participant.created_at)"></span>
                            </div>
                        </div>
                    </div>
                    <template x-if="participant.validated_at">
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Divalidasi Admin</div>
                                <div class="timeline-date">
                                    <i class="fas fa-clock"></i>
                                    <span x-text="formatDate(participant.validated_at)"></span>
                                </div>
                                <div class="timeline-validator" x-text="`oleh ${participant.validator_name}`"></div>
                            </div>
                        </div>
                    </template>
                    <template x-if="participant.status === 'active'">
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-play-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Magang Dimulai</div>
                                <div class="timeline-date">
                                    <i class="fas fa-clock"></i>
                                    <span x-text="formatDate(participant.start_date)"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template x-if="participant.status === 'finished'">
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-check-double"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Magang Selesai</div>
                                <div class="timeline-date">
                                    <i class="fas fa-clock"></i>
                                    <span x-text="formatDate(participant.end_date)"></span>
                                </div>
                            </div>
                        </div>
                    </template>
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
                        <template x-if="participant.admin_note && !editNote">
                            <div class="admin-note-display">
                                <p x-text="participant.admin_note"></p>
                                <button @click="editNote = true" class="btn-edit-note">
                                    <i class="fas fa-edit"></i>
                                    Edit Catatan
                                </button>
                            </div>
                        </template>
                        <template x-if="!participant.admin_note || editNote">
                            <div class="admin-note-form">
                                <textarea 
                                    x-model="noteContent" 
                                    class="note-textarea"
                                    placeholder="Tambahkan catatan tentang peserta ini..."
                                    rows="4"
                                ></textarea>
                                <div class="note-actions">
                                    <button @click="saveNote" class="btn btn-primary btn-sm">
                                        <i class="fas fa-save"></i>
                                        Simpan
                                    </button>
                                    <template x-if="editNote">
                                        <button @click="editNote = false; noteContent = participant.admin_note" class="btn btn-ghost btn-sm">
                                            Batal
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </template>
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
                        Dokumen
                    </h3>
                </div>
                <div class="card-body">
                    <div class="document-list">
                        <template x-for="doc in participant.documents" :key="doc.id">
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
                                </a>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div x-show="showEditModal" class="modal-overlay" x-transition @click="showEditModal = false" x-cloak>
        <div class="modal-container" @click.stop>
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Edit Data Peserta
                </h3>
                <button @click="showEditModal = false" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form @submit.prevent="submitEdit">
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label class="form-label">Nama Lengkap <span class="form-label-required">*</span></label>
                            <input type="text" class="form-input" x-model="formData.name" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><span x-text="formData.participant_type === 'SISWA' ? 'NISN' : 'NIM'"></span> <span class="form-label-required">*</span></label>
                            <input type="text" class="form-input" x-model="formData.identity_number" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin <span class="form-label-required">*</span></label>
                            <select class="form-input" x-model="formData.gender" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email <span class="form-label-required">*</span></label>
                            <input type="email" class="form-input" x-model="formData.email" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">No. Telepon <span class="form-label-required">*</span></label>
                            <input type="tel" class="form-input" x-model="formData.phone" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Bidang Kerja <span class="form-label-required">*</span></label>
                            <select class="form-input" x-model="formData.division" required>
                                <option value="IT">IT & Development</option>
                                <option value="ADMIN">Administrasi</option>
                                <option value="FINANCE">Keuangan</option>
                                <option value="HR">SDM</option>
                                <option value="MARKETING">Marketing</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Ruangan <span class="form-label-required">*</span></label>
                            <input type="text" class="form-input" x-model="formData.room" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Lantai <span class="form-label-required">*</span></label>
                            <select class="form-input" x-model="formData.floor" required>
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
                            <label class="form-label">Status <span class="form-label-required">*</span></label>
                            <select class="form-input" x-model="formData.status" required>
                                <option value="pending">Pending</option>
                                <option value="active">Aktif</option>
                                <option value="finished">Selesai</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">Alamat <span class="form-label-required">*</span></label>
                            <textarea class="form-textarea" x-model="formData.address" rows="3" required></textarea>
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
    <div x-show="showRejectModal" class="modal-overlay" x-transition @click="showRejectModal = false" x-cloak>
        <div class="modal-container modal-sm" @click.stop>
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-times-circle"></i>
                    Tolak Peserta
                </h3>
                <button @click="showRejectModal = false" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form @submit.prevent="rejectParticipant">
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Perhatian!</strong>
                            <p>Anda akan menolak peserta <strong x-text="participant.name"></strong>. Berikan alasan penolakan.</p>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Alasan Penolakan <span class="form-label-required">*</span></label>
                        <textarea x-model="rejectReason" class="form-textarea" rows="4" required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="showRejectModal = false">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i>
                        Tolak Peserta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Reusing styles from institusi-show.blade.php */
.status-banner { border-radius: 16px; padding: 1.75rem 2rem; color: white; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15); }
.status-banner.status-active { background: linear-gradient(135deg, var(--success-500), var(--success-600)); }
.status-banner.status-pending { background: linear-gradient(135deg, #f59e0b, #d97706); }
.status-banner.status-finished { background: linear-gradient(135deg, #8b5cf6, #6d28d9); }
.status-banner.status-rejected { background: linear-gradient(135deg, var(--danger-500), #dc2626); }
.status-content { display: flex; align-items: center; gap: 1.25rem; }
.status-icon { width: 56px; height: 56px; background: rgba(255, 255, 255, 0.2); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; flex-shrink: 0; backdrop-filter: blur(10px); }
.status-info h2 { font-family: 'Outfit', sans-serif; font-size: 1.5rem; font-weight: 700; margin-bottom: 0.375rem; letter-spacing: -0.02em; }
.status-info p { font-size: 0.9375rem; opacity: 0.9; }
.status-badge-large { padding: 0.625rem 1.5rem; background: rgba(255, 255, 255, 0.2); border-radius: 9999px; font-weight: 700; font-size: 0.875rem; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); }
.action-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; gap: 1rem; }
.action-bar-right { display: flex; gap: 0.75rem; }
.approval-buttons { display: flex; gap: 0.75rem; }
.detail-grid { display: grid; grid-template-columns: 1fr 400px; gap: 1.5rem; }
.detail-column { display: flex; flex-direction: column; gap: 1.5rem; }
.detail-sidebar { display: flex; flex-direction: column; gap: 1.5rem; }
.info-card { background: var(--bg-primary); border-radius: 16px; border: 1px solid var(--border-primary); overflow: hidden; box-shadow: var(--shadow-sm); }
.card-header { padding: 1.5rem 1.75rem; border-bottom: 1px solid var(--border-primary); background: linear-gradient(180deg, var(--gray-50) 0%, transparent 100%); }
.card-header h3 { font-family: 'Outfit', sans-serif; font-size: 1.125rem; font-weight: 700; color: var(--text-primary); display: flex; align-items: center; gap: 0.625rem; }
.card-header-icon { width: 32px; height: 32px; background: linear-gradient(135deg, var(--accent-500), var(--accent-700)); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.875rem; }
.card-body { padding: 1.75rem; }
.info-row { display: grid; grid-template-columns: 140px 1fr; gap: 1rem; padding: 1rem 0; border-bottom: 1px solid var(--border-primary); }
.info-row:last-child { border-bottom: none; padding-bottom: 0; }
.info-row:first-child { padding-top: 0; }
.info-label { font-size: 0.875rem; font-weight: 600; color: var(--text-secondary); display: flex; align-items: center; gap: 0.5rem; }
.info-label i { font-size: 0.875rem; color: var(--accent-600); }
.info-value { font-size: 0.9375rem; font-weight: 500; color: var(--text-primary); }
.info-value strong { font-weight: 700; color: var(--primary-800); }
.info-value-secondary { display: block; font-size: 0.8125rem; color: var(--text-secondary); margin-top: 0.25rem; }
.stats-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; }
.stat-item { display: flex; gap: 1rem; padding: 1.25rem; background: var(--bg-secondary); border-radius: 12px; border: 1px solid var(--border-primary); }
.stat-item-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0; }
.stat-item-content { flex: 1; }
.stat-item-value { font-family: 'Outfit', sans-serif; font-size: 1.75rem; font-weight: 800; color: var(--text-primary); line-height: 1; margin-bottom: 0.25rem; }
.stat-item-label { font-size: 0.8125rem; font-weight: 500; color: var(--text-secondary); }
.timeline-item { display: flex; gap: 1.25rem; padding: 1.25rem 0; border-bottom: 1px solid var(--border-primary); }
.timeline-item:last-child { border-bottom: none; padding-bottom: 0; }
.timeline-item:first-child { padding-top: 0; }
.timeline-icon { width: 48px; height: 48px; background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(6, 182, 212, 0.05)); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 2px solid var(--accent-500); }
.timeline-icon i { color: var(--accent-600); font-size: 1.125rem; }
.timeline-content { flex: 1; }
.timeline-title { font-weight: 600; font-size: 0.9375rem; color: var(--text-primary); margin-bottom: 0.375rem; }
.timeline-date { font-size: 0.8125rem; color: var(--text-secondary); display: flex; align-items: center; gap: 0.375rem; }
.timeline-validator { font-size: 0.8125rem; color: var(--text-tertiary); margin-top: 0.25rem; }
.admin-note-section { min-height: 100px; }
.admin-note-display p { font-size: 0.9375rem; color: var(--text-primary); line-height: 1.6; margin-bottom: 1rem; }
.btn-edit-note { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background: var(--gray-100); color: var(--text-primary); border: 1px solid var(--border-primary); border-radius: 8px; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; }
.btn-edit-note:hover { background: var(--gray-200); border-color: var(--accent-500); }
.note-textarea { width: 100%; padding: 0.875rem; border: 1px solid var(--border-primary); border-radius: 10px; font-size: 0.9375rem; font-family: inherit; resize: vertical; transition: all 0.2s ease; }
.note-textarea:focus { outline: none; border-color: var(--accent-500); box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1); }
.note-actions { display: flex; gap: 0.75rem; margin-top: 0.75rem; }
.document-list { display: flex; flex-direction: column; gap: 0.75rem; }
.document-item { display: flex; align-items: center; gap: 1rem; padding: 1rem; background: var(--bg-secondary); border-radius: 12px; border: 1px solid var(--border-primary); transition: all 0.2s ease; }
.document-item:hover { background: white; border-color: var(--accent-500); box-shadow: var(--shadow-md); }
.document-icon { width: 40px; height: 40px; background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05)); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.document-icon i { color: var(--danger-500); font-size: 1.125rem; }
.document-info { flex: 1; }
.document-name { font-weight: 600; font-size: 0.875rem; color: var(--text-primary); margin-bottom: 0.25rem; }
.document-size { font-size: 0.75rem; color: var(--text-secondary); }
.document-action { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: var(--primary-800); color: white; text-decoration: none; border-radius: 8px; transition: all 0.2s ease; border: none; cursor: pointer; }
.document-action:hover { background: var(--primary-700); transform: translateY(-1px); }
.btn { display: inline-flex; align-items: center; gap: 0.625rem; padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 600; font-size: 0.9375rem; transition: all 0.2s ease; border: none; cursor: pointer; text-decoration: none; }
.btn-sm { padding: 0.5rem 1rem; font-size: 0.875rem; }
.btn-block { width: 100%; justify-content: center; }
.btn-primary { background: var(--primary-800); color: white; }
.btn-primary:hover { background: var(--primary-700); transform: translateY(-2px); box-shadow: var(--shadow-md); }
.btn-secondary { background: var(--gray-200); color: var(--text-primary); }
.btn-secondary:hover { background: var(--gray-300); transform: translateY(-2px); box-shadow: var(--shadow-md); }
.btn-success { background: var(--success-500); color: white; }
.btn-success:hover { background: var(--success-600); transform: translateY(-2px); box-shadow: var(--shadow-md); }
.btn-danger { background: var(--danger-500); color: white; }
.btn-danger:hover { background: #dc2626; transform: translateY(-2px); box-shadow: var(--shadow-md); }
.btn-danger-outline { background: transparent; color: var(--danger-500); border: 1px solid var(--danger-500); }
.btn-danger-outline:hover { background: var(--danger-500); color: white; }
.btn-ghost { background: transparent; color: var(--text-secondary); border: 1px solid var(--border-primary); }
.btn-ghost:hover { background: var(--bg-secondary); border-color: var(--accent-500); color: var(--accent-600); }
.modal-overlay { position: fixed; inset: 0; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px); z-index: 9998; display: flex; align-items: center; justify-content: center; padding: 2rem; }
.modal-container { background: white; border-radius: 20px; max-width: 800px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
.modal-container.modal-sm { max-width: 500px; }
.modal-header { padding: 1.75rem 2rem; border-bottom: 1px solid var(--border-primary); display: flex; justify-content: space-between; align-items: center; }
.modal-title { font-family: 'Outfit', sans-serif; font-size: 1.25rem; font-weight: 700; color: var(--text-primary); display: flex; align-items: center; gap: 0.75rem; }
.modal-close { width: 36px; height: 36px; border-radius: 8px; border: none; background: var(--gray-100); color: var(--text-secondary); cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; }
.modal-close:hover { background: var(--gray-200); color: var(--text-primary); }
.modal-body { padding: 2rem; }
.modal-footer { padding: 1.5rem 2rem; border-top: 1px solid var(--border-primary); display: flex; justify-content: flex-end; gap: 0.75rem; }
.form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem; }
.form-group { display: flex; flex-direction: column; }
.form-group.full-width { grid-column: 1 / -1; }
.form-label { font-size: 0.875rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem; }
.form-label-required { color: var(--danger-500); }
.form-input, .form-textarea { padding: 0.875rem; border: 1px solid var(--border-primary); border-radius: 10px; font-size: 0.9375rem; transition: all 0.2s ease; }
.form-input:focus, .form-textarea:focus { outline: none; border-color: var(--accent-500); box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1); }
.alert { padding: 1rem 1.25rem; border-radius: 12px; display: flex; gap: 1rem; margin-bottom: 1.5rem; }
.alert-warning { background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); }
.alert i { font-size: 1.25rem; color: #f59e0b; flex-shrink: 0; }
.alert strong { display: block; font-weight: 700; margin-bottom: 0.25rem; color: var(--text-primary); }
.alert p { font-size: 0.875rem; color: var(--text-secondary); margin: 0; }
[x-cloak] { display: none !important; }

@media (max-width: 1024px) {
    .detail-grid { grid-template-columns: 1fr; }
    .stats-row { grid-template-columns: 1fr; }
    .action-bar { flex-direction: column; align-items: stretch; }
    .action-bar-right { flex-direction: column; }
}
</style>

<script>
function participantDetail() {
    return {
        participant: {
            id: 1,
            name: 'Ahmad Fauzi Rahman',
            identity_number: '0012345678',
            participant_type: 'SISWA',
            gender: 'L',
            email: 'ahmad.fauzi@student.smk.sch.id',
            phone: '081234567890',
            address: 'Jl. Raya Kebon Jeruk No. 123, RT 05 RW 08, Kelurahan Kebon Jeruk, Kecamatan Kebon Jeruk, Jakarta Barat 11530',
            institution_name: 'SMK Negeri 1 Jakarta',
            major: 'Rekayasa Perangkat Lunak',
            class_or_program: 'XII RPL 1',
            semester: null,
            division: 'IT & Development',
            room: 'A101',
            floor: 1,
            start_date: '2026-01-15',
            end_date: '2026-06-30',
            duration: 166,
            status: 'active',
            reports_count: 12,
            approved_reports: 10,
            created_at: '2025-12-20',
            validated_at: '2026-01-10',
            validator_name: 'Admin Sistem',
            admin_note: '',
            documents: [
                { id: 1, name: 'Surat Pengantar Sekolah', size: '2.3 MB' },
                { id: 2, name: 'CV dan Portfolio', size: '1.8 MB' }
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
            this.noteContent = this.participant.admin_note;
        },
        
        resetFormData() {
            this.formData = { ...this.participant };
        },
        
        submitEdit() {
            Object.assign(this.participant, this.formData);
            alert('Data peserta berhasil diperbarui!');
            this.showEditModal = false;
        },
        
        saveNote() {
            this.participant.admin_note = this.noteContent;
            this.editNote = false;
            alert('Catatan berhasil disimpan!');
        },
        
        approveParticipant() {
            if (confirm(`Setujui peserta ${this.participant.name}?`)) {
                this.participant.status = 'active';
                this.participant.validated_at = new Date().toISOString().split('T')[0];
                this.participant.validator_name = 'Admin Sistem';
                alert('Peserta berhasil disetujui!');
            }
        },
        
        rejectParticipant() {
            this.participant.status = 'rejected';
            this.participant.admin_note = `DITOLAK: ${this.rejectReason}`;
            this.participant.validated_at = new Date().toISOString().split('T')[0];
            this.participant.validator_name = 'Admin Sistem';
            alert('Peserta telah ditolak.');
            this.showRejectModal = false;
        },
        
        finishInternship() {
            if (confirm(`Selesaikan magang untuk ${this.participant.name}?`)) {
                this.participant.status = 'finished';
                alert('Magang berhasil diselesaikan!');
            }
        },
        
        confirmDelete() {
            if (confirm(`PERINGATAN!\n\nHapus peserta "${this.participant.name}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
                alert('Peserta berhasil dihapus!');
                window.location.href = '/admin/dashboard/peserta';
            }
        },
        
        downloadDocument(doc) {
            alert(`Mengunduh: ${doc.name}`);
        },
        
        formatDate(dateString) {
            return new Date(dateString).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
        },
        
        getStatusText(status) {
            const map = { 'active': 'Sedang Magang', 'pending': 'Menunggu Persetujuan', 'finished': 'Selesai', 'rejected': 'Ditolak' };
            return map[status] || status;
        }
    }
}
</script>
@endsection
