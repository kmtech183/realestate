<?php

namespace Database\Factories;

use App\Models\Inquiry;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inquiry>
 */
class InquiryFactory extends Factory
{
    protected $model = Inquiry::class;

    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'user_id' => User::factory()->state(['role' => 'buyer']),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => '+91 ' . fake()->numerify('98### #####'),
            'message' => fake()->sentence(12),
            'status' => fake()->randomElement(['new', 'contacted', 'closed']),
            'replied_at' => fake()->optional(0.4)->dateTimeThisMonth(),
        ];
    }
}
