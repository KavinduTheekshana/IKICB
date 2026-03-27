<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Question;
use App\Models\QuestionCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('module_questions')->truncate();
        DB::table('questions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

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
                'mcq_options' => [
                    ['option' => 'Flat foundation brush'],
                    ['option' => 'Kabuki brush'],
                    ['option' => 'Fan brush'],
                    ['option' => 'Angled brush'],
                ],
                'correct_answer' => 'Kabuki brush',
                'marks' => 2,
            ],
            [
                'question_category_id' => $makeupCat->id,
                'type' => 'mcq',
                'question' => 'What is the purpose of a primer in makeup application?',
                'mcq_options' => [
                    ['option' => 'Add color'],
                    ['option' => 'Create a smooth base and extend makeup wear'],
                    ['option' => 'Moisturise the skin'],
                    ['option' => 'Set the makeup'],
                ],
                'correct_answer' => 'Create a smooth base and extend makeup wear',
                'marks' => 2,
            ],
            [
                'question_category_id' => $makeupCat->id,
                'type' => 'mcq',
                'question' => 'Which color corrector is used to neutralize dark under-eye circles?',
                'mcq_options' => [
                    ['option' => 'Green'],
                    ['option' => 'Yellow'],
                    ['option' => 'Peach / Orange'],
                    ['option' => 'Purple'],
                ],
                'correct_answer' => 'Peach / Orange',
                'marks' => 3,
            ],
            [
                'question_category_id' => $makeupCat->id,
                'type' => 'mcq',
                'question' => 'Contouring is used to:',
                'mcq_options' => [
                    ['option' => 'Brighten the face'],
                    ['option' => 'Add color'],
                    ['option' => 'Create shadows to define facial structure'],
                    ['option' => 'Moisturize'],
                ],
                'correct_answer' => 'Create shadows to define facial structure',
                'marks' => 2,
            ],
            [
                'question_category_id' => $makeupCat->id,
                'type' => 'mcq',
                'question' => 'What undertone does a person with pinkish skin typically have?',
                'mcq_options' => [
                    ['option' => 'Warm'],
                    ['option' => 'Cool'],
                    ['option' => 'Neutral'],
                    ['option' => 'Golden'],
                ],
                'correct_answer' => 'Cool',
                'marks' => 2,
            ],
            [
                'question_category_id' => $makeupCat->id,
                'type' => 'mcq',
                'question' => 'Which product is applied last in a makeup routine to set and lock makeup?',
                'mcq_options' => [
                    ['option' => 'Primer'],
                    ['option' => 'Foundation'],
                    ['option' => 'Setting spray or powder'],
                    ['option' => 'Concealer'],
                ],
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
                'mcq_options' => [
                    ['option' => 'Blunt cutting'],
                    ['option' => 'Point cutting'],
                    ['option' => 'Texturizing / Thinning'],
                    ['option' => 'Layering'],
                ],
                'correct_answer' => 'Texturizing / Thinning',
                'marks' => 2,
            ],
            [
                'question_category_id' => $hairCat->id,
                'type' => 'mcq',
                'question' => 'What does the term "balayage" refer to?',
                'mcq_options' => [
                    ['option' => 'A type of hair cut'],
                    ['option' => 'A freehand hair coloring technique creating a sun-kissed effect'],
                    ['option' => 'A hair straightening method'],
                    ['option' => 'A deep conditioning treatment'],
                ],
                'correct_answer' => 'A freehand hair coloring technique creating a sun-kissed effect',
                'marks' => 2,
            ],
            [
                'question_category_id' => $hairCat->id,
                'type' => 'mcq',
                'question' => 'What is the primary purpose of a toner in hair coloring?',
                'mcq_options' => [
                    ['option' => 'Darken the hair'],
                    ['option' => 'Neutralize unwanted warm tones after bleaching'],
                    ['option' => 'Add moisture'],
                    ['option' => 'Thicken the hair'],
                ],
                'correct_answer' => 'Neutralize unwanted warm tones after bleaching',
                'marks' => 3,
            ],
            [
                'question_category_id' => $hairCat->id,
                'type' => 'mcq',
                'question' => 'Which hair type is best suited for a blunt cut?',
                'mcq_options' => [
                    ['option' => 'Very curly hair'],
                    ['option' => 'Straight to slightly wavy hair'],
                    ['option' => 'Coarse thick hair'],
                    ['option' => 'Fine hair'],
                ],
                'correct_answer' => 'Straight to slightly wavy hair',
                'marks' => 2,
            ],
            [
                'question_category_id' => $hairCat->id,
                'type' => 'mcq',
                'question' => 'What is the correct developer volume for a subtle lift of 1-2 levels?',
                'mcq_options' => [
                    ['option' => '10 vol'],
                    ['option' => '20 vol'],
                    ['option' => '30 vol'],
                    ['option' => '40 vol'],
                ],
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
                'mcq_options' => [
                    ['option' => 'Nail bed'],
                    ['option' => 'Cuticle'],
                    ['option' => 'Lunula'],
                    ['option' => 'Hyponychium'],
                ],
                'correct_answer' => 'Cuticle',
                'marks' => 2,
            ],
            [
                'question_category_id' => $nailCat->id,
                'type' => 'mcq',
                'question' => 'Which lamp is required to cure gel nail polish?',
                'mcq_options' => [
                    ['option' => 'Infrared lamp'],
                    ['option' => 'UV or LED lamp'],
                    ['option' => 'Halogen lamp'],
                    ['option' => 'Fluorescent lamp'],
                ],
                'correct_answer' => 'UV or LED lamp',
                'marks' => 2,
            ],
            [
                'question_category_id' => $nailCat->id,
                'type' => 'mcq',
                'question' => 'What is the correct way to remove acrylic nails?',
                'mcq_options' => [
                    ['option' => 'Peel them off'],
                    ['option' => 'File them off completely'],
                    ['option' => 'Soak in acetone and gently push off'],
                    ['option' => 'Cut with nail clippers'],
                ],
                'correct_answer' => 'Soak in acetone and gently push off',
                'marks' => 3,
            ],
            [
                'question_category_id' => $nailCat->id,
                'type' => 'mcq',
                'question' => 'Which nail shape is known for being the most natural-looking and low-maintenance?',
                'mcq_options' => [
                    ['option' => 'Almond'],
                    ['option' => 'Coffin'],
                    ['option' => 'Square'],
                    ['option' => 'Oval'],
                ],
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
                'mcq_options' => [
                    ['option' => 'Dry skin'],
                    ['option' => 'Oily skin'],
                    ['option' => 'Sensitive skin'],
                    ['option' => 'Normal skin'],
                ],
                'correct_answer' => 'Oily skin',
                'marks' => 2,
            ],
            [
                'question_category_id' => $skinCat->id,
                'type' => 'mcq',
                'question' => 'What is the Fitzpatrick scale used for?',
                'mcq_options' => [
                    ['option' => 'Measuring skin hydration'],
                    ['option' => 'Classifying skin type by reaction to UV exposure'],
                    ['option' => 'Identifying skin infections'],
                    ['option' => 'Measuring sebum production'],
                ],
                'correct_answer' => 'Classifying skin type by reaction to UV exposure',
                'marks' => 3,
            ],
            [
                'question_category_id' => $skinCat->id,
                'type' => 'mcq',
                'question' => 'Which ingredient is commonly used to treat hyperpigmentation?',
                'mcq_options' => [
                    ['option' => 'Retinol'],
                    ['option' => 'Vitamin C'],
                    ['option' => 'Hyaluronic acid'],
                    ['option' => 'Benzoyl peroxide'],
                ],
                'correct_answer' => 'Vitamin C',
                'marks' => 2,
            ],
            [
                'question_category_id' => $skinCat->id,
                'type' => 'mcq',
                'question' => 'What is the recommended SPF for daily sun protection?',
                'mcq_options' => [
                    ['option' => 'SPF 10'],
                    ['option' => 'SPF 15'],
                    ['option' => 'SPF 30 or higher'],
                    ['option' => 'SPF 5'],
                ],
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
                'mcq_options' => [
                    ['option' => 'On the wedding day'],
                    ['option' => '1-2 weeks before the wedding'],
                    ['option' => '3-6 months before the wedding'],
                    ['option' => 'A day before'],
                ],
                'correct_answer' => '3-6 months before the wedding',
                'marks' => 2,
            ],
            [
                'question_category_id' => $bridalCat->id,
                'type' => 'mcq',
                'question' => 'What type of foundation is most suitable for long-lasting bridal makeup?',
                'mcq_options' => [
                    ['option' => 'Water-based foundation'],
                    ['option' => 'Full-coverage matte foundation'],
                    ['option' => 'Tinted moisturizer'],
                    ['option' => 'BB cream'],
                ],
                'correct_answer' => 'Full-coverage matte foundation',
                'marks' => 2,
            ],
            [
                'question_category_id' => $bridalCat->id,
                'type' => 'mcq',
                'question' => 'Which hairstyle is most popular for traditional Sri Lankan brides?',
                'mcq_options' => [
                    ['option' => 'Beach waves'],
                    ['option' => 'Sleek ponytail'],
                    ['option' => 'Elaborate updo with accessories'],
                    ['option' => 'Bob cut'],
                ],
                'correct_answer' => 'Elaborate updo with accessories',
                'marks' => 2,
            ],

            // ── Spa & Massage MCQs ────────────────────────────────────────────
            [
                'question_category_id' => $spaCat->id,
                'type' => 'mcq',
                'question' => 'Which massage technique uses long gliding strokes?',
                'mcq_options' => [
                    ['option' => 'Petrissage'],
                    ['option' => 'Effleurage'],
                    ['option' => 'Tapotement'],
                    ['option' => 'Friction'],
                ],
                'correct_answer' => 'Effleurage',
                'marks' => 2,
            ],
            [
                'question_category_id' => $spaCat->id,
                'type' => 'mcq',
                'question' => 'What is the ideal temperature for hot stones used in hot stone massage?',
                'mcq_options' => [
                    ['option' => '30-40°C'],
                    ['option' => '45-55°C'],
                    ['option' => '60-70°C'],
                    ['option' => '75-85°C'],
                ],
                'correct_answer' => '45-55°C',
                'marks' => 3,
            ],
            [
                'question_category_id' => $spaCat->id,
                'type' => 'mcq',
                'question' => 'Which essential oil is most commonly used for relaxation in aromatherapy?',
                'mcq_options' => [
                    ['option' => 'Peppermint'],
                    ['option' => 'Lavender'],
                    ['option' => 'Eucalyptus'],
                    ['option' => 'Tea tree'],
                ],
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
                'mcq_options' => [
                    ['option' => 'Once a week'],
                    ['option' => 'Once a month'],
                    ['option' => 'After every client'],
                    ['option' => 'Once a day'],
                ],
                'correct_answer' => 'After every client',
                'marks' => 2,
            ],
            [
                'question_category_id' => $safetyCat->id,
                'type' => 'mcq',
                'question' => 'What does COSHH stand for?',
                'mcq_options' => [
                    ['option' => 'Control of Substances Hazardous to Health'],
                    ['option' => 'Care of Safety and Health Hazards'],
                    ['option' => 'Control of Safety, Hygiene and Health'],
                    ['option' => 'Chemical and Organic Substances Health Handbook'],
                ],
                'correct_answer' => 'Control of Substances Hazardous to Health',
                'marks' => 3,
            ],
            [
                'question_category_id' => $safetyCat->id,
                'type' => 'mcq',
                'question' => 'Which action should be taken before performing any beauty treatment on a new client?',
                'mcq_options' => [
                    ['option' => 'Start the treatment immediately'],
                    ['option' => 'Conduct a consultation and patch test'],
                    ['option' => 'Apply products directly'],
                    ['option' => 'Ask them to sign a waiver only'],
                ],
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

                    $matchesQuestion = collect($keywords)->contains(fn ($kw) => str_contains($questionText, $kw));
                    $matchesModule   = collect($keywords)->contains(fn ($kw) => str_contains($moduleTitle, $kw));

                    if ($matchesQuestion && $matchesModule && $question->type === 'mcq') {
                        $question->modules()->syncWithoutDetaching([$module->id => ['order' => $order]]);
                        $order++;
                    }
                }
            }
        }
    }
}
