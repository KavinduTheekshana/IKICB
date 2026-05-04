<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentDetail extends Model
{
    protected $fillable = [
        'user_id',
        'image',
        'name_with_initials',
        'full_name',
        'date_of_birth',
        'gender',
        'id_number',
        'past_school',
        'phone',
        'permanent_address',
        'educational_qualifications',
        'work_experience',
        'emergency_contacts',
    ];

    protected $casts = [
        'date_of_birth'              => 'date',
        'educational_qualifications' => 'array',
        'work_experience'            => 'array',
        'emergency_contacts'         => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
