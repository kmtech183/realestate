<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Header -->
        <div class="mb-8">
            <span class="text-xs font-bold uppercase text-indigo-600 tracking-wider">Super Administrator</span>
            <h1 class="text-3xl font-black text-slate-900 mt-1">Platform Control Center</h1>
            <p class="text-sm text-slate-500 mt-1">System-wide real estate metrics, agent directories, and customer leads.</p>
        </div>

        <!-- Metrics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <span class="text-xs font-semibold text-slate-400 uppercase">Total Properties</span>
                <div class="text-3xl font-black text-slate-900 mt-2">{{ $stats['total_properties'] }}</div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <span class="text-xs font-semibold text-slate-400 uppercase">Active Agents</span>
                <div class="text-3xl font-black text-indigo-600 mt-2">{{ $stats['total_agents'] }}</div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <span class="text-xs font-semibold text-slate-400 uppercase">Registered Buyers</span>
                <div class="text-3xl font-black text-emerald-600 mt-2">{{ $stats['total_buyers'] }}</div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <span class="text-xs font-semibold text-slate-400 uppercase">Total Inquiries</span>
                <div class="text-3xl font-black text-amber-600 mt-2">{{ $stats['total_inquiries'] }}</div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <span class="text-xs font-semibold text-slate-400 uppercase">Categories</span>
                <div class="text-3xl font-black text-slate-900 mt-2">{{ $stats['total_categories'] }}</div>
            </div>
        </div>

        <!-- Split View: Latest Platform Properties & Inquiries -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Properties Table -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <h3 class="font-black text-slate-900 text-lg mb-4">Latest Listed Properties</h3>
                <div class="divide-y divide-slate-100">
                    @foreach($recentProperties as $prop)
                        <div class="py-3 flex items-center justify-between">
                            <div>
                                <h4 class="font-bold text-sm text-slate-900">{{ $prop->title }}</h4>
                                <p class="text-xs text-slate-400">Agent: {{ $prop->agent->name ?? 'Admin' }} · {{ $prop->category->name }}</p>
                            </div>
                            <span class="font-bold text-emerald-600 text-sm">{{ $prop->formatted_price }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Inquiries Table -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <h3 class="font-black text-slate-900 text-lg mb-4">Latest Client Leads</h3>
                <div class="divide-y divide-slate-100">
                    @foreach($recentInquiries as $inq)
                        <div class="py-3">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-sm text-slate-900">{{ $inq->name }}</span>
                                <span class="text-xs text-slate-400">{{ $inq->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">Property: {{ $inq->property->title }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">📞 {{ $inq->phone }} | 📧 {{ $inq->email }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
