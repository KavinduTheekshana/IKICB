<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleVideo extends Model
{
    protected $fillable = [
        'module_id',
        'title',
        'description',
        'bunny_library_id',
        'bunny_video_id',
        'video_url',
        'expires_at',
        'status',
        'order',
        'temp_file_path',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function isAccessible(): bool
    {
        return $this->status === 'ready' && !$this->isExpired();
    }
}
