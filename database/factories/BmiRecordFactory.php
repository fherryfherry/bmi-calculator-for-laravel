<?php

namespace Database\Factories;

use App\Models\BmiRecord;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BmiRecord>
 */
class BmiRecordFactory extends Factory
{
    protected $model = BmiRecord::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $weight = fake()->randomFloat(2, 45, 120);
        $height = fake()->randomFloat(2, 150, 200);
        $bmiValue = BmiRecord::calculateBmi($weight, $height);
        $category = BmiRecord::getCategory($bmiValue);

        return [
            'user_id' => User::factory(),
            'name' => fake()->name(),
            'weight' => $weight,
            'height' => $height,
            'bmi_value' => $bmiValue,
            'bmi_category' => $category,
            'notes' => fake()->optional()->sentence(),
        ];
    }

    /**
     * Indicate that the BMI record belongs to an existing user.
     */
    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Indicate underweight records.
     */
    public function underweight(): static
    {
        return $this->state(fn (array $attributes) => [
            'weight' => fake()->randomFloat(2, 45, 55),
            'height' => fake()->randomFloat(2, 170, 200),
        ]);
    }

    /**
     * Indicate normal weight records.
     */
    public function normal(): static
    {
        return $this->state(fn (array $attributes) => [
            'weight' => fake()->randomFloat(2, 60, 80),
            'height' => fake()->randomFloat(2, 160, 180),
        ]);
    }

    /**
     * Indicate overweight records.
     */
    public function overweight(): static
    {
        return $this->state(fn (array $attributes) => [
            'weight' => fake()->randomFloat(2, 85, 100),
            'height' => fake()->randomFloat(2, 160, 180),
        ]);
    }

    /**
     * Indicate obese records.
     */
    public function obese(): static
    {
        return $this->state(fn (array $attributes) => [
            'weight' => fake()->randomFloat(2, 100, 120),
            'height' => fake()->randomFloat(2, 150, 175),
        ]);
    }
}
