<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $branches = Branch::all();

        $students = [
            // Maharagama Branch
            ['name' => 'Dilani Perera',        'email' => 'dilani.perera@gmail.com',     'branch' => 'Maharagama'],
            ['name' => 'Sachini Fernando',     'email' => 'sachini.fernando@gmail.com',  'branch' => 'Maharagama'],
            ['name' => 'Nadeesha Silva',       'email' => 'nadeesha.silva@gmail.com',    'branch' => 'Maharagama'],
            ['name' => 'Chamara Wickramasinghe','email' => 'chamara.wick@gmail.com',     'branch' => 'Maharagama'],
            ['name' => 'Hansika Rajapaksha',   'email' => 'hansika.raja@gmail.com',      'branch' => 'Maharagama'],
            ['name' => 'Oshadi Kumari',        'email' => 'oshadi.kumari@gmail.com',     'branch' => 'Maharagama'],

            // Gampaha Branch
            ['name' => 'Malsha Dissanayake',   'email' => 'malsha.dis@gmail.com',        'branch' => 'Gampaha'],
            ['name' => 'Thilini Bandara',      'email' => 'thilini.band@gmail.com',      'branch' => 'Gampaha'],
            ['name' => 'Piumika Jayasinghe',   'email' => 'piumika.jaya@gmail.com',      'branch' => 'Gampaha'],
            ['name' => 'Kavindi Ranasinghe',   'email' => 'kavindi.rana@gmail.com',      'branch' => 'Gampaha'],
            ['name' => 'Sanduni Liyanage',     'email' => 'sanduni.liyan@gmail.com',     'branch' => 'Gampaha'],

            // Negombo Branch
            ['name' => 'Amali Gunathilaka',    'email' => 'amali.guna@gmail.com',        'branch' => 'Negombo'],
            ['name' => 'Hasitha Madushanka',   'email' => 'hasitha.madu@gmail.com',      'branch' => 'Negombo'],
            ['name' => 'Chathuri Senarath',    'email' => 'chathuri.sena@gmail.com',     'branch' => 'Negombo'],
            ['name' => 'Nimasha Wijeratne',    'email' => 'nimasha.wije@gmail.com',      'branch' => 'Negombo'],
            ['name' => 'Buddhika Herath',      'email' => 'buddhika.hera@gmail.com',     'branch' => 'Negombo'],

            // Ratnapura Branch
            ['name' => 'Ishara Gunawardena',   'email' => 'ishara.guna@gmail.com',       'branch' => 'Ratnapura'],
            ['name' => 'Dulani Abeywickrama',  'email' => 'dulani.abey@gmail.com',       'branch' => 'Ratnapura'],
            ['name' => 'Rukmali Senanayake',   'email' => 'rukmali.sena@gmail.com',      'branch' => 'Ratnapura'],
            ['name' => 'Sewwandi Amarasinghe', 'email' => 'sewwandi.amar@gmail.com',     'branch' => 'Ratnapura'],
            ['name' => 'Hiruni Gamage',        'email' => 'hiruni.gama@gmail.com',       'branch' => 'Ratnapura'],
        ];

        foreach ($students as $data) {
            $branch = $branches->firstWhere('location', $data['branch']);
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'      => $data['name'],
                    'password'  => Hash::make('password'),
                    'role'      => 'student',
                    'branch_id' => $branch?->id,
                ]
            );
        }

        $this->command->info('21 students created across all branches.');
    }
}
