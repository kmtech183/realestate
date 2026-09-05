<?php

namespace Database\Factories;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Feature>
 */
class FeatureFactory extends Factory
{
    protected $model = Feature::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Swimming Pool',
            'Club House',
            '24/7 Security & CCTV',
            'Gymnasium',
            'Landscaped Garden',
            'EV Charging Station',
            'Power Backup',
            'Children Play Area',
            'Reserved Covered Parking',
            'High-Speed Elevators',
            'Jogging Track',
            'Solar Panels',
            'Terrace Garden',
            'Home Automation',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'icon' => 'check-circle',
        ];
    }
}
