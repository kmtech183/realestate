<?php

namespace Database\Factories;

use App\Models\PropertyCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PropertyCategory>
 */
class PropertyCategoryFactory extends Factory
{
    protected $model = PropertyCategory::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Luxury Apartments',
            'Villas & Bungalows',
            'Penthouses',
            'Commercial Offices',
            'Studio Apartments',
            'Row Houses',
            'Farmhouses',
            'Industrial Plots',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'icon' => fake()->randomElement(['home', 'building-office', 'sparkles', 'briefcase', 'map-pin']),
            'description' => fake()->paragraph(),
        ];
    }
}
