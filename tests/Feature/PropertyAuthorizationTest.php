<?php

use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

it('forbids unauthenticated users and buyers from creating property listings', function () {
    $buyer = User::factory()->buyer()->create();

    // Guest check
    $this->get(route('agent.properties.create'))->assertRedirect(route('login'));

    // Buyer check
    $this->actingAs($buyer)
        ->get(route('agent.properties.create'))
        ->assertForbidden();

    expect(Gate::forUser($buyer)->allows('create', Property::class))->toBeFalse();
});

it('allows agents to create property listings', function () {
    $agent = User::factory()->agent()->create();
    $category = PropertyCategory::factory()->create();

    expect(Gate::forUser($agent)->allows('create', Property::class))->toBeTrue();

    $this->actingAs($agent)
        ->post(route('agent.properties.store'), [
            'title' => 'Brand New 3 BHK in Satellite',
            'category_id' => $category->id,
            'description' => 'A wonderful modern 3 BHK apartment with great sunlight and ventilation.',
            'price' => 7500000,
            'area_sqft' => 1950,
            'bedrooms' => 3,
            'bathrooms' => 3,
            'balconies' => 2,
            'address' => 'Near Star Bazaar, Satellite',
            'locality' => 'Satellite',
            'city' => 'Ahmedabad',
            'state' => 'Gujarat',
            'pincode' => '380015',
            'property_type' => 'sale',
        ])
        ->assertRedirect(route('agent.dashboard'))
        ->assertSessionHas('success');

    expect(Property::where('title', 'Brand New 3 BHK in Satellite')->exists())->toBeTrue();
});

it('prevents agents from editing properties owned by another agent, but allows admin', function () {
    $agentA = User::factory()->agent()->create();
    $agentB = User::factory()->agent()->create();
    $admin = User::factory()->admin()->create();

    $propertyOfA = Property::factory()->create(['agent_id' => $agentA->id]);

    // Agent B cannot update Agent A's property
    expect(Gate::forUser($agentB)->allows('update', $propertyOfA))->toBeFalse();

    // Owner Agent A can update
    expect(Gate::forUser($agentA)->allows('update', $propertyOfA))->toBeTrue();

    // Admin can update any property
    expect(Gate::forUser($admin)->allows('update', $propertyOfA))->toBeTrue();
});

