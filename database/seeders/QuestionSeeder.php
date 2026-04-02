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

        // Helper: build options array with ids and return [options, correct_answer_id]
        $makeOptions = function (array $texts, string $correctText): array {
            $options = array_map(fn($t) => ['id' => 'opt_' . md5($t), 'option' => $t], $texts);
            $correctId = null;
            foreach ($options as $opt) {
                if ($opt['option'] === $correctText) {
                    $correctId = $opt['id'];
                    break;
                }
            }
            return [$options, $correctId];
        };

        $questions = [];

        // ── Makeup Artistry MCQs ──────────────────────────────────────────
        [$opts, $correct] = $makeOptions(
            ['Flat foundation brush', 'Kabuki brush', 'Fan brush', 'Angled brush'],
            'Kabuki brush'
        );
        $questions[] = [
            'question_category_id' => $makeupCat->id,
            'type' => 'mcq',
            'question' => 'Which type of brush is best used for applying powder foundation?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        [$opts, $correct] = $makeOptions(
            ['Add color', 'Create a smooth base and extend makeup wear', 'Moisturise the skin', 'Set the makeup'],
            'Create a smooth base and extend makeup wear'
        );
        $questions[] = [
            'question_category_id' => $makeupCat->id,
            'type' => 'mcq',
            'question' => 'What is the purpose of a primer in makeup application?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        [$opts, $correct] = $makeOptions(
            ['Green', 'Yellow', 'Peach / Orange', 'Purple'],
            'Peach / Orange'
        );
        $questions[] = [
            'question_category_id' => $makeupCat->id,
            'type' => 'mcq',
            'question' => 'Which color corrector is used to neutralize dark under-eye circles?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 3,
        ];

        [$opts, $correct] = $makeOptions(
            ['Brighten the face', 'Add color', 'Create shadows to define facial structure', 'Moisturize'],
            'Create shadows to define facial structure'
        );
        $questions[] = [
            'question_category_id' => $makeupCat->id,
            'type' => 'mcq',
            'question' => 'Contouring is used to:',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        [$opts, $correct] = $makeOptions(
            ['Warm', 'Cool', 'Neutral', 'Golden'],
            'Cool'
        );
        $questions[] = [
            'question_category_id' => $makeupCat->id,
            'type' => 'mcq',
            'question' => 'What undertone does a person with pinkish skin typically have?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        [$opts, $correct] = $makeOptions(
            ['Primer', 'Foundation', 'Setting spray or powder', 'Concealer'],
            'Setting spray or powder'
        );
        $questions[] = [
            'question_category_id' => $makeupCat->id,
            'type' => 'mcq',
            'question' => 'Which product is applied last in a makeup routine to set and lock makeup?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        $questions[] = [
            'question_category_id' => $makeupCat->id,
            'type' => 'theory',
            'question' => 'Explain the steps involved in a professional bridal makeup application.',
            'mcq_options' => null,
            'correct_answer' => null,
            'marks' => 10,
        ];

        // ── Hair Styling MCQs ─────────────────────────────────────────────
        [$opts, $correct] = $makeOptions(
            ['Blunt cutting', 'Point cutting', 'Texturizing / Thinning', 'Layering'],
            'Texturizing / Thinning'
        );
        $questions[] = [
            'question_category_id' => $hairCat->id,
            'type' => 'mcq',
            'question' => 'Which scissors technique involves cutting into the hair to remove bulk?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        [$opts, $correct] = $makeOptions(
            ['A type of hair cut', 'A freehand hair coloring technique creating a sun-kissed effect', 'A hair straightening method', 'A deep conditioning treatment'],
            'A freehand hair coloring technique creating a sun-kissed effect'
        );
        $questions[] = [
            'question_category_id' => $hairCat->id,
            'type' => 'mcq',
            'question' => 'What does the term "balayage" refer to?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        [$opts, $correct] = $makeOptions(
            ['Darken the hair', 'Neutralize unwanted warm tones after bleaching', 'Add moisture', 'Thicken the hair'],
            'Neutralize unwanted warm tones after bleaching'
        );
        $questions[] = [
            'question_category_id' => $hairCat->id,
            'type' => 'mcq',
            'question' => 'What is the primary purpose of a toner in hair coloring?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 3,
        ];

        [$opts, $correct] = $makeOptions(
            ['Very curly hair', 'Straight to slightly wavy hair', 'Coarse thick hair', 'Fine hair'],
            'Straight to slightly wavy hair'
        );
        $questions[] = [
            'question_category_id' => $hairCat->id,
            'type' => 'mcq',
            'question' => 'Which hair type is best suited for a blunt cut?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        [$opts, $correct] = $makeOptions(
            ['10 vol', '20 vol', '30 vol', '40 vol'],
            '20 vol'
        );
        $questions[] = [
            'question_category_id' => $hairCat->id,
            'type' => 'mcq',
            'question' => 'What is the correct developer volume for a subtle lift of 1-2 levels?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 3,
        ];

        $questions[] = [
            'question_category_id' => $hairCat->id,
            'type' => 'theory',
            'question' => 'Describe the process and precautions for applying a keratin hair treatment.',
            'mcq_options' => null,
            'correct_answer' => null,
            'marks' => 10,
        ];

        // ── Nail Technology MCQs ──────────────────────────────────────────
        [$opts, $correct] = $makeOptions(
            ['Nail bed', 'Cuticle', 'Lunula', 'Hyponychium'],
            'Cuticle'
        );
        $questions[] = [
            'question_category_id' => $nailCat->id,
            'type' => 'mcq',
            'question' => 'What is the name of the skin that grows over the base of the nail plate?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        [$opts, $correct] = $makeOptions(
            ['Infrared lamp', 'UV or LED lamp', 'Halogen lamp', 'Fluorescent lamp'],
            'UV or LED lamp'
        );
        $questions[] = [
            'question_category_id' => $nailCat->id,
            'type' => 'mcq',
            'question' => 'Which lamp is required to cure gel nail polish?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        [$opts, $correct] = $makeOptions(
            ['Peel them off', 'File them off completely', 'Soak in acetone and gently push off', 'Cut with nail clippers'],
            'Soak in acetone and gently push off'
        );
        $questions[] = [
            'question_category_id' => $nailCat->id,
            'type' => 'mcq',
            'question' => 'What is the correct way to remove acrylic nails?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 3,
        ];

        [$opts, $correct] = $makeOptions(
            ['Almond', 'Coffin', 'Square', 'Oval'],
            'Oval'
        );
        $questions[] = [
            'question_category_id' => $nailCat->id,
            'type' => 'mcq',
            'question' => 'Which nail shape is known for being the most natural-looking and low-maintenance?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        $questions[] = [
            'question_category_id' => $nailCat->id,
            'type' => 'theory',
            'question' => 'What are the key differences between gel nails and acrylic nails? When would you recommend each to a client?',
            'mcq_options' => null,
            'correct_answer' => null,
            'marks' => 10,
        ];

        // ── Skincare & Facials MCQs ───────────────────────────────────────
        [$opts, $correct] = $makeOptions(
            ['Dry skin', 'Oily skin', 'Sensitive skin', 'Normal skin'],
            'Oily skin'
        );
        $questions[] = [
            'question_category_id' => $skinCat->id,
            'type' => 'mcq',
            'question' => 'Which skin type is characterized by an overproduction of sebum?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        [$opts, $correct] = $makeOptions(
            ['Measuring skin hydration', 'Classifying skin type by reaction to UV exposure', 'Identifying skin infections', 'Measuring sebum production'],
            'Classifying skin type by reaction to UV exposure'
        );
        $questions[] = [
            'question_category_id' => $skinCat->id,
            'type' => 'mcq',
            'question' => 'What is the Fitzpatrick scale used for?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 3,
        ];

        [$opts, $correct] = $makeOptions(
            ['Retinol', 'Vitamin C', 'Hyaluronic acid', 'Benzoyl peroxide'],
            'Vitamin C'
        );
        $questions[] = [
            'question_category_id' => $skinCat->id,
            'type' => 'mcq',
            'question' => 'Which ingredient is commonly used to treat hyperpigmentation?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        [$opts, $correct] = $makeOptions(
            ['SPF 10', 'SPF 15', 'SPF 30 or higher', 'SPF 5'],
            'SPF 30 or higher'
        );
        $questions[] = [
            'question_category_id' => $skinCat->id,
            'type' => 'mcq',
            'question' => 'What is the recommended SPF for daily sun protection?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        $questions[] = [
            'question_category_id' => $skinCat->id,
            'type' => 'theory',
            'question' => 'Explain how you would customize a facial treatment for a client with acne-prone skin.',
            'mcq_options' => null,
            'correct_answer' => null,
            'marks' => 10,
        ];

        // ── Bridal Services MCQs ──────────────────────────────────────────
        [$opts, $correct] = $makeOptions(
            ['On the wedding day', '1-2 weeks before the wedding', '3-6 months before the wedding', 'A day before'],
            '3-6 months before the wedding'
        );
        $questions[] = [
            'question_category_id' => $bridalCat->id,
            'type' => 'mcq',
            'question' => 'When should a bridal trial be conducted?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        [$opts, $correct] = $makeOptions(
            ['Water-based foundation', 'Full-coverage matte foundation', 'Tinted moisturizer', 'BB cream'],
            'Full-coverage matte foundation'
        );
        $questions[] = [
            'question_category_id' => $bridalCat->id,
            'type' => 'mcq',
            'question' => 'What type of foundation is most suitable for long-lasting bridal makeup?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        [$opts, $correct] = $makeOptions(
            ['Beach waves', 'Sleek ponytail', 'Elaborate updo with accessories', 'Bob cut'],
            'Elaborate updo with accessories'
        );
        $questions[] = [
            'question_category_id' => $bridalCat->id,
            'type' => 'mcq',
            'question' => 'Which hairstyle is most popular for traditional Sri Lankan brides?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        // ── Spa & Massage MCQs ────────────────────────────────────────────
        [$opts, $correct] = $makeOptions(
            ['Petrissage', 'Effleurage', 'Tapotement', 'Friction'],
            'Effleurage'
        );
        $questions[] = [
            'question_category_id' => $spaCat->id,
            'type' => 'mcq',
            'question' => 'Which massage technique uses long gliding strokes?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        [$opts, $correct] = $makeOptions(
            ['30-40°C', '45-55°C', '60-70°C', '75-85°C'],
            '45-55°C'
        );
        $questions[] = [
            'question_category_id' => $spaCat->id,
            'type' => 'mcq',
            'question' => 'What is the ideal temperature for hot stones used in hot stone massage?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 3,
        ];

        [$opts, $correct] = $makeOptions(
            ['Peppermint', 'Lavender', 'Eucalyptus', 'Tea tree'],
            'Lavender'
        );
        $questions[] = [
            'question_category_id' => $spaCat->id,
            'type' => 'mcq',
            'question' => 'Which essential oil is most commonly used for relaxation in aromatherapy?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        $questions[] = [
            'question_category_id' => $spaCat->id,
            'type' => 'theory',
            'question' => 'Describe the contraindications for providing a full body massage and why they are important.',
            'mcq_options' => null,
            'correct_answer' => null,
            'marks' => 10,
        ];

        // ── Health & Safety MCQs ──────────────────────────────────────────
        [$opts, $correct] = $makeOptions(
            ['Once a week', 'Once a month', 'After every client', 'Once a day'],
            'After every client'
        );
        $questions[] = [
            'question_category_id' => $safetyCat->id,
            'type' => 'mcq',
            'question' => 'How often should makeup brushes used on clients be sanitized?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
        ];

        [$opts, $correct] = $makeOptions(
            ['Control of Substances Hazardous to Health', 'Care of Safety and Health Hazards', 'Control of Safety, Hygiene and Health', 'Chemical and Organic Substances Health Handbook'],
            'Control of Substances Hazardous to Health'
        );
        $questions[] = [
            'question_category_id' => $safetyCat->id,
            'type' => 'mcq',
            'question' => 'What does COSHH stand for?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 3,
        ];

        [$opts, $correct] = $makeOptions(
            ['Start the treatment immediately', 'Conduct a consultation and patch test', 'Apply products directly', 'Ask them to sign a waiver only'],
            'Conduct a consultation and patch test'
        );
        $questions[] = [
            'question_category_id' => $safetyCat->id,
            'type' => 'mcq',
            'question' => 'Which action should be taken before performing any beauty treatment on a new client?',
            'mcq_options' => $opts,
            'correct_answer' => $correct,
            'marks' => 2,
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
