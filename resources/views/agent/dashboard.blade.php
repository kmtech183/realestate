<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Top Banner Header -->
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 mb-8 text-white shadow-xl flex flex-col md:flex-row md:items-center md:justify-between gap-6 relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 rounded-full text-xs font-bold uppercase tracking-wider">
                        🏛️ Verified Agent Portal
                    </span>
                    <span class="text-xs text-slate-400">· {{ auth()->user()->agency_name ?? 'Gujarat Premier Realty' }}</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">Agent Dashboard</h1>
                <p class="text-slate-300 text-sm mt-1 max-w-xl">Monitor your high-value Ahmedabad listings, track buyer leads, and schedule VIP property visits.</p>
            </div>
            <div class="relative z-10 flex items-center gap-3">
                <a href="{{ route('agent.properties.create') }}" class="px-6 py-3.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold rounded-2xl text-xs sm:text-sm transition shadow-xl shadow-emerald-500/20 inline-flex items-center gap-2">
                    <span>✨</span> Post New Property
                </a>
            </div>
        </div>

        <!-- Metrics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Portfolio</span>
                    <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold">🏠</span>
                </div>
                <div class="text-3xl font-black text-slate-900 mt-3">{{ $stats['total_properties'] }}</div>
                <div class="flex items-center gap-2 mt-1">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span class="text-xs text-emerald-600 font-semibold">{{ $stats['active_listings'] }} Live on Market</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Buyer Inquiries</span>
                    <span class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm font-bold">💬</span>
                </div>
                <div class="text-3xl font-black text-slate-900 mt-3">{{ $stats['total_inquiries'] }}</div>
                <a href="{{ route('agent.inquiries.index') }}" class="text-xs text-indigo-600 hover:text-indigo-700 font-semibold mt-1 inline-block">Review all leads →</a>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Site Inspections</span>
                    <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold">📅</span>
                </div>
                <div class="text-3xl font-black text-slate-900 mt-3">{{ $stats['pending_visits'] }}</div>
                <span class="text-xs text-amber-600 font-semibold mt-1 inline-block">Pending confirmations</span>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Agent Status</span>
                    <span class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm font-bold">🎖️</span>
                </div>
                <div class="text-base font-bold text-slate-800 mt-3 truncate">{{ auth()->user()->name }}</div>
                <span class="text-xs text-emerald-600 font-semibold mt-1 inline-block">✅ Verified Partner</span>
            </div>
        </div>

        <!-- Content Split (My Listings vs Recent Inquiries) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: My Properties (2 Cols) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-black text-slate-900 text-xl tracking-tight">My Managed Properties</h3>
                    <span class="text-xs text-slate-400 font-semibold">{{ $myProperties->count() }} Properties</span>
                </div>

                @if($myProperties->isEmpty())
                    <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm">
                        <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl">🏡</div>
                        <h4 class="font-bold text-slate-800 text-base">No listings created yet</h4>
                        <p class="text-slate-400 text-xs mt-1">Start showcasing your luxury homes to verified Gujarat buyers.</p>
                        <a href="{{ route('agent.properties.create') }}" class="mt-4 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-bold inline-block shadow-md transition">Create First Listing</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @foreach($myProperties as $prop)
                            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
                                <div class="relative h-44 bg-slate-900 overflow-hidden">
                                    <img src="{{ $prop->image_url }}" alt="{{ $prop->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" />
                                    <div class="absolute top-3 left-3 bg-slate-900/90 backdrop-blur-md text-white px-3 py-1 rounded-xl text-xs font-bold shadow-md">
                                        {{ $prop->formatted_price }}
                                    </div>
                                    <div class="absolute top-3 right-3">
                                        <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg uppercase tracking-wider {{ $prop->property_type === 'sale' ? 'bg-emerald-500 text-white' : 'bg-indigo-600 text-white' }}">
                                            For {{ ucfirst($prop->property_type) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-5 flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-600">{{ $prop->category->name }}</span>
                                            <span class="text-[11px] text-slate-400 font-medium">👁️ {{ number_format($prop->view_count) }} views</span>
                                        </div>
                                        <h4 class="font-bold text-slate-900 text-base mt-1 line-clamp-1 group-hover:text-emerald-600 transition">
                                            {{ $prop->title }}
                                        </h4>
                                        <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                                            📍 {{ $prop->locality }}, {{ $prop->city }}
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2 pt-4 mt-4 border-t border-slate-100">
                                        <a href="{{ route('properties.show', $prop->slug) }}" class="flex-1 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl text-center transition">
                                            View Listing
                                        </a>
                                        <a href="{{ route('agent.properties.edit', $prop->id) }}" class="flex-1 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold rounded-xl text-center transition">
                                            Edit Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right: Recent Leads / Inquiries (1 Col) -->
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-black text-slate-900 text-xl tracking-tight">Recent Leads</h3>
                    <a href="{{ route('agent.inquiries.index') }}" class="text-xs font-bold text-emerald-600 hover:underline">View All Leads →</a>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
                    @if($recentInquiries->isEmpty())
                        <div class="text-center py-8">
                            <span class="text-3xl">📭</span>
                            <p class="text-slate-400 text-xs mt-2">No buyer inquiries yet.</p>
                        </div>
                    @else
                        @foreach($recentInquiries as $inq)
                            <div class="p-3.5 bg-slate-50 hover:bg-slate-100/80 rounded-2xl transition border border-slate-100">
                                <div class="flex items-center justify-between text-xs font-bold text-slate-900">
                                    <span class="flex items-center gap-1.5">
                                        <span class="w-6 h-6 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center text-[10px] font-black">
                                            {{ strtoupper(substr($inq->name, 0, 1)) }}
                                        </span>
                                        {{ $inq->name }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 font-normal">{{ $inq->created_at->diffForHumans() }}</span>
                                </div>
                                <a href="tel:{{ $inq->phone }}" class="text-xs text-emerald-600 font-bold mt-1.5 inline-block hover:underline">
                                    📞 {{ $inq->phone }}
                                </a>
                                <p class="text-xs text-slate-600 line-clamp-2 mt-1 italic">"{{ $inq->message }}"</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
