<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();

        $modulesByCourse = [
            'Professional Makeup Artistry' => [
                ['title' => 'Introduction to Makeup & Tools', 'description' => 'Learn about essential makeup tools, brushes, and products. Understanding different makeup brands and their applications.', 'order' => 1, 'module_price' => 5000.00],
                ['title' => 'Skin Preparation & Foundation Techniques', 'description' => 'Master the art of skin preparation, primer application, and foundation matching for different skin tones.', 'order' => 2, 'module_price' => 6000.00],
                ['title' => 'Eye Makeup Mastery', 'description' => 'Comprehensive training in eye shadow application, eyeliner techniques, and creating various eye looks.', 'order' => 3, 'module_price' => 7000.00],
                ['title' => 'Contouring & Highlighting', 'description' => 'Learn face contouring, highlighting techniques, and face shaping for different face structures.', 'order' => 4, 'module_price' => 6500.00],
                ['title' => 'Bridal Makeup Techniques', 'description' => 'Specialized training in bridal makeup including traditional and modern bridal looks.', 'order' => 5, 'module_price' => 8000.00],
                ['title' => 'Fashion & Editorial Makeup', 'description' => 'Creative makeup techniques for fashion shows, photoshoots, and editorial work.', 'order' => 6, 'module_price' => 7500.00],
            ],
            'Advanced Hair Styling & Cutting' => [
                ['title' => 'Hair Cutting Fundamentals', 'description' => 'Basic to advanced hair cutting techniques, scissor handling, and sectioning methods.', 'order' => 1, 'module_price' => 8000.00],
                ['title' => 'Blow Drying & Styling Techniques', 'description' => 'Professional blow drying methods, brush techniques, and creating volume and texture.', 'order' => 2, 'module_price' => 6000.00],
                ['title' => 'Hair Coloring & Highlights', 'description' => 'Color theory, mixing techniques, highlights, balayage, and ombre coloring methods.', 'order' => 3, 'module_price' => 9000.00],
                ['title' => 'Bridal Hairstyling', 'description' => 'Creating elegant bridal hairstyles including buns, braids, and updos.', 'order' => 4, 'module_price' => 8500.00],
                ['title' => 'Hair Treatments & Care', 'description' => 'Professional hair treatments, keratin treatments, and hair care consultations.', 'order' => 5, 'module_price' => 7000.00],
            ],
            'Nail Technology & Nail Art' => [
                ['title' => 'Nail Anatomy & Hygiene', 'description' => 'Understanding nail structure, hygiene practices, and sanitation protocols.', 'order' => 1, 'module_price' => 4000.00],
                ['title' => 'Manicure & Pedicure Basics', 'description' => 'Professional manicure and pedicure techniques, nail shaping, and cuticle care.', 'order' => 2, 'module_price' => 5000.00],
                ['title' => 'Gel & Acrylic Extensions', 'description' => 'Application techniques for gel nails, acrylic extensions, and nail strengthening.', 'order' => 3, 'module_price' => 7000.00],
                ['title' => 'Nail Art & Design', 'description' => 'Creative nail art techniques, stamping, 3D designs, and latest nail trends.', 'order' => 4, 'module_price' => 6500.00],
                ['title' => 'Advanced Nail Techniques', 'description' => 'Nail repair, problem-solving, and advanced design techniques.', 'order' => 5, 'module_price' => 6000.00],
            ],
            'Skincare & Facial Treatments' => [
                ['title' => 'Skin Analysis & Types', 'description' => 'Learn to identify different skin types, skin conditions, and consultation techniques.', 'order' => 1, 'module_price' => 5500.00],
                ['title' => 'Basic Facial Techniques', 'description' => 'Professional facial cleansing, exfoliation, and basic facial massage techniques.', 'order' => 2, 'module_price' => 6000.00],
                ['title' => 'Advanced Facial Treatments', 'description' => 'Specialized facials, chemical peels, microdermabrasion, and anti-aging treatments.', 'order' => 3, 'module_price' => 8000.00],
                ['title' => 'Skincare Products & Ingredients', 'description' => 'Understanding skincare ingredients, product selection, and creating skincare routines.', 'order' => 4, 'module_price' => 5000.00],
                ['title' => 'Problem Skin Solutions', 'description' => 'Treating acne, hyperpigmentation, and other common skin concerns.', 'order' => 5, 'module_price' => 7500.00],
            ],
            'Bridal Makeup & Hairstyling' => [
                ['title' => 'Bridal Consultation & Planning', 'description' => 'Learn bridal consultation techniques, understanding client needs, and creating mood boards.', 'order' => 1, 'module_price' => 6000.00],
                ['title' => 'Traditional Bridal Makeup', 'description' => 'Master traditional Sri Lankan bridal makeup techniques and cultural considerations.', 'order' => 2, 'module_price' => 9000.00],
                ['title' => 'Modern Bridal Looks', 'description' => 'Contemporary bridal makeup styles, minimalist looks, and international trends.', 'order' => 3, 'module_price' => 8500.00],
                ['title' => 'Bridal Hairstyling Techniques', 'description' => 'Creating various bridal hairstyles from classic updos to modern styles.', 'order' => 4, 'module_price' => 9000.00],
                ['title' => 'Bridal Portfolio Development', 'description' => 'Building your bridal portfolio, photography basics, and marketing your services.', 'order' => 5, 'module_price' => 6500.00],
            ],
            'Spa Therapies & Massage' => [
                ['title' => 'Introduction to Spa Therapies', 'description' => 'Overview of spa industry, hygiene standards, and client care protocols.', 'order' => 1, 'module_price' => 5000.00],
                ['title' => 'Swedish Massage Techniques', 'description' => 'Learn Swedish massage strokes, pressure points, and full body massage.', 'order' => 2, 'module_price' => 8000.00],
                ['title' => 'Aromatherapy & Essential Oils', 'description' => 'Understanding essential oils, aromatherapy benefits, and safe application methods.', 'order' => 3, 'module_price' => 7000.00],
                ['title' => 'Body Treatments & Wraps', 'description' => 'Various body treatments including scrubs, wraps, and detoxification therapies.', 'order' => 4, 'module_price' => 7500.00],
                ['title' => 'Specialized Massage Therapies', 'description' => 'Hot stone massage, deep tissue techniques, and reflexology basics.', 'order' => 5, 'module_price' => 8500.00],
            ],
        ];

        foreach ($courses as $course) {
            if (isset($modulesByCourse[$course->title])) {
                foreach ($modulesByCourse[$course->title] as $moduleData) {
                    Module::create([
                        'course_id' => $course->id,
                        'title' => $moduleData['title'],
                        'description' => $moduleData['description'],
                        'order' => $moduleData['order'],
                        'module_price' => $moduleData['module_price'],
                        'video_url' => null,
                    ]);
                }
            }
        }
    }
}
