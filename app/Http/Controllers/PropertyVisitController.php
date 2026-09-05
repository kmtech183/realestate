<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyVisit;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PropertyVisitController extends Controller
{
    /**
     * Display scheduled visits for an agent / admin.
     */
    public function index(): View
    {
        Gate::authorize('viewAny', PropertyVisit::class);

        /** @var User $user */
        $user = Auth::user();

        $visits = $user->isAdmin()
            ? PropertyVisit::with(['property', 'user'])->latest()->paginate(15)
            : PropertyVisit::whereHas('property', fn($q) => $q->where('agent_id', $user->id))
            ->with(['property', 'user'])
            ->latest()
            ->paginate(15);

        return view('visits.index', compact('visits'));
    }

    /**
     * Schedule a site inspection visit.
     */
    public function store(Request $request, Property $property): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'preferred_date' => 'required|date|after:today',
            'preferred_time_slot' => 'required|string|max:50',
            'notes' => 'nullable|string|max:500',
        ]);

        $visit = new PropertyVisit($validated);
        $visit->property_id = $property->id;
        $visit->user_id = $user->id;
        $visit->status = 'pending';
        $visit->save();

        return back()->with('success', 'Site visit scheduled! The agent will confirm shortly.');
    }

    /**
     * Update site visit status (Agent/Admin).
     */
    public function updateStatus(Request $request, PropertyVisit $visit): RedirectResponse
    {
        Gate::authorize('updateStatus', $visit);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $visit->update($validated);

        return back()->with('success', 'Visit status updated.');
    }
}
