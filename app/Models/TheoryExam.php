<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TheoryExam extends Model
{
    protected $fillable = [
        'module_id',
        'title',
        'description',
        'exam_paper_path',
        'total_marks',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function submissions()
    {
        return $this->hasMany(TheoryExamSubmission::class);
    }
}
