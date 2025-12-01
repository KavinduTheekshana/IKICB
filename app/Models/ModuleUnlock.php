<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleUnlock extends Model
{
    protected $fillable = [
        'user_id',
        'module_id',
        'payment_id',
        'unlocked_at',
    ];

    protected $casts = [
        'unlocked_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
