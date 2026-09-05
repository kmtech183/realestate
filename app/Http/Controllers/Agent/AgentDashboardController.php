<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Property;
use App\Models\PropertyVisit;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AgentDashboardController extends Controller
{
    public function __invoke(): View
    {
        $agentId = Auth::id();

        $stats = [
            'total_properties' => Property::where('agent_id', $agentId)->count(),
            'active_listings' => Property::where('agent_id', $agentId)->active()->count(),
            'total_inquiries' => Inquiry::whereHas('property', fn($q) => $q->where('agent_id', $agentId))->count(),
            'pending_visits' => PropertyVisit::whereHas('property', fn($q) => $q->where('agent_id', $agentId))->where('status', 'pending')->count(),
        ];

        $recentInquiries = Inquiry::whereHas('property', fn($q) => $q->where('agent_id', $agentId))
            ->with('property')
            ->latest()
            ->take(5)
            ->get();

        $myProperties = Property::where('agent_id', $agentId)
            ->with(['category', 'media'])
            ->latest()
            ->take(5)
            ->get();

        return view('agent.dashboard', compact('stats', 'recentInquiries', 'myProperties'));
    }
}
