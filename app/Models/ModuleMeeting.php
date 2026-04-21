<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleMeeting extends Model
{
    protected $fillable = [
        'module_id',
        'title',
        'meeting_type',
        'meeting_link',
        'starts_at',
        'description',
        'is_active',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function getMeetingTypeLabel(): string
    {
        return match($this->meeting_type) {
            'google_meet' => 'Google Meet',
            'zoom'        => 'Zoom',
            default       => 'Meeting',
        };
    }
}
