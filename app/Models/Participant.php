<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $table = 'participants';

    protected $fillable = [
        'application_id',
        'user_id',
        'name',
        'participant_type',
        'identity_number',
        'major',
        'class_or_program',
        'semester',
        'division',
        'room',
        'floor',
        'status',
    ];

    protected $casts = [
        'semester' => 'integer',
        'floor' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function application()
    {
        return $this->belongsTo(InternshipApplication::class, 'application_id');
    }

    public function user()
    {
        return $this->belongsTo(Account::class, 'user_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'participant_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFinished($query)
    {
        return $query->where('status', 'finished');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeSiswa($query)
    {
        return $query->where('participant_type', 'SISWA');
    }

    public function scopeMahasiswa($query)
    {
        return $query->where('participant_type', 'MAHASISWA');
    }

    // Accessors
    public function isSiswa()
    {
        return $this->participant_type === 'SISWA';
    }

    public function isMahasiswa()
    {
        return $this->participant_type === 'MAHASISWA';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isFinished()
    {
        return $this->status === 'finished';
    }
}