<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PropertyDetail extends Component
{
    public Property $property;
    public string $activeImage = '';

    public function mount(Property $property): void
    {
        $this->property = $property->load(['category', 'agent', 'features', 'media']);
        $this->activeImage = $property->image_url;
    }

    public function selectImage(string $url): void
    {
        $this->activeImage = $url;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $similarProperties = Property::active()
            ->where('category_id', $this->property->category_id)
            ->where('id', '!=', $this->property->id)
            ->take(3)
            ->get();

        return view('livewire.property-detail', compact('similarProperties'));
    }
}
