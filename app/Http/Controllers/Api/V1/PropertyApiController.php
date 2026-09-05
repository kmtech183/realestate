<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\PropertySearchServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CategoryResource;
use App\Http\Resources\Api\V1\PropertyResource;
use App\Models\Property;
use App\Models\PropertyCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PropertyApiController extends Controller
{
    public function __construct(protected PropertySearchServiceInterface $searchService) {}

    /**
     * Search and list active properties with cursor pagination.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Property::query()
            ->active()
            ->with(['category', 'agent', 'features', 'media']);

        if ($request->filled('q')) {
            $query->search($request->string('q'));
        }

        if ($request->filled('type')) {
            $query->where('property_type', $request->string('type'));
        }

        if ($request->filled('city')) {
            $query->where('city', $request->string('city'));
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->string('category')));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->float('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->float('max_price'));
        }

        $properties = $query->latest()->cursorPaginate(10);

        return PropertyResource::collection($properties);
    }

    /**
     * Get single property details by slug.
     */
    public function show(Property $property): PropertyResource
    {
        $property->load(['category', 'agent', 'features', 'media']);

        return new PropertyResource($property);
    }

    /**
     * List all categories with active property counts.
     */
    public function categories(): AnonymousResourceCollection
    {
        $categories = PropertyCategory::withCount(['properties' => fn($q) => $q->active()])
            ->orderBy('name')
            ->get();

        return CategoryResource::collection($categories);
    }

    /**
     * Get market stats.
     */
    public function marketStats(): JsonResponse
    {
        $stats = $this->searchService->getCityMarketStats();

        return response()->json([
            'status' => 'success',
            'data' => $stats,
        ]);
    }
}
