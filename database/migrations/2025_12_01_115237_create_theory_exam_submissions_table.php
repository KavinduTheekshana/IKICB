<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('theory_exam_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theory_exam_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('submission_file_path');
            $table->integer('marks_obtained')->nullable();
            $table->text('feedback')->nullable();
            $table->enum('status', ['pending', 'graded'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theory_exam_submissions');
    }
};
