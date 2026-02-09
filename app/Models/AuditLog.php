<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    public $timestamps = false;

    protected $fillable = [
        'actor_type',
        'actor_id',
        'action',
        'target_table',
        'target_id',
        'description',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relationships
    public function actor()
    {
        if ($this->actor_type === 'ADMIN') {
            return $this->belongsTo(Admin::class, 'actor_id');
        }
        return $this->belongsTo(Account::class, 'actor_id');
    }

    // Scopes
    public function scopeByAdmin($query)
    {
        return $query->where('actor_type', 'ADMIN');
    }

    public function scopeByUser($query)
    {
        return $query->where('actor_type', 'USER');
    }

    public function scopeAction($query, $action)
    {
        return $query->where('action', $action);
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}