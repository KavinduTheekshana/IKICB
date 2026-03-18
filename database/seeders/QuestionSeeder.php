<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Question;
use App\Models\QuestionCategory;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $makeupCat   = QuestionCategory::where('name', 'Makeup Artistry')->first();
        $hairCat     = QuestionCategory::where('name', 'Hair Styling')->first();
        $nailCat     = QuestionCategory::where('name', 'Nail Technology')->first();
        $skinCat     = QuestionCategory::where('name', 'Skincare & Facials')->first();
        $bridalCat   = QuestionCategory::where('name', 'Bridal Services')->first();
        $spaCat      = QuestionCategory::where('name', 'Spa & Massage')->first();
        $safetyCat   = QuestionCategory::where('name', 'Health & Safety')->first();

        $questions = [
            // ── Makeup Artistry MCQs ──────────────────────────────────────────
            [
                'question_category_id' => $makeupCat->id,
                'type' => 'mcq',
                'question' => 'Which type of brush is best used for applying powder foundation?',
                'mcq_options' => ['Flat foundation brush', 'Kabuki brush', 'Fan brush', 'Angled brush'],
                'correct_answer' => 'Kabuki brush',
                'marks' => 2,
            ],
            [
                'question_category_id' => $makeupCat->id,
                'type' => 'mcq',
                'question' => 'What is the purpose of a primer in makeup application?',
                'mcq_options' => ['Add color', 'Create a smooth base and extend makeup wear', 'Moisturise the skin', 'Set the makeup'],
                'correct_answer' => 'Create a smooth base and extend makeup wear',
                'marks' => 2,
            ],
            [
                'question_category_id' => $makeupCat->id,
                'type' => 'mcq',
                'question' => 'Which color corrector is used to neutralize dark under-eye circles?',
                'mcq_options' => ['Green', 'Yellow', 'Peach / Orange', 'Purple'],
                'correct_answer' => 'Peach / Orange',
                'marks' => 3,
            ],
            [
                'question_category_id' => $makeupCat->id,
                'type' => 'mcq',
                'question' => 'Contouring is used to:',
                'mcq_options' => ['Brighten the face', 'Add color', 'Create shadows to define facial structure', 'Moisturize'],
                'correct_answer' => 'Create shadows to define facial structure',
                'marks' => 2,
            ],
            [
                'question_category_id' => $makeupCat->id,
                'type' => 'mcq',
                'question' => 'What undertone does a person with pinkish skin typically have?',
                'mcq_options' => ['Warm', 'Cool', 'Neutral', 'Golden'],
                'correct_answer' => 'Cool',
                'marks' => 2,
            ],
            [
                'question_category_id' => $makeupCat->id,
                'type' => 'mcq',
                'question' => 'Which product is applied last in a makeup routine to set and lock makeup?',
                'mcq_options' => ['Primer', 'Foundation', 'Setting spray or powder', 'Concealer'],
                'correct_answer' => 'Setting spray or powder',
                'marks' => 2,
            ],
            [
                'question_category_id' => $makeupCat->id,
                'type' => 'theory',
                'question' => 'Explain the steps involved in a professional bridal makeup application.',
                'mcq_options' => null,
                'correct_answer' => null,
                'marks' => 10,
            ],

            // ── Hair Styling MCQs ─────────────────────────────────────────────
            [
                'question_category_id' => $hairCat->id,
                'type' => 'mcq',
                'question' => 'Which scissors technique involves cutting into the hair to remove bulk?',
                'mcq_options' => ['Blunt cutting', 'Point cutting', 'Texturizing / Thinning', 'Layering'],
                'correct_answer' => 'Texturizing / Thinning',
                'marks' => 2,
            ],
            [
                'question_category_id' => $hairCat->id,
                'type' => 'mcq',
                'question' => 'What does the term "balayage" refer to?',
                'mcq_options' => [
                    'A type of hair cut',
                    'A freehand hair coloring technique creating a sun-kissed effect',
                    'A hair straightening method',
                    'A deep conditioning treatment',
                ],
                'correct_answer' => 'A freehand hair coloring technique creating a sun-kissed effect',
                'marks' => 2,
            ],
            [
                'question_category_id' => $hairCat->id,
                'type' => 'mcq',
                'question' => 'What is the primary purpose of a toner in hair coloring?',
                'mcq_options' => ['Darken the hair', 'Neutralize unwanted warm tones after bleaching', 'Add moisture', 'Thicken the hair'],
                'correct_answer' => 'Neutralize unwanted warm tones after bleaching',
                'marks' => 3,
            ],
            [
                'question_category_id' => $hairCat->id,
                'type' => 'mcq',
                'question' => 'Which hair type is best suited for a blunt cut?',
                'mcq_options' => ['Very curly hair', 'Straight to slightly wavy hair', 'Coarse thick hair', 'Fine hair'],
                'correct_answer' => 'Straight to slightly wavy hair',
                'marks' => 2,
            ],
            [
                'question_category_id' => $hairCat->id,
                'type' => 'mcq',
                'question' => 'What is the correct developer volume for a subtle lift of 1-2 levels?',
                'mcq_options' => ['10 vol', '20 vol', '30 vol', '40 vol'],
                'correct_answer' => '20 vol',
                'marks' => 3,
            ],
            [
                'question_category_id' => $hairCat->id,
                'type' => 'theory',
                'question' => 'Describe the process and precautions for applying a keratin hair treatment.',
                'mcq_options' => null,
                'correct_answer' => null,
                'marks' => 10,
            ],

            // ── Nail Technology MCQs ──────────────────────────────────────────
            [
                'question_category_id' => $nailCat->id,
                'type' => 'mcq',
                'question' => 'What is the name of the skin that grows over the base of the nail plate?',
                'mcq_options' => ['Nail bed', 'Cuticle', 'Lunula', 'Hyponychium'],
                'correct_answer' => 'Cuticle',
                'marks' => 2,
            ],
            [
                'question_category_id' => $nailCat->id,
                'type' => 'mcq',
                'question' => 'Which lamp is required to cure gel nail polish?',
                'mcq_options' => ['Infrared lamp', 'UV or LED lamp', 'Halogen lamp', 'Fluorescent lamp'],
                'correct_answer' => 'UV or LED lamp',
                'marks' => 2,
            ],
            [
                'question_category_id' => $nailCat->id,
                'type' => 'mcq',
                'question' => 'What is the correct way to remove acrylic nails?',
                'mcq_options' => ['Peel them off', 'File them off completely', 'Soak in acetone and gently push off', 'Cut with nail clippers'],
                'correct_answer' => 'Soak in acetone and gently push off',
                'marks' => 3,
            ],
            [
                'question_category_id' => $nailCat->id,
                'type' => 'mcq',
                'question' => 'Which nail shape is known for being the most natural-looking and low-maintenance?',
                'mcq_options' => ['Almond', 'Coffin', 'Square', 'Oval'],
                'correct_answer' => 'Oval',
                'marks' => 2,
            ],
            [
                'question_category_id' => $nailCat->id,
                'type' => 'theory',
                'question' => 'What are the key differences between gel nails and acrylic nails? When would you recommend each to a client?',
                'mcq_options' => null,
                'correct_answer' => null,
                'marks' => 10,
            ],

            // ── Skincare & Facials MCQs ───────────────────────────────────────
            [
                'question_category_id' => $skinCat->id,
                'type' => 'mcq',
                'question' => 'Which skin type is characterized by an overproduction of sebum?',
                'mcq_options' => ['Dry skin', 'Oily skin', 'Sensitive skin', 'Normal skin'],
                'correct_answer' => 'Oily skin',
                'marks' => 2,
            ],
            [
                'question_category_id' => $skinCat->id,
                'type' => 'mcq',
                'question' => 'What is the Fitzpatrick scale used for?',
                'mcq_options' => [
                    'Measuring skin hydration',
                    'Classifying skin type by reaction to UV exposure',
                    'Identifying skin infections',
                    'Measuring sebum production',
                ],
                'correct_answer' => 'Classifying skin type by reaction to UV exposure',
                'marks' => 3,
            ],
            [
                'question_category_id' => $skinCat->id,
                'type' => 'mcq',
                'question' => 'Which ingredient is commonly used to treat hyperpigmentation?',
                'mcq_options' => ['Retinol', 'Vitamin C', 'Hyaluronic acid', 'Benzoyl peroxide'],
                'correct_answer' => 'Vitamin C',
                'marks' => 2,
            ],
            [
                'question_category_id' => $skinCat->id,
                'type' => 'mcq',
                'question' => 'What is the recommended SPF for daily sun protection?',
                'mcq_options' => ['SPF 10', 'SPF 15', 'SPF 30 or higher', 'SPF 5'],
                'correct_answer' => 'SPF 30 or higher',
                'marks' => 2,
            ],
            [
                'question_category_id' => $skinCat->id,
                'type' => 'theory',
                'question' => 'Explain how you would customize a facial treatment for a client with acne-prone skin.',
                'mcq_options' => null,
                'correct_answer' => null,
                'marks' => 10,
            ],

            // ── Bridal Services MCQs ──────────────────────────────────────────
            [
                'question_category_id' => $bridalCat->id,
                'type' => 'mcq',
                'question' => 'When should a bridal trial be conducted?',
                'mcq_options' => ['On the wedding day', '1-2 weeks before the wedding', '3-6 months before the wedding', 'A day before'],
                'correct_answer' => '3-6 months before the wedding',
                'marks' => 2,
            ],
            [
                'question_category_id' => $bridalCat->id,
                'type' => 'mcq',
                'question' => 'What type of foundation is most suitable for long-lasting bridal makeup?',
                'mcq_options' => ['Water-based foundation', 'Full-coverage matte foundation', 'Tinted moisturizer', 'BB cream'],
                'correct_answer' => 'Full-coverage matte foundation',
                'marks' => 2,
            ],
            [
                'question_category_id' => $bridalCat->id,
                'type' => 'mcq',
                'question' => 'Which hairstyle is most popular for traditional Sri Lankan brides?',
                'mcq_options' => ['Beach waves', 'Sleek ponytail', 'Elaborate updo with accessories', 'Bob cut'],
                'correct_answer' => 'Elaborate updo with accessories',
                'marks' => 2,
            ],

            // ── Spa & Massage MCQs ────────────────────────────────────────────
            [
                'question_category_id' => $spaCat->id,
                'type' => 'mcq',
                'question' => 'Which massage technique uses long gliding strokes?',
                'mcq_options' => ['Petrissage', 'Effleurage', 'Tapotement', 'Friction'],
                'correct_answer' => 'Effleurage',
                'marks' => 2,
            ],
            [
                'question_category_id' => $spaCat->id,
                'type' => 'mcq',
                'question' => 'What is the ideal temperature for hot stones used in hot stone massage?',
                'mcq_options' => ['30-40°C', '45-55°C', '60-70°C', '75-85°C'],
                'correct_answer' => '45-55°C',
                'marks' => 3,
            ],
            [
                'question_category_id' => $spaCat->id,
                'type' => 'mcq',
                'question' => 'Which essential oil is most commonly used for relaxation in aromatherapy?',
                'mcq_options' => ['Peppermint', 'Lavender', 'Eucalyptus', 'Tea tree'],
                'correct_answer' => 'Lavender',
                'marks' => 2,
            ],
            [
                'question_category_id' => $spaCat->id,
                'type' => 'theory',
                'question' => 'Describe the contraindications for providing a full body massage and why they are important.',
                'mcq_options' => null,
                'correct_answer' => null,
                'marks' => 10,
            ],

            // ── Health & Safety MCQs ──────────────────────────────────────────
            [
                'question_category_id' => $safetyCat->id,
                'type' => 'mcq',
                'question' => 'How often should makeup brushes used on clients be sanitized?',
                'mcq_options' => ['Once a week', 'Once a month', 'After every client', 'Once a day'],
                'correct_answer' => 'After every client',
                'marks' => 2,
            ],
            [
                'question_category_id' => $safetyCat->id,
                'type' => 'mcq',
                'question' => 'What does COSHH stand for?',
                'mcq_options' => [
                    'Control of Substances Hazardous to Health',
                    'Care of Safety and Health Hazards',
                    'Control of Safety, Hygiene and Health',
                    'Chemical and Organic Substances Health Handbook',
                ],
                'correct_answer' => 'Control of Substances Hazardous to Health',
                'marks' => 3,
            ],
            [
                'question_category_id' => $safetyCat->id,
                'type' => 'mcq',
                'question' => 'Which action should be taken before performing any beauty treatment on a new client?',
                'mcq_options' => ['Start the treatment immediately', 'Conduct a consultation and patch test', 'Apply products directly', 'Ask them to sign a waiver only'],
                'correct_answer' => 'Conduct a consultation and patch test',
                'marks' => 2,
            ],
        ];

        $createdQuestions = [];
        foreach ($questions as $q) {
            $question = Question::create($q);
            $createdQuestions[] = $question;
        }

        // Attach MCQ questions to relevant modules
        $this->attachQuestionsToModules($createdQuestions);

        $this->command->info(count($questions) . ' questions created and attached to modules.');
    }

    private function attachQuestionsToModules(array $questions): void
    {
        $keywordMap = [
            'makeup'      => ['makeup', 'foundation', 'contouring', 'bridal makeup', 'primer', 'brush'],
            'hair'        => ['hair', 'cutting', 'coloring', 'colour', 'balayage', 'styling', 'keratin'],
            'nail'        => ['nail', 'gel', 'acrylic', 'manicure', 'pedicure'],
            'skin'        => ['skin', 'facial', 'skincare', 'acne', 'sebum', 'spf', 'fitzpatrick'],
            'bridal'      => ['bridal', 'bride', 'wedding'],
            'spa'         => ['spa', 'massage', 'aromatherapy', 'essential oil', 'stone'],
            'safety'      => ['sanitiz', 'coshh', 'hygiene', 'safety', 'consultation'],
        ];

        $modules = Module::with('course')->get();

        foreach ($questions as $question) {
            $order = 1;
            foreach ($modules as $module) {
                $moduleTitle = strtolower($module->title . ' ' . ($module->course->title ?? ''));

                foreach ($keywordMap as $group => $keywords) {
                    $questionText = strtolower($question->question);

                    // Check if question belongs to this group
                    $matchesQuestion = collect($keywords)->contains(fn ($kw) => str_contains($questionText, $kw));

                    // Check if module title matches this group
                    $matchesModule = collect($keywords)->contains(fn ($kw) => str_contains($moduleTitle, $kw));

                    if ($matchesQuestion && $matchesModule && $question->type === 'mcq') {
                        $question->modules()->syncWithoutDetaching([$module->id => ['order' => $order]]);
                        $order++;
                    }
                }
            }
        }
    }
}
