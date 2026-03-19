<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Module;
use App\Models\ModuleCompletion;
use App\Models\ModuleUnlock;
use App\Models\Payment;
use App\Models\QuizAttempt;
use App\Models\TheoryExamSubmission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PaymentEnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('role', 'student')->get();
        $courses  = Course::with('modules')->get();
        $admin    = User::where('role', 'admin')->first();

        if ($students->isEmpty() || $courses->isEmpty()) {
            $this->command->warn('No students or courses found. Skipping.');
            return;
        }

        foreach ($students as $index => $student) {
            // Each student enrolls in 1-3 courses
            $numCourses = ($index % 3) + 1;
            $selectedCourses = $courses->shuffle()->take($numCourses);

            foreach ($selectedCourses as $courseIndex => $course) {
                $enrolledAt = Carbon::now()->subDays(rand(10, 180));

                // Determine payment scenario
                $scenario = $index % 5; // 0=completed full, 1=pending, 2=failed, 3=module-by-module, 4=completed partial

                if ($scenario === 1) {
                    // Pending bank transfer payment
                    Payment::create([
                        'user_id'          => $student->id,
                        'course_id'        => $course->id,
                        'amount'           => $course->full_price,
                        'currency'         => 'LKR',
                        'payment_gateway'  => 'bank_transfer',
                        'payment_method'   => 'bank_transfer',
                        'transaction_id'   => 'BT-' . strtoupper(Str::random(8)),
                        'reference_number' => 'REF-' . rand(100000, 999999),
                        'status'           => 'pending',
                        'created_at'       => $enrolledAt,
                    ]);
                    continue; // No enrollment yet (pending approval)
                }

                if ($scenario === 2) {
                    // Failed payment
                    Payment::create([
                        'user_id'         => $student->id,
                        'course_id'       => $course->id,
                        'amount'          => $course->full_price,
                        'currency'        => 'LKR',
                        'payment_gateway' => 'bank_transfer',
                        'payment_method'  => 'bank_transfer',
                        'transaction_id'  => 'BT-' . strtoupper(Str::random(8)),
                        'status'          => 'failed',
                        'admin_notes'     => 'Receipt not clear. Please resubmit.',
                        'created_at'      => $enrolledAt,
                    ]);
                    continue;
                }

                if ($scenario === 3) {
                    // Module-by-module: pay for first 2 modules only
                    $modules = $course->modules->sortBy('order')->take(2);

                    foreach ($modules as $module) {
                        if (!$module->module_price) continue;

                        $payment = Payment::create([
                            'user_id'         => $student->id,
                            'course_id'       => $course->id,
                            'module_id'       => $module->id,
                            'amount'          => $module->module_price,
                            'currency'        => 'LKR',
                            'payment_gateway' => 'bank_transfer',
                            'payment_method'  => 'bank_transfer',
                            'transaction_id'  => 'BT-' . strtoupper(Str::random(8)),
                            'status'          => 'completed',
                            'approved_by'     => $admin?->id,
                            'approved_at'     => $enrolledAt,
                            'completed_at'    => $enrolledAt,
                            'created_at'      => $enrolledAt,
                        ]);

                        ModuleUnlock::firstOrCreate([
                            'user_id'   => $student->id,
                            'module_id' => $module->id,
                        ], [
                            'payment_id'  => $payment->id,
                            'unlocked_at' => $enrolledAt,
                        ]);
                    }

                    // Create module-by-module enrollment
                    Enrollment::firstOrCreate(
                        ['user_id' => $student->id, 'course_id' => $course->id],
                        [
                            'purchase_type' => 'module_wise',
                            'status'        => 'active',
                            'enrolled_at'   => $enrolledAt,
                        ]
                    );

                    $this->createProgressData($student, $course->modules->sortBy('order')->take(1), $enrolledAt);
                    continue;
                }

                // Scenarios 0 and 4: full course payment
                $paymentDate = $enrolledAt;
                $payment = Payment::create([
                    'user_id'         => $student->id,
                    'course_id'       => $course->id,
                    'amount'          => $course->full_price,
                    'currency'        => 'LKR',
                    'payment_gateway' => 'bank_transfer',
                    'payment_method'  => $index % 2 === 0 ? 'bank_transfer' : 'cash',
                    'transaction_id'  => 'TXN-' . strtoupper(Str::random(10)),
                    'reference_number'=> $index % 2 === 0 ? 'REF-' . rand(100000, 999999) : null,
                    'status'          => 'completed',
                    'approved_by'     => $admin?->id,
                    'approved_at'     => $paymentDate,
                    'completed_at'    => $paymentDate,
                    'created_at'      => $paymentDate,
                ]);

                // Create enrollment
                $enrollment = Enrollment::firstOrCreate(
                    ['user_id' => $student->id, 'course_id' => $course->id],
                    [
                        'purchase_type' => 'full_course',
                        'status'        => $scenario === 4 ? 'active' : 'active',
                        'enrolled_at'   => $enrolledAt,
                    ]
                );

                // Unlock all modules for full-course payment
                foreach ($course->modules as $module) {
                    ModuleUnlock::firstOrCreate([
                        'user_id'   => $student->id,
                        'module_id' => $module->id,
                    ], [
                        'payment_id'  => $payment->id,
                        'unlocked_at' => $enrolledAt,
                    ]);
                }

                // For scenario 0 (more advanced), complete some modules and add quiz attempts
                if ($scenario === 0) {
                    $numCompleted = rand(1, $course->modules->count());
                    $completedModules = $course->modules->sortBy('order')->take($numCompleted);
                    $this->createProgressData($student, $completedModules, $enrolledAt);
                }
            }
        }

        // Add a few extra pending payments for good dashboard data
        $firstFewStudents = $students->take(4);
        foreach ($firstFewStudents as $student) {
            $course = $courses->random();
            $alreadyHasPayment = Payment::where('user_id', $student->id)->where('course_id', $course->id)->exists();
            if (!$alreadyHasPayment) {
                Payment::create([
                    'user_id'          => $student->id,
                    'course_id'        => $course->id,
                    'amount'           => $course->full_price,
                    'currency'         => 'LKR',
                    'payment_gateway'  => 'bank_transfer',
                    'payment_method'   => 'bank_transfer',
                    'transaction_id'   => 'BT-' . strtoupper(Str::random(8)),
                    'reference_number' => 'REF-' . rand(100000, 999999),
                    'status'           => 'pending',
                    'created_at'       => Carbon::now()->subDays(rand(1, 5)),
                ]);
            }
        }

        $this->command->info('Payments, enrollments, module unlocks, quiz attempts, and completions seeded.');
    }

    private function createProgressData(User $student, $modules, Carbon $enrolledAt): void
    {
        foreach ($modules as $module) {
            $completedAt = (clone $enrolledAt)->addDays(rand(1, 14));

            // Module completion
            ModuleCompletion::firstOrCreate([
                'user_id'   => $student->id,
                'module_id' => $module->id,
            ], [
                'completed_at' => $completedAt,
            ]);

            // Quiz attempt for modules with questions
            $questionCount = $module->questions()->where('type', 'mcq')->count();
            if ($questionCount > 0) {
                $score = rand(50, 100);
                QuizAttempt::create([
                    'user_id'         => $student->id,
                    'module_id'       => $module->id,
                    'total_questions' => $questionCount,
                    'correct_answers' => (int) round($questionCount * $score / 100),
                    'score'           => $score,
                    'answers'         => [],
                    'completed_at'    => $completedAt,
                    'created_at'      => $completedAt,
                ]);
            }

            // Theory exam submission
            $theoryExam = $module->theoryExams()->first();
            if ($theoryExam) {
                $examScore = rand(60, 100);
                TheoryExamSubmission::firstOrCreate([
                    'theory_exam_id' => $theoryExam->id,
                    'user_id'        => $student->id,
                ], [
                    'submission_file_path' => 'dummy/submission_placeholder.pdf',
                    'marks_obtained'       => $examScore,
                    'status'               => 'graded',
                    'feedback'             => $examScore >= 80 ? 'Excellent work! Keep it up.' : 'Good effort. Review the highlighted areas.',
                ]);
            }
        }
    }
}
