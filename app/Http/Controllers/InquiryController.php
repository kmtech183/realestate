<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Models\Inquiry;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use App\Jobs\SendInquiryNotification;

class InquiryController extends Controller
{
    /**
     * Display a listing of inquiries for the agent / admin.
     */
    public function index(): View
    {
        Gate::authorize('viewAny', Inquiry::class);
        /** @var User $user */
        $user = Auth::user();
        $inquiries = $user->isAdmin()
            ? Inquiry::with(['property', 'user'])->latest()->paginate(15)
            : Inquiry::whereHas('property', fn($q) => $q->where('agent_id', $user->id))
            ->with(['property', 'user'])
            ->latest()
            ->paginate(15);
        return view('inquiries.index', compact('inquiries'));
    }


    /**
     * Store a newly created inquiry from a buyer.
     */
    public function store(StoreInquiryRequest $request, Property $property): RedirectResponse
    {
        $validated = $request->validated();

        $inquiry = new Inquiry($validated);
        $inquiry->property_id = $property->id;
        $inquiry->user_id = Auth::id();
        $inquiry->status = 'new';
        $inquiry->save();

        // Dispatch background queued notification job
        SendInquiryNotification::dispatch($inquiry);

        return back()->with('success', 'Thank you! Your inquiry has been sent to the listing agent.');
    }


    /**
     * Mark an inquiry as replied / contacted.
     */
    public function updateStatus(Request $request, Inquiry $inquiry): RedirectResponse
    {
        Gate::authorize('reply', $inquiry);
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,closed',
        ]);
        $inquiry->update([
            'status' => $validated['status'],
            'replied_at' => now(),
        ]);
        return back()->with('success', 'Inquiry status updated successfully.');
    }


    /**
     * Delete an inquiry (Admin only).
     */
    public function destroy(Inquiry $inquiry): RedirectResponse
    {
        Gate::authorize('delete', $inquiry);
        $inquiry->delete();
        return back()->with('success', 'Inquiry deleted successfully.');
    }
}
