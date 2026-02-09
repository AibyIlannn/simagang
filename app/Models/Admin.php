<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';

    protected $fillable = [
        'role',
        'name',
        'email',
        'password',
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
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class, 'actor_id')
            ->where('actor_type', 'ADMIN');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeSuperadmin($query)
    {
        return $query->where('role', 'SUPERADMIN');
    }

    public function scopeAdmin($query)
    {
        return $query->where('role', 'ADMIN');
    }

    // Accessors
    public function isSuperadmin()
    {
        return $this->role === 'SUPERADMIN';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }
}
