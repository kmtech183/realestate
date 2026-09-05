<x-app-layout>
    <!-- Hero Section -->
    <div
        class="relative bg-slate-950 text-white overflow-hidden py-24 sm:py-32">
        <div
            class="absolute inset-0 opacity-20 bg-[radial-gradient(#059669_1px,transparent_1px)] [background-size:16px_16px]">
        </div>
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 mb-6">
                🏛️ Premier Gujarat Real Estate Portal
            </span>
            <h1
                class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight text-white max-w-4xl mx-auto">
                Luxury Living in <span
                    class="text-emerald-400">Ahmedabad</span>
                & Gandhinagar
            </h1>
            <p
                class="mt-6 text-base sm:text-xl text-slate-400 max-w-2xl mx-auto">
                Discover curated luxury sky penthouses,
                Mediterranean-style villas, and Grade-A
                commercial spaces with verified titles.
            </p>

            <div
                class="mt-10 flex flex-wrap justify-center gap-4">
                <a href="{{ route('properties.index') }}"
                    class="px-8 py-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-2xl shadow-xl shadow-emerald-900/30 transition text-sm sm:text-base">
                    Explore All Listings →
                </a>
                <a href="{{ route('properties.index', ['type' => 'sale']) }}"
                    class="px-8 py-4 bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold rounded-2xl border border-slate-700 transition text-sm sm:text-base">
                    Buy Properties
                </a>
                <a href="{{ route('properties.index', ['type' => 'rent']) }}"
                    class="px-8 py-4 bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold rounded-2xl border border-slate-700 transition text-sm sm:text-base">
                    Rent Homes
                </a>
            </div>
        </div>
    </div>

    <!-- Live Reactive Catalog Component on Home -->
    <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 relative z-20">
        <livewire:property-catalog />
    </div>
</x-app-layout>
