<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TheoryExamSubmission extends Model
{
    protected $fillable = [
        'theory_exam_id',
        'user_id',
        'submission_file_path',
        'marks_obtained',
        'feedback',
        'status',
    ];

    public function theoryExam()
    {
        return $this->belongsTo(TheoryExam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
