<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Recruiter/HRD
        User::factory()->create([
            'name' => 'HRD Hartono',
            'email' => 'hrd@hartonogroup.com',
            'role' => 'employer',
            'password' => Hash::make('password123'),
        ]);

        // Applicants
        User::factory()->count(10)->create([
            'role' => 'applicant',
            // password is 'password' by default in factory
        ]);
    }
}
