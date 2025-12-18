<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Maharagama Branch',
                'location' => 'Maharagama',
                'address' => 'Maharagama, Sri Lanka',
                'phone' => '0777155515',
                'email' => 'ikbrideshub@gmail.com',
                'is_active' => true,
            ],
            [
                'name' => 'Gampaha Branch',
                'location' => 'Gampaha',
                'address' => 'Gampaha, Sri Lanka',
                'phone' => '0777155515',
                'email' => 'ikbrideshub@gmail.com',
                'is_active' => true,
            ],
            [
                'name' => 'Negombo Branch',
                'location' => 'Negombo',
                'address' => 'Negombo, Sri Lanka',
                'phone' => '0777155515',
                'email' => 'ikbrideshub@gmail.com',
                'is_active' => true,
            ],
            [
                'name' => 'Ratnapura Branch',
                'location' => 'Ratnapura',
                'address' => 'Ratnapura, Sri Lanka',
                'phone' => '0777155515',
                'email' => 'ikbrideshub@gmail.com',
                'is_active' => true,
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}
