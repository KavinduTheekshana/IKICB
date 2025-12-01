<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'order',
        'video_url',
        'module_price',
    ];

    protected $casts = [
        'module_price' => 'decimal:2',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function materials()
    {
        return $this->hasMany(ModuleMaterial::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'module_questions')
                    ->withPivot('order')
                    ->withTimestamps()
                    ->orderBy('module_questions.order');
    }

    public function theoryExams()
    {
        return $this->hasMany(TheoryExam::class);
    }

    public function unlocks()
    {
        return $this->hasMany(ModuleUnlock::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
