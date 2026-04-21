<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingAttendance extends Model
{
    protected $fillable = [
        'module_meeting_id',
        'user_id',
        'joined_at',
        'marked_by',
        'notes',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    public function meeting()
    {
        return $this->belongsTo(ModuleMeeting::class, 'module_meeting_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markedBy()
    {
        return $this->belongsTo(User::class, 'marked_by');
    }
}
