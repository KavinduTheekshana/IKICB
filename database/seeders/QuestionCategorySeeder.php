<?php

namespace Database\Seeders;

use App\Models\QuestionCategory;
use Illuminate\Database\Seeder;

class QuestionCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Makeup Artistry',    'description' => 'Questions related to makeup techniques, products, and tools'],
            ['name' => 'Hair Styling',        'description' => 'Questions on hair cutting, coloring, and styling'],
            ['name' => 'Nail Technology',     'description' => 'Questions about nail care, extensions, and nail art'],
            ['name' => 'Skincare & Facials',  'description' => 'Questions on skin types, treatments, and skincare products'],
            ['name' => 'Bridal Services',     'description' => 'Questions on bridal makeup and hairstyling'],
            ['name' => 'Spa & Massage',       'description' => 'Questions related to spa treatments and massage techniques'],
            ['name' => 'Health & Safety',     'description' => 'General hygiene, safety standards, and professional ethics'],
        ];

        foreach ($categories as $cat) {
            QuestionCategory::updateOrCreate(['name' => $cat['name']], $cat);
        }

        $this->command->info('Question categories created.');
    }
}
