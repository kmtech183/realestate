<?php

namespace Database\Factories;

use App\Models\Favorite;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Favorite>
 */
class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'buyer']),
            'property_id' => Property::factory(),
        ];
    }
}
