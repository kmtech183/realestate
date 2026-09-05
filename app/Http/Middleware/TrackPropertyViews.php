<?php

namespace App\Http\Middleware;

use App\Models\Property;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackPropertyViews
{
    /**
     * Handle an incoming request.
     * Tracks property views with session deduplication per IP to prevent artificial inflating.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $property = $request->route('property');

        if ($property instanceof Property) {
            $ip = $request->ip();
            $cacheKey = "property_view:{$property->id}:{$ip}";

            // Track view only once per IP per 3 hours
            if (! Cache::has($cacheKey)) {
                Cache::put($cacheKey, true, now()->addHours(3));

                // Atomic increment in DB or cache buffer
                $property->increment('view_count');
            }
        }

        return $next($request);
    }
}
