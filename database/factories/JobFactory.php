<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Job;

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
        return [
            'user_id' => User::factory(), // Create new user for each listing
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph(1, true),
            'salary' => $this->faker->numberBetween(40000, 120000),
            'tags' => implode(', ', $this->faker->words(3)),
            'job_type' => $this->faker->randomElement([
                'Full-Time',
                'Part-Time',
                'Contract',
                'Temporary',
                'Internship',
                'Volunteer',
                'On-Call'
            ]),
            'remote' => $this->faker->boolean,
            'requirements' => $this->faker->sentence(6, true),
            'benefits' => $this->faker->sentence(6, true),
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zipcode' => $this->faker->postcode,
            'contact_email' => $this->faker->safeEmail,
            'contact_phone' => $this->faker->phoneNumber,
            'company_name' => $this->faker->company,
            'company_description' => $this->faker->paragraph(1, true),
            'company_logo' => $this->faker->imageUrl(100, 100, 'business', true, 'logo'),
            'company_website' => $this->faker->url,

        ];
    }
}
