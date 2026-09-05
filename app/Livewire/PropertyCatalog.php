<?php

namespace App\Livewire;

use App\Models\Feature;
use App\Models\Property;
use App\Models\PropertyCategory;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyCatalog extends Component
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
        $query = Property::query()
            ->active()
            ->with(['category', 'agent', 'media']);

        // Search Keyword
        if (!empty($this->search)) {
            $query->search($this->search);
        }

        // Property Type (Sale / Rent)
        if (!empty($this->propertyType)) {
            $query->where('property_type', $this->propertyType);
        }

        // Category Filter
        if (!empty($this->selectedCategory)) {
            $query->whereHas('category', fn($q) => $q->where('slug', $this->selectedCategory));
        }

        // Locality Filter
        if (!empty($this->locality)) {
            $query->where('locality', $this->locality);
        }

        // Bedrooms / BHK Filter
        if (!empty($this->bedrooms)) {
            if ($this->bedrooms === '4+') {
                $query->where('bedrooms', '>=', 4);
            } else {
                $query->where('bedrooms', (int) $this->bedrooms);
            }
        }

        // Min & Max Price
        if ($this->minPrice !== null && $this->minPrice > 0) {
            $query->where('price', '>=', $this->minPrice);
        }
        if ($this->maxPrice !== null && $this->maxPrice > 0) {
            $query->where('price', '<=', $this->maxPrice);
        }

        // Sorting
        match ($this->sortBy) {
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            'popular' => $query->orderBy('view_count', 'desc'),
            default => $query->latest(),
        };

        $properties = $query->paginate(9);
        $categories = PropertyCategory::orderBy('name')->get();

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

        return view('livewire.property-catalog', compact('properties', 'categories', 'localities'));
    }
}
