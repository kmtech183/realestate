<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\PropertyVisit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PropertyVisit>
 */
class PropertyVisitFactory extends Factory
{
    protected $model = PropertyVisit::class;

    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'user_id' => User::factory()->state(['role' => 'buyer']),
            'name' => fake()->name(),
            'phone' => '+91 ' . fake()->numerify('98### #####'),
            'preferred_date' => fake()->dateTimeBetween('+1 days', '+14 days')->format('Y-m-d'),
            'preferred_time_slot' => fake()->randomElement([
                'Morning (10:00 AM - 01:00 PM)',
                'Afternoon (02:00 PM - 05:00 PM)',
                'Evening (05:00 PM - 07:30 PM)',
            ]),
            'notes' => fake()->optional()->sentence(),
            'status' => 'pending',
        ];
    }
}
