<?php

namespace Database\Seeders;

use App\Models\Instructor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructors = [
            [
                'name' => 'S.G.Sewwandi Nadeeshika Gomes',
                'position' => 'Senior Instructor',
                'qualifications' => [
                    'NVQ Level 5&6 Cosmetology',
                    'NVQ Level 4 Beautician & Hairdresser',
                ],
                'image' => null,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Akashi Rajapakshe',
                'position' => 'Instructor',
                'qualifications' => [
                    'NVQ Level 4 Beautician & Hairdresser',
                ],
                'image' => null,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Nikeshala',
                'position' => 'Instructor',
                'qualifications' => [
                    'NVQ Level 4 Beautician & Hairdresser',
                ],
                'image' => null,
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($instructors as $instructor) {
            Instructor::create($instructor);
        }
    }
}
