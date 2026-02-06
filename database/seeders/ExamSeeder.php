<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\TheoryExam;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = Module::all();

        foreach ($modules as $module) {
            // Create a theory exam for each module
            TheoryExam::create([
                'module_id' => $module->id,
                'title' => $module->title . ' - Theory Assessment',
                'description' => 'Comprehensive theory assessment covering all topics from ' . $module->title . '. This exam tests your understanding of key concepts, techniques, and best practices.',
                'exam_paper_path' => null,
                'total_marks' => 100,
            ]);
        }

        // Create some additional practical exams for selected modules
        $practicalModules = [
            'Bridal Makeup Techniques',
            'Eye Makeup Mastery',
            'Hair Cutting Fundamentals',
            'Gel & Acrylic Extensions',
            'Swedish Massage Techniques',
        ];

        foreach ($modules as $module) {
            if (in_array($module->title, $practicalModules)) {
                TheoryExam::create([
                    'module_id' => $module->id,
                    'title' => $module->title . ' - Practical Skills Test',
                    'description' => 'Hands-on practical examination to demonstrate your proficiency in ' . $module->title . '. You will be assessed on technique, precision, hygiene, and final results.',
                    'exam_paper_path' => null,
                    'total_marks' => 100,
                ]);
            }
        }
    }
}
