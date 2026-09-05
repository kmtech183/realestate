<?php

use App\Models\Property;
use App\Models\PropertyCategory;

it('returns json collection with cursor pagination for properties api', function () {
    $category = PropertyCategory::factory()->create();
    Property::factory()->count(5)->create([
        'category_id' => $category->id,
        'status' => 'active',
    ]);

    $response = $this->getJson('/api/v1/properties');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'slug',
                    'price',
                    'formatted_price',
                    'area_sqft',
                    'bedrooms',
                    'bathrooms',
                    'location',
                    'category',
                    'created_at'
                ]
            ],
            'links',
            'meta',
        ]);
});

it('returns market statistics via api', function () {
    Property::factory()->forSale()->create(['price' => 10000000]);
    Property::factory()->forRent()->create(['price' => 50000]);

    $response = $this->getJson('/api/v1/market-stats');

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'success',
            'data' => [
                'total_listings' => 2,
                'for_sale_count' => 1,
                'for_rent_count' => 1,
            ]
        ]);
});
