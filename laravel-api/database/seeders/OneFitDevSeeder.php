<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OneFitDevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Test User
        \App\Models\User::create([
            'username' => 'onefit_dev',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'user_name' => 'Dev',
            'user_surname' => 'OneFit',
            'id_number' => '0000000000000',
            'email' => 'dev@onefit.app',
            'contact_number' => '000-000-0000',
            'date_of_birth' => '1990-01-01',
            'user_gender' => 'Other',
            'user_nationality' => 'Global',
            'account_active' => true,
        ]);

        // Sample Interest
        \Illuminate\Support\Facades\DB::table('interests')->insert([
            'interest_title' => 'CrossFit',
            'interest_description' => 'High-intensity interval training.',
            'created_by' => 'onefit_dev',
            'creation_date' => now(),
        ]);

        // Sample Exercise
        \Illuminate\Support\Facades\DB::table('exercises')->insert([
            'exercise_name' => 'Push Ups',
            'exercise_description' => 'Standard push ups.',
            'exercise_type' => 'Bodyweight',
            'xp_points' => 10,
            'created_by' => 'onefit_dev',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
