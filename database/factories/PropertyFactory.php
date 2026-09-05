<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Property>
 */
class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        $localities = [
            'Bodakdev',
            'SG Highway',
            'Prahlad Nagar',
            'Sindhu Bhavan Road',
            'Thaltej',
            'Ambli',
            'Satellite',
            'Vastrapur',
            'GIFT City',
            'Science City',
            'Shela',
            'South Bopal'
        ];

        $bhk = fake()->numberBetween(1, 5);
        $locality = fake()->randomElement($localities);
        $propertyType = fake()->randomElement(['sale', 'rent']);

        // Pricing tailored to Ahmedabad market
        $price = $propertyType === 'sale'
            ? fake()->numberBetween(4500000, 75000000) // ₹45 Lakh to ₹7.5 Crore
            : fake()->numberBetween(25000, 250000);    // ₹25k to ₹2.5 Lakh / month

        $title = "{$bhk} BHK " . fake()->randomElement(['Luxury Apartment', 'Designer Villa', 'Sky Penthouse', 'Premium Flat']) . " in {$locality}";

        return [
            'agent_id' => User::factory()->state(['role' => 'agent']),
            'category_id' => PropertyCategory::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'description' => fake()->paragraphs(3, true),
            'price' => $price,
            'area_sqft' => $bhk * fake()->numberBetween(450, 950),
            'bedrooms' => $bhk,
            'bathrooms' => $bhk,
            'balconies' => fake()->numberBetween(1, 3),
            'address' => "Near {$locality}, Ring Road",
            'locality' => $locality,
            'city' => 'Ahmedabad',
            'state' => 'Gujarat',
            'pincode' => '380015',
            'property_type' => $propertyType,
            'status' => 'active',
            'is_featured' => fake()->boolean(25), // 25% featured
            'view_count' => fake()->numberBetween(50, 5000),
        ];
    }

    /**
     * State: Featured listing
     */
    public function featured(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * State: Rental property
     */
    public function forRent(): static
    {
        return $this->state(fn(array $attributes) => [
            'property_type' => 'rent',
            'price' => fake()->numberBetween(25000, 150000),
        ]);
    }

    /**
     * State: Sale property
     */
    public function forSale(): static
    {
        return $this->state(fn(array $attributes) => [
            'property_type' => 'sale',
            'price' => fake()->numberBetween(5000000, 50000000),
        ]);
    }
}
