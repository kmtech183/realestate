<?php

use App\Livewire\PropertyList;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\User;
use Livewire\Livewire;

it('renders the homepage and displays active properties', function () {
    $category = PropertyCategory::factory()->create(['name' => 'Luxury Apartments', 'slug' => 'luxury-apartments']);
    $property = Property::factory()->create([
        'category_id' => $category->id,
        'title' => '4 BHK Sky Villa in Bodakdev',
        'status' => 'active',
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Luxury Living in');
    $response->assertSee('4 BHK Sky Villa in Bodakdev');
});

it('allows guests to view single property details by slug and increments view counter', function () {
    $property = Property::factory()->create([
        'title' => 'Mediterranean Villa on SG Highway',
        'slug' => 'mediterranean-villa-sg-highway',
        'status' => 'active',
        'view_count' => 10,
    ]);

    $response = $this->get(route('properties.show', $property->slug));

    $response->assertStatus(200);
    $response->assertSee('Mediterranean Villa on SG Highway');

    // View counter should increment
    expect($property->fresh()->view_count)->toBe(11);
});

it('filters properties reactively via Livewire by search keyword and locality', function () {
    $prop1 = Property::factory()->create(['title' => 'Luxury Villa in Bodakdev', 'locality' => 'Bodakdev', 'status' => 'active']);
    $prop2 = Property::factory()->create(['title' => 'Modern Flat in Prahlad Nagar', 'locality' => 'Prahlad Nagar', 'status' => 'active']);

    Livewire::test(PropertyList::class)
        ->set('search', 'Bodakdev')
        ->assertSee('Luxury Villa in Bodakdev')
        ->assertDontSee('Modern Flat in Prahlad Nagar');
});

it('filters properties by price range', function () {
    $cheapProp = Property::factory()->create(['title' => 'Affordable 2 BHK', 'price' => 3000000, 'status' => 'active']);
    $luxuryProp = Property::factory()->create(['title' => 'Ultra Penthouse', 'price' => 50000000, 'status' => 'active']);

    Livewire::test(PropertyList::class)
        ->set('minPrice', 20000000)
        ->set('maxPrice', 60000000)
        ->assertSee('Ultra Penthouse')
        ->assertDontSee('Affordable 2 BHK');
});
