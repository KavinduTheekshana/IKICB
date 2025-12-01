<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question_category_id',
        'type',
        'question',
        'mcq_options',
        'correct_answer',
        'marks',
    ];

    protected $casts = [
        'mcq_options' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(QuestionCategory::class, 'question_category_id');
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'module_questions')
                    ->withPivot('order')
                    ->withTimestamps();
    }

    public function isMCQ(): bool
    {
        return $this->type === 'mcq';
    }

    public function isTheory(): bool
    {
        return $this->type === 'theory';
    }
}
