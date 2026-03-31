<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class StudentSubmission extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'module_id',
        'title',
        'description',
        'file_type',
        'file_path',
        'file_mime',
        'file_size',
        'bunny_library_id',
        'bunny_video_id',
        'video_url',
        'status',
        'admin_feedback',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'file_size'   => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function isVideo(): bool
    {
        return $this->file_type === 'video';
    }

    public function getFileUrl(): ?string
    {
        if ($this->isVideo()) {
            return $this->video_url;
        }
        if ($this->file_path) {
            return Storage::url($this->file_path);
        }
        return null;
    }

    public function getFileSizeFormatted(): string
    {
        if (!$this->file_size) return '—';
        $units = ['B', 'KB', 'MB', 'GB'];
        $size  = $this->file_size;
        $unit  = 0;
        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }
        return round($size, 1) . ' ' . $units[$unit];
    }

    public function getStatusColor(): string
    {
        return match ($this->status) {
            'approved'  => 'green',
            'rejected'  => 'red',
            'reviewed'  => 'blue',
            default     => 'yellow',
        };
    }
}
