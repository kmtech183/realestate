<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => (float) $this->price,
            'formatted_price' => $this->formatted_price,
            'area_sqft' => (float) $this->area_sqft,
            'bedrooms' => (int) $this->bedrooms,
            'bathrooms' => (int) $this->bathrooms,
            'balconies' => (int) $this->balconies,
            'property_type' => $this->property_type,
            'status' => $this->status,
            'is_featured' => (bool) $this->is_featured,
            'view_count' => (int) $this->view_count,
            'location' => [
                'address' => $this->address,
                'locality' => $this->locality,
                'city' => $this->city,
                'state' => $this->state,
                'pincode' => $this->pincode,
            ],
            'primary_image' => $this->image_url,
            'gallery' => $this->getMedia('images')->map(fn($m) => [
                'id' => $m->id,
                'url' => $m->getUrl(),
                'thumb' => $m->getUrl('thumb'),
            ]),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'agent' => new AgentResource($this->whenLoaded('agent')),
            'features' => $this->whenLoaded(
                'features',
                fn() =>
                $this->features->map(fn($f) => [
                    'id' => $f->id,
                    'name' => $f->name,
                    'slug' => $f->slug,
                ])
            ),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
