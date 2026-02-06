<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructor = User::where('role', 'admin')->first();

        $courses = [
            [
                'title' => 'Professional Makeup Artistry',
                'description' => 'Master the art of professional makeup application with comprehensive training in bridal makeup, fashion makeup, and special effects. Learn color theory, face contouring, and advanced techniques used by industry professionals.',
                'instructor_id' => $instructor->id,
                'full_price' => 45000.00,
                'is_published' => true,
            ],
            [
                'title' => 'Advanced Hair Styling & Cutting',
                'description' => 'Complete hairstyling course covering cutting techniques, styling, coloring, and hair treatments. Learn both traditional and modern approaches to hairdressing with hands-on practice.',
                'instructor_id' => $instructor->id,
                'full_price' => 50000.00,
                'is_published' => true,
            ],
            [
                'title' => 'Nail Technology & Nail Art',
                'description' => 'Comprehensive nail care program including manicure, pedicure, gel nails, acrylic extensions, and creative nail art designs. Perfect for aspiring nail technicians.',
                'instructor_id' => $instructor->id,
                'full_price' => 35000.00,
                'is_published' => true,
            ],
            [
                'title' => 'Skincare & Facial Treatments',
                'description' => 'Learn professional skincare techniques, facial treatments, skin analysis, and product knowledge. Understand different skin types and appropriate treatment protocols.',
                'instructor_id' => $instructor->id,
                'full_price' => 40000.00,
                'is_published' => true,
            ],
            [
                'title' => 'Bridal Makeup & Hairstyling',
                'description' => 'Specialized course focused on bridal makeup and hairstyling techniques. Learn to create stunning bridal looks for different cultures and preferences.',
                'instructor_id' => $instructor->id,
                'full_price' => 55000.00,
                'is_published' => true,
            ],
            [
                'title' => 'Spa Therapies & Massage',
                'description' => 'Introduction to spa therapies including various massage techniques, aromatherapy, body treatments, and relaxation therapies.',
                'instructor_id' => $instructor->id,
                'full_price' => 48000.00,
                'is_published' => true,
            ],
        ];

        foreach ($courses as $courseData) {
            Course::create($courseData);
        }
    }
}
