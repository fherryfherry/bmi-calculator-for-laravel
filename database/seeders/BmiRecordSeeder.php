<?php

namespace Database\Seeders;

use App\Models\BmiRecord;
use App\Models\User;
use Illuminate\Database\Seeder;

class BmiRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing users or create one if none exist
        $users = User::all();
        if ($users->isEmpty()) {
            $users = User::factory()->count(3)->create();
        }

        // Create diverse BMI records across all categories
        BmiRecord::factory()->count(5)->underweight()->create([
            'user_id' => $users->random()->id,
        ]);

        BmiRecord::factory()->count(10)->normal()->create([
            'user_id' => $users->random()->id,
        ]);

        BmiRecord::factory()->count(5)->overweight()->create([
            'user_id' => $users->random()->id,
        ]);

        BmiRecord::factory()->count(3)->obese()->create([
            'user_id' => $users->random()->id,
        ]);

        // Create some records with specific names for easy identification
        BmiRecord::create([
            'user_id' => $users->first()->id,
            'name' => 'John Doe',
            'weight' => 75.00,
            'height' => 175.00,
            'bmi_value' => 24.49,
            'bmi_category' => 'Normal',
            'notes' => 'Regular health checkup',
        ]);

        BmiRecord::create([
            'user_id' => $users->first()->id,
            'name' => 'Jane Smith',
            'weight' => 62.00,
            'height' => 165.00,
            'bmi_value' => 22.77,
            'bmi_category' => 'Normal',
            'notes' => 'Fitness program participant',
        ]);
    }
}
