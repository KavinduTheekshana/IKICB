<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $questions = DB::table('questions')
            ->whereNotNull('mcq_options')
            ->where('type', 'mcq')
            ->get();

        foreach ($questions as $question) {
            $options = json_decode($question->mcq_options, true);
            if (!is_array($options)) {
                continue;
            }

            $correctAnswerText = $question->correct_answer;
            $newCorrectAnswerId = null;
            $newOptions = [];

            foreach ($options as $opt) {
                if (!is_array($opt)) {
                    continue;
                }
                $optText = $opt['option'] ?? '';
                // Preserve existing id if already set, otherwise generate new one
                $optId = !empty($opt['id']) ? $opt['id'] : (string) Str::uuid();

                $newOptions[] = ['id' => $optId, 'option' => $optText];

                if ($optText === $correctAnswerText) {
                    $newCorrectAnswerId = $optId;
                }
            }

            DB::table('questions')->where('id', $question->id)->update([
                'mcq_options'    => json_encode($newOptions),
                'correct_answer' => $newCorrectAnswerId ?? $question->correct_answer,
            ]);
        }
    }

    public function down(): void
    {
        // Reverse: convert correct_answer from ID back to text
        $questions = DB::table('questions')
            ->whereNotNull('mcq_options')
            ->where('type', 'mcq')
            ->get();

        foreach ($questions as $question) {
            $options = json_decode($question->mcq_options, true);
            if (!is_array($options)) {
                continue;
            }

            // Build id → text map
            $idToText = [];
            foreach ($options as $opt) {
                if (is_array($opt) && !empty($opt['id'])) {
                    $idToText[$opt['id']] = $opt['option'] ?? '';
                }
            }

            $correctAnswerText = $idToText[$question->correct_answer] ?? $question->correct_answer;

            // Strip ids from options
            $strippedOptions = array_map(fn($opt) => ['option' => $opt['option'] ?? ''], $options);

            DB::table('questions')->where('id', $question->id)->update([
                'mcq_options'    => json_encode($strippedOptions),
                'correct_answer' => $correctAnswerText,
            ]);
        }
    }
};
