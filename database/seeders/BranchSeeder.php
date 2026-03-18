<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
                'login_email' => 'maharagama@ikicb.com',
            ],
            [
                'name' => 'Gampaha Branch',
                'location' => 'Gampaha',
                'address' => 'Gampaha, Sri Lanka',
                'phone' => '0777155515',
                'email' => 'ikbrideshub@gmail.com',
                'is_active' => true,
                'login_email' => 'gampaha@ikicb.com',
            ],
            [
                'name' => 'Negombo Branch',
                'location' => 'Negombo',
                'address' => 'Negombo, Sri Lanka',
                'phone' => '0777155515',
                'email' => 'ikbrideshub@gmail.com',
                'is_active' => true,
                'login_email' => 'negombo@ikicb.com',
            ],
            [
                'name' => 'Ratnapura Branch',
                'location' => 'Ratnapura',
                'address' => 'Ratnapura, Sri Lanka',
                'phone' => '0777155515',
                'email' => 'ikbrideshub@gmail.com',
                'is_active' => true,
                'login_email' => 'ratnapura@ikicb.com',
            ],
        ];

        foreach ($branches as $data) {
            $loginEmail = $data['login_email'];
            unset($data['login_email']);

            $branch = Branch::create($data);

            User::updateOrCreate(
                ['email' => $loginEmail],
                [
                    'name' => $branch->name . ' Admin',
                    'password' => Hash::make('password'),
                    'role' => 'branch_admin',
                    'branch_id' => $branch->id,
                ]
            );
        }

        $this->command->info('Branches and branch admin users created!');
        $this->command->info('Maharagama: maharagama@ikicb.com / password');
        $this->command->info('Gampaha: gampaha@ikicb.com / password');
        $this->command->info('Negombo: negombo@ikicb.com / password');
        $this->command->info('Ratnapura: ratnapura@ikicb.com / password');
    }
}
