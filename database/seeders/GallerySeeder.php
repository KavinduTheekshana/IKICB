<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing gallery records
        Gallery::truncate();

        $images = [
            [
                'category_name' => 'Graduation Ceremony',
                'image_path'    => 'gallery/frasesgraduacion_3.jpg',
            ],
            [
                'category_name' => 'Campus Life',
                'image_path'    => 'gallery/frasesgraduacion_3.webp',
            ],
            [
                'category_name' => 'Student Achievements',
                'image_path'    => 'gallery/GRAD.png',
            ],
            [
                'category_name' => 'Graduation Ceremony',
                'image_path'    => 'gallery/2021-Grad.jpg',
            ],
            [
                'category_name' => 'Campus Life',
                'image_path'    => 'gallery/istock-1095768766.jpeg',
            ],
            [
                'category_name' => 'Student Achievements',
                'image_path'    => 'gallery/ceremonia-de-graduacion.webp',
            ],
            [
                'category_name' => 'Events & Celebrations',
                'image_path'    => 'gallery/istockphoto-1150604896-612x612.jpg',
            ],
        ];

        // Copy images from public/images/temp to storage/app/public/gallery
        $sourcePath = public_path('images/temp');
        $destPath   = storage_path('app/public/gallery');

        // Create destination directory if it doesn't exist
        if (!File::exists($destPath)) {
            File::makeDirectory($destPath, 0755, true);
        }

        $fileMap = [
            'frasesgraduacion_3.jpg'              => 'frasesgraduacion_3.jpg',
            'frasesgraduacion_3.webp'             => 'frasesgraduacion_3.webp',
            'GRAD.png'                            => 'GRAD.png',
            '2021-Grad.jpg'                       => '2021-Grad.jpg',
            'istock-1095768766.jpeg'              => 'istock-1095768766.jpeg',
            'ceremonia-de-graduacion.webp'        => 'ceremonia-de-graduacion.webp',
            'istockphoto-1150604896-612x612.jpg'  => 'istockphoto-1150604896-612x612.jpg',
        ];

        foreach ($fileMap as $source => $dest) {
            $sourceFile = $sourcePath . DIRECTORY_SEPARATOR . $source;
            $destFile   = $destPath   . DIRECTORY_SEPARATOR . $dest;

            if (File::exists($sourceFile)) {
                File::copy($sourceFile, $destFile);
                $this->command->info("✅ Copied: {$source}");
            } else {
                $this->command->warn("⚠️  Not found, skipping: {$source}");
            }
        }

        // Insert records
        foreach ($images as $image) {
            Gallery::create($image);
        }

        $this->command->info('🎉 GallerySeeder completed successfully!');
    }
}