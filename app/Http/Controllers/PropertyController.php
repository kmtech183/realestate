<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    /**
     * Display a listing of properties.
     */
    public function index(): View
    {
        Gate::authorize('viewAny', Property::class);

        $properties = Property::with(['category', 'agent', 'media'])
            ->active()
            ->latest()
            ->paginate(12);

        return view('properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new property.
     */
    public function create(): View
    {
        Gate::authorize('create', Property::class);

        $categories = PropertyCategory::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('properties.create', compact('categories', 'features'));
    }

    /**
     * Store a newly created property in storage.
     */
    public function store(StorePropertyRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['agent_id'] = Auth::id();
        $validated['status'] = 'active';
        $property = Property::create($validated);
        if (!empty($request->features)) {
            $property->features()->sync($request->features);
        }
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $property->addMedia($imageFile)->toMediaCollection('images');
            }
        }
        return redirect()->route('agent.dashboard')->with('success', 'Property listing created successfully!');
    }


    /**
     * Display the specified property.
     */
    public function show(Property $property): View
    {
        Gate::authorize('view', $property);

        $property->load(['category', 'agent', 'features', 'media']);
        $similarProperties = Property::active()
            ->where('category_id', $property->category_id)
            ->where('id', '!=', $property->id)
            ->take(3)
            ->get();

        return view('properties.show', compact('property', 'similarProperties'));
    }

    /**
     * Show the form for editing the specified property.
     */
    public function edit(Property $property): View
    {
        Gate::authorize('update', $property);

        $categories = PropertyCategory::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();
        $property->load('features');

        return view('properties.edit', compact('property', 'categories', 'features'));
    }

    /**
     * Update the specified property in storage.
     */
    public function update(UpdatePropertyRequest $request, Property $property): RedirectResponse
    {
        $validated = $request->validated();
        $property->update($validated);
        if (isset($request->features)) {
            $property->features()->sync($request->features);
        }
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $property->addMedia($imageFile)->toMediaCollection('images');
            }
        }
        return redirect()->route('agent.dashboard')->with('success', 'Property listing updated successfully!');
    }


    /**
     * Remove the specified property from storage.
     */
    public function destroy(Property $property): RedirectResponse
    {
        Gate::authorize('delete', $property);

        $property->clearMediaCollection('images');
        $property->delete();

        return back()->with('success', 'Property listing deleted successfully.');
    }
}
