<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('image')->nullable();
            $table->string('name_with_initials')->nullable();
            $table->string('full_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('id_number')->nullable();
            $table->string('past_school')->nullable();
            $table->string('phone')->nullable();
            $table->json('educational_qualifications')->nullable();
            $table->json('work_experience')->nullable();
            $table->json('emergency_contacts')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_details');
    }
};
