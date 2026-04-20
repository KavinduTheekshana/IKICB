<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $announcements = [
            // DANGER - Critical / urgent
            [
                'title'        => 'Urgent: Practical Exam Rescheduled',
                'content'      => 'The Level 3 Bridal Makeup practical exam scheduled for this Friday has been moved to Monday 28 April due to venue maintenance. Please confirm attendance with your lecturer.',
                'type'         => 'danger',
                'is_active'    => true,
                'published_at' => now()->subDays(1),
                'expires_at'   => now()->addDays(7),
            ],
            [
                'title'        => 'Chemical Safety Reminder — Tint Lab',
                'content'      => 'All students must wear PPE gloves and aprons when handling colour developers in the tint lab. Non-compliance will result in removal from the session.',
                'type'         => 'danger',
                'is_active'    => true,
                'published_at' => now()->subDays(2),
                'expires_at'   => now()->addDays(14),
            ],

            // WARNING - Notices
            [
                'title'        => 'Uniform Policy Enforcement Starts 1 May',
                'content'      => 'From 1 May, all students are required to be in full campus uniform including closed-toe shoes. Students not in compliance will not be permitted to enter practical rooms.',
                'type'         => 'warning',
                'is_active'    => true,
                'published_at' => now()->subDays(3),
                'expires_at'   => now()->addDays(20),
            ],
            [
                'title'        => 'Kit Inventory Check — Week 3',
                'content'      => 'Lecturers will conduct a full student kit inspection during Week 3 sessions. Ensure all required tools are clean, labelled, and present as per your programme checklist.',
                'type'         => 'warning',
                'is_active'    => true,
                'published_at' => now(),
                'expires_at'   => now()->addDays(10),
            ],
            [
                'title'        => 'Assignment Submission Deadline Reminder',
                'content'      => 'Theory portfolios for the Skin Care & Facial Treatments module are due by 30 April at 5:00 PM. Late submissions will not be accepted without a prior extension request.',
                'type'         => 'warning',
                'is_active'    => true,
                'published_at' => now()->subDays(1),
                'expires_at'   => now()->addDays(9),
            ],

            // SUCCESS - Positive updates
            [
                'title'        => 'Congratulations — NVQ Level 4 Graduates!',
                'content'      => 'We are proud to announce that 18 students have successfully completed their NVQ Level 4 in Cosmetology. Graduation ceremony details will be shared shortly.',
                'type'         => 'success',
                'is_active'    => true,
                'published_at' => now()->subDays(4),
                'expires_at'   => now()->addDays(30),
            ],
            [
                'title'        => 'Campus Bridal Showcase — Bookings Open',
                'content'      => 'Our annual Bridal Hair & Makeup Showcase is confirmed for 15 May. Student model bookings are now open. Sign up at the reception desk before 25 April.',
                'type'         => 'success',
                'is_active'    => true,
                'published_at' => now()->subDays(2),
                'expires_at'   => now()->addDays(25),
            ],

            // INFO - General
            [
                'title'        => 'New Module: Advanced Nail Artistry',
                'content'      => 'Enrollments are now open for the Advanced Nail Artistry elective module starting June intake. Limited seats available — speak to your academic advisor to register.',
                'type'         => 'info',
                'is_active'    => true,
                'published_at' => now()->subDays(5),
                'expires_at'   => now()->addDays(45),
            ],
            [
                'title'        => 'Guest Lecturer: Bridal Trends 2026',
                'content'      => 'Industry professional Ms. Dilini Perera will be conducting a guest session on South Asian Bridal Trends on 2 May at 10:00 AM in the main hall. Attendance is open to all students.',
                'type'         => 'info',
                'is_active'    => true,
                'published_at' => now(),
                'expires_at'   => now()->addDays(12),
            ],
            [
                'title'        => 'Library Hours Extended for Exam Season',
                'content'      => 'The campus resource library will remain open until 7:00 PM on weekdays throughout April and May to support students during the examination period.',
                'type'         => 'info',
                'is_active'    => true,
                'published_at' => now()->subDays(3),
                'expires_at'   => now()->addDays(40),
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}