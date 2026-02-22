<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'module_id',
        'amount',
        'currency',
        'payment_gateway',
        'payment_method',
        'transaction_id',
        'reference_number',
        'status',
        'payment_details',
        'receipt_path',
        'admin_notes',
        'approved_by',
        'approved_at',
        'completed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'array',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
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

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
