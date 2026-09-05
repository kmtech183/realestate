<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Property extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'agent_id',
        'category_id',
        'title',
        'slug',
        'description',
        'price',
        'area_sqft',
        'bedrooms',
        'bathrooms',
        'balconies',
        'address',
        'locality',
        'city',
        'state',
        'pincode',
        'property_type',
        'status',
        'is_featured',
        'view_count',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'area_sqft' => 'decimal:2',
            'bedrooms' => 'integer',
            'bathrooms' => 'integer',
            'balconies' => 'integer',
            'is_featured' => 'boolean',
            'view_count' => 'integer',
        ];
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(245)
            ->sharpen(10)
            ->nonQueued();

        $this->addMediaConversion('large')
            ->width(1200)
            ->height(800)
            ->nonQueued();
    }

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(PropertyCategory::class, 'category_id');
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function features(): MorphToMany
    {
        return $this->morphToMany(Feature::class, 'featureable');
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(PropertyVisit::class);
    }

    // Dynamic Query Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeForType(Builder $query, string $type): Builder
    {
        return $query->where('property_type', $type);
    }

    public function scopePriceBetween(Builder $query, float $min, float $max): Builder
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeInCity(Builder $query, string $city): Builder
    {
        return $query->where('city', $city);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('locality', 'like', "%{$term}%")
                ->orWhere('city', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%");
        });
    }

    // Formatted INR Price helper
    public function getFormattedPriceAttribute(): string
    {
        if ($this->price >= 10000000) {
            return '₹' . number_format($this->price / 10000000, 2) . ' Cr';
        } elseif ($this->price >= 100000) {
            return '₹' . number_format($this->price / 100000, 2) . ' Lac';
        }
        return '₹' . number_format($this->price, 2);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->hasMedia('images') && $this->getFirstMediaUrl('images')) {
            return $this->getFirstMediaUrl('images');
        }

        // Beautiful category-specific Unsplash fallbacks
        return match ($this->category?->slug) {
            'luxury-apartments' => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?auto=format&fit=crop&w=800&q=80',
            'villas-bungalows' => 'https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=800&q=80',
            'penthouses' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80',
            'commercial-offices' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80',
            default => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=800&q=80',
        };
    }
}
