<?php

namespace App\Livewire;

use App\Models\Property;
use App\Models\PropertyCategory;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyList extends Component
{
    use WithPagination;

    #[Url(as: 'q', history: true)]
    public string $search = '';

    #[Url(as: 'type', history: true)]
    public string $propertyType = '';

    #[Url(as: 'category', history: true)]
    public string $selectedCategory = '';

    #[Url(as: 'locality', history: true)]
    public string $locality = '';

    #[Url(as: 'bhk', history: true)]
    public string $bedrooms = '';

    #[Url(as: 'min_price', history: true)]
    public ?int $minPrice = null;

    #[Url(as: 'max_price', history: true)]
    public ?int $maxPrice = null;

    #[Url(as: 'sort', history: true)]
    public string $sortBy = 'latest';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingPropertyType(): void
    {
        $this->resetPage();
    }
    public function updatingSelectedCategory(): void
    {
        $this->resetPage();
    }
    public function updatingLocality(): void
    {
        $this->resetPage();
    }
    public function updatingBedrooms(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'propertyType', 'selectedCategory', 'locality', 'bedrooms', 'minPrice', 'maxPrice', 'sortBy']);
        $this->resetPage();
    }

    public function render()
    {
        // 1. Get current cache version
        $cacheVersion = Cache::rememberForever('properties:cache_version', fn() => 1);

        // 2. Build unique signature hash for current filter state
        $filterSignature = md5(json_encode([
            'v' => $cacheVersion,
            'q' => $this->search,
            'type' => $this->propertyType,
            'cat' => $this->selectedCategory,
            'loc' => $this->locality,
            'bhk' => $this->bedrooms,
            'min' => $this->minPrice,
            'max' => $this->maxPrice,
            'sort' => $this->sortBy,
            'page' => $this->getPage(),
        ]));

        $cacheKey = "properties:catalog:{$filterSignature}";

        // 3. Cache results for 10 minutes (Auto-invalidated whenever any property is created/updated)
        $properties = Cache::remember($cacheKey, 600, function () {
            $query = Property::query()
                ->active()
                ->with(['category', 'agent', 'media']);

            if (!empty($this->search)) {
                $query->search($this->search);
            }

            if (!empty($this->propertyType)) {
                $query->where('property_type', $this->propertyType);
            }

            if (!empty($this->selectedCategory)) {
                $query->whereHas('category', fn($q) => $q->where('slug', $this->selectedCategory));
            }

            if (!empty($this->locality)) {
                $query->where('locality', $this->locality);
            }

            if (!empty($this->bedrooms)) {
                if ($this->bedrooms === '4+') {
                    $query->where('bedrooms', '>=', 4);
                } else {
                    $query->where('bedrooms', (int) $this->bedrooms);
                }
            }

            if ($this->minPrice !== null && $this->minPrice > 0) {
                $query->where('price', '>=', $this->minPrice);
            }
            if ($this->maxPrice !== null && $this->maxPrice > 0) {
                $query->where('price', '<=', $this->maxPrice);
            }

            match ($this->sortBy) {
                'price_low' => $query->orderBy('price', 'asc'),
                'price_high' => $query->orderBy('price', 'desc'),
                'popular' => $query->orderBy('view_count', 'desc'),
                default => $query->latest(),
            };

            return $query->paginate(9);
        });

        $categories = Cache::remember('global:categories', 3600, fn() => PropertyCategory::orderBy('name')->get());

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

        return view('livewire.property-list', compact('properties', 'categories', 'localities'));
    }
}
