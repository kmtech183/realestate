<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the buyer's favorite properties.
     */
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $favorites = $user->favoriteProperties()
            ->with(['category', 'agent', 'media'])
            ->latest()
            ->paginate(12);
        return view('favorites.index', compact('favorites'));
    }

    /**
     * Toggle favorite status (Add if not present, Remove if present).
     */
    public function toggle(Property $property): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $existing = Favorite::where('user_id', $user->id)
            ->where('property_id', $property->id)
            ->first();
        if ($existing) {
            $existing->delete();
            $message = 'Property removed from your saved list.';
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'property_id' => $property->id,
            ]);
            $message = 'Property added to your saved favorites!';
        }
        return back()->with('success', $message);
    }
}
