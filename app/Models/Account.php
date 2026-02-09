<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Account extends Authenticatable
{
    use Notifiable;

    protected $table = 'accounts';

    protected $fillable = [
        'role',
        'name',
        'email',
        'whatsapp',
        'password',
        'institution_type',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function internshipApplications()
    {
        return $this->hasMany(InternshipApplication::class, 'institution_id');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class, 'user_id');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class, 'actor_id')
            ->where('actor_type', 'USER');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeInstitusi($query)
    {
        return $query->where('role', 'INSTITUSI');
    }

    public function scopePeserta($query)
    {
        return $query->where('role', 'PESERTA');
    }

    // Accessors
    public function isInstitusi()
    {
        return $this->role === 'INSTITUSI';
    }

    public function isPeserta()
    {
        return $this->role === 'PESERTA';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
