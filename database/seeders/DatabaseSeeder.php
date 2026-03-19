<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            // 1. Users & Branches
            AdminUserSeeder::class,
            BranchSeeder::class,

            // 2. Content
            InstructorSeeder::class,
            CourseSeeder::class,
            ModuleSeeder::class,
            ExamSeeder::class,

            // 3. Questions
            QuestionCategorySeeder::class,
            QuestionSeeder::class,

            // 4. Students & Activity
            StudentSeeder::class,
            PaymentEnrollmentSeeder::class,
        ]);
    }
}
