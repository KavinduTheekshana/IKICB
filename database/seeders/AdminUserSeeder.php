<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@ikicb.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create Instructor User
        User::updateOrCreate(
            ['email' => 'instructor@ikicb.com'],
            [
                'name' => 'Instructor User',
                'password' => Hash::make('password'),
                'role' => 'instructor',
            ]
        );

        // Create Student User
        User::updateOrCreate(
            ['email' => 'student@ikicb.com'],
            [
                'name' => 'Student User',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );

        $this->command->info('Users created successfully!');
        $this->command->info('Admin: admin@ikicb.com / password');
        $this->command->info('Instructor: instructor@ikicb.com / password');
        $this->command->info('Student: student@ikicb.com / password');
    }
}
