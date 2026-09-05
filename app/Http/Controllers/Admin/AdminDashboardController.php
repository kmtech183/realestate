<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'total_properties' => Property::count(),
            'total_agents' => User::where('role', 'agent')->count(),
            'total_buyers' => User::where('role', 'buyer')->count(),
            'total_inquiries' => Inquiry::count(),
            'total_categories' => PropertyCategory::count(),
        ];

        $recentProperties = Property::with(['agent', 'category'])->latest()->take(6)->get();
        $recentInquiries = Inquiry::with(['property', 'user'])->latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentProperties', 'recentInquiries'));
    }
}
