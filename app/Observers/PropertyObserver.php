<?php

namespace App\Observers;

use App\Models\Property;
use Illuminate\Support\Facades\Cache;

class PropertyObserver
{
    /**
     * Clear all property-related cache keys upon creation, update, or deletion.
     */
    protected function clearPropertyCache(): void
    {
        // Increment catalog cache version (Instantly invalidates all cached query hashes)
        Cache::increment('properties:cache_version');

        // Clear featured properties & popular cache
        Cache::forget('properties:featured');
        Cache::forget('properties:popular');
        Cache::forget('properties:city_counts');
    }

    /**
     * Handle the Property "created" event.
     */
    public function created(Property $property): void
    {
        $this->clearPropertyCache();
    }

    /**
     * Handle the Property "updated" event.
     */
    public function updated(Property $property): void
    {
        $this->clearPropertyCache();
        Cache::forget("property:show:{$property->slug}");
    }

    /**
     * Handle the Property "deleted" event.
     */
    public function deleted(Property $property): void
    {
        $this->clearPropertyCache();
        Cache::forget("property:show:{$property->slug}");
    }

    /**
     * Handle the Property "restored" event.
     */
    public function restored(Property $property): void
    {
        $this->clearPropertyCache();
    }
}
