<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationDocument extends Model
{
    protected $table = 'application_documents';

    public $timestamps = false;

    protected $fillable = [
        'application_id',
        'document_type',
        'file_path',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relationships
    public function application()
    {
        return $this->belongsTo(InternshipApplication::class, 'application_id');
    }

    // Accessors
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    public function getFileNameAttribute()
    {
        return basename($this->file_path);
    }
}