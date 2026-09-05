<?php

namespace App\Services;

use App\Contracts\PropertySearchServiceInterface;
use App\Models\Property;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class PropertySearchService implements PropertySearchServiceInterface
{
    public function search(array $filters, int $perPage = 9): LengthAwarePaginator
    {
        $query = Property::query()
            ->active()
            ->with(['category', 'agent', 'media']);

        if (!empty($filters['q'])) {
            $query->search($filters['q']);
        }

        if (!empty($filters['type'])) {
            $query->where('property_type', $filters['type']);
        }

        if (!empty($filters['category'])) {
            $query->whereHas('category', fn($q) => $q->where('slug', $filters['category']));
        }

        if (!empty($filters['locality'])) {
            $query->where('locality', $filters['locality']);
        }

        if (!empty($filters['bhk'])) {
            if ($filters['bhk'] === '4+') {
                $query->where('bedrooms', '>=', 4);
            } else {
                $query->where('bedrooms', (int) $filters['bhk']);
            }
        }

        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', (float) $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', (float) $filters['max_price']);
        }

        $sort = $filters['sort'] ?? 'latest';
        match ($sort) {
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            'popular' => $query->orderBy('view_count', 'desc'),
            default => $query->latest(),
        };

        return $query->paginate($perPage);
    }

    public function getFeatured(int $limit = 6)
    {
        return Cache::remember('properties:featured:home', 1800, function () use ($limit) {
            return Property::active()
                ->featured()
                ->with(['category', 'agent', 'media'])
                ->latest()
                ->take($limit)
                ->get();
        });
    }

    public function getCityMarketStats(): array
    {
        return Cache::remember('properties:market_stats', 3600, function () {
            return [
                'total_listings' => Property::active()->count(),
                'for_sale_count' => Property::active()->forType('sale')->count(),
                'for_rent_count' => Property::active()->forType('rent')->count(),
                'avg_sale_price' => Property::active()->forType('sale')->avg('price') ?? 0,
            ];
        });
    }
}
