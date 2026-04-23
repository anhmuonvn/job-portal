<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\JobType;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    $userId = User::inRandomOrder()->first()->id; // 
    $jobTypeId = JobType::inRandomOrder()->first()->id;
    $categoryId = Category::inRandomOrder()->first()->id;
    $locationId = Location::inRandomOrder()->first()->id;

    return [
        'title' => fake()->jobTitle(),
        'user_id' => $userId,
        'job_type_id' => $jobTypeId,
        'category_id' => $categoryId,
        'location_id' => $locationId,
        'vacancy' => rand(1,5),
        'address'=> fake()->streetAddress(),
        'deadline'=>fake()->dateTimeBetween('+1 week', '+1 month'),
        'description' => fake()->sentences(10,true),
        'experience' => rand(1,10),
        'company_name' => fake()->company(),
    ];
}
}
