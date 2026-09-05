<div>
    <!-- Hero / Top Filter Bar -->
    <div
        class="bg-slate-900 py-10 px-4 sm:px-6 lg:px-8 text-white rounded-3xl mb-8 shadow-2xl relative overflow-hidden">
        <div
            class="absolute inset-0 bg-gradient-to-r from-emerald-600/20 to-indigo-600/20 pointer-events-none">
        </div>
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-8">
                <span
                    class="inline-block px-3 py-1 bg-emerald-500/20 text-emerald-400 text-xs font-semibold uppercase tracking-wider rounded-full mb-3">
                    Ahmedabad & Gandhinagar Prime Real
                    Estate
                </span>
                <h1
                    class="text-3xl sm:text-5xl font-extrabold tracking-tight">
                    Find Your Dream Residence</h1>
                <p
                    class="mt-3 text-slate-400 text-sm sm:text-base">
                    Explore verified luxury villas, sky
                    penthouses, and commercial spaces.</p>
            </div>

            <!-- Search Inputs Bar -->
            <div
                class="bg-white/10 backdrop-blur-md p-4 sm:p-6 rounded-2xl border border-white/20 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 shadow-lg">
                <!-- Search Keyword -->
                <div class="lg:col-span-2">
                    <label
                        class="block text-xs font-medium text-slate-300 mb-1">Keywords
                        / Location</label>
                    <input type="text"
                        wire:model.live.debounce.350ms="search"
                        placeholder="Search Bodakdev, SG Highway, Villa..."
                        class="w-full bg-white/15 text-white placeholder-slate-400 rounded-xl px-4 py-2.5 text-sm border border-white/20 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:bg-slate-800 transition" />
                </div>

                <!-- Type (Buy / Rent) -->
                <div>
                    <label
                        class="block text-xs font-medium text-slate-300 mb-1">Property
                        Type</label>
                    <select wire:model.live="propertyType"
                        class="w-full bg-slate-800 text-white rounded-xl px-3 py-2.5 text-sm border border-white/20 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        <option value="">All Types
                            (Buy & Rent)</option>
                        <option value="sale">For Sale
                            (Buy)</option>
                        <option value="rent">For Rent
                        </option>
                    </select>
                </div>

                <!-- Category -->
                <div>
                    <label
                        class="block text-xs font-medium text-slate-300 mb-1">Category</label>
                    <select
                        wire:model.live="selectedCategory"
                        class="w-full bg-slate-800 text-white rounded-xl px-3 py-2.5 text-sm border border-white/20 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        <option value="">All
                            Categories</option>
                        @foreach ($categories as $cat)
                            <option
                                value="{{ $cat->slug }}">
                                {{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- BHK -->
                <div>
                    <label
                        class="block text-xs font-medium text-slate-300 mb-1">Bedrooms
                        (BHK)</label>
                    <select wire:model.live="bedrooms"
                        class="w-full bg-slate-800 text-white rounded-xl px-3 py-2.5 text-sm border border-white/20 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        <option value="">Any BHK
                        </option>
                        <option value="2">2 BHK
                        </option>
                        <option value="3">3 BHK
                        </option>
                        <option value="4">4 BHK
                        </option>
                        <option value="4+">5+ BHK / Sky
                            Villa</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <div class="w-full lg:w-72 shrink-0">
                <div
                    class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm sticky top-6">
                    <div
                        class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <h3
                            class="font-bold text-slate-800 text-base">
                            Filter Properties</h3>
                        <button wire:click="resetFilters"
                            class="text-xs text-emerald-600 hover:text-emerald-700 font-semibold hover:underline">
                            Reset All
                        </button>
                    </div>

                    <!-- Locality Filter -->
                    <div class="mt-5">
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Locality</label>
                        <select wire:model.live="locality"
                            class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            <option value="">All
                                Localities</option>
                            @foreach ($localities as $loc)
                                <option
                                    value="{{ $loc }}">
                                    {{ $loc }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="mt-6">
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Price
                            Range (₹)</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number"
                                wire:model.live.debounce.500ms="minPrice"
                                placeholder="Min ₹"
                                class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none" />
                            <input type="number"
                                wire:model.live.debounce.500ms="maxPrice"
                                placeholder="Max ₹"
                                class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none" />
                        </div>
                    </div>

                    <!-- Sort Order -->
                    <div class="mt-6">
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Sort
                            By</label>
                        <select wire:model.live="sortBy"
                            class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            <option value="latest">Newest
                                First</option>
                            <option value="price_low">Price:
                                Low to High</option>
                            <option value="price_high">
                                Price: High to Low</option>
                            <option value="popular">Most
                                Popular</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Property Cards Grid -->
            <div class="flex-1">
                <!-- Loading indicator -->
                <div wire:loading
                    class="w-full py-4 text-center">
                    <span
                        class="inline-flex items-center gap-2 text-emerald-600 font-medium text-sm">
                        <svg class="animate-spin h-5 w-5"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25"
                                cx="12"
                                cy="12" r="10"
                                stroke="currentColor"
                                stroke-width="4"
                                fill="none"></circle>
                            <path class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8v8H4z">
                            </path>
                        </svg>
                        Updating listings...
                    </span>
                </div>

                @if ($properties->isEmpty())
                    <div
                        class="bg-white rounded-2xl p-12 text-center border border-slate-200">
                        <div
                            class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3
                            class="text-lg font-bold text-slate-800">
                            No properties found</h3>
                        <p
                            class="text-slate-500 text-sm mt-1">
                            Try adjusting your filters or
                            search keywords.</p>
                        <button wire:click="resetFilters"
                            class="mt-4 px-4 py-2 bg-emerald-600 text-white rounded-xl text-sm font-semibold hover:bg-emerald-700 transition">
                            Clear Filters
                        </button>
                    </div>
                @else
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach ($properties as $property)
                            <div
                                class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col">
                                <!-- Image & Badges -->
                                <div
                                    class="relative h-56 bg-slate-900 overflow-hidden">
                                    <img src="{{ $property->image_url }}"
                                        alt="{{ $property->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        loading="lazy" />

                                    <!-- Price Tag Top Left -->
                                    <div
                                        class="absolute top-3 left-3 bg-slate-900/90 backdrop-blur-md text-white px-3 py-1.5 rounded-xl text-sm font-bold shadow-lg">
                                        {{ $property->formatted_price }}
                                        @if ($property->property_type === 'rent')
                                            <span
                                                class="text-xs text-slate-300 font-normal">/
                                                mo</span>
                                        @endif
                                    </div>

                                    <!-- Type Badge Top Right -->
                                    <div
                                        class="absolute top-3 right-3">
                                        <span
                                            class="px-2.5 py-1 text-xs font-bold rounded-lg uppercase tracking-wide {{ $property->property_type === 'sale' ? 'bg-emerald-500 text-white' : 'bg-indigo-600 text-white' }}">
                                            For
                                            {{ ucfirst($property->property_type) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div
                                    class="p-5 flex-1 flex flex-col justify-between">
                                    <div>
                                        <span
                                            class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">{{ $property->category->name }}</span>
                                        <h3
                                            class="font-bold text-slate-900 text-base mt-1 line-clamp-1 group-hover:text-emerald-600 transition">
                                            <a
                                                href="{{ route('properties.show', $property->slug) }}">{{ $property->title }}</a>
                                        </h3>
                                        <p
                                            class="text-slate-500 text-xs mt-1 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $property->locality }},
                                            {{ $property->city }}
                                        </p>

                                        <!-- Specifications Row -->
                                        <div
                                            class="grid grid-cols-3 gap-2 py-3 my-3 border-y border-slate-100 text-center text-xs text-slate-600">
                                            <div>
                                                <span
                                                    class="block font-bold text-slate-900">{{ $property->bedrooms }}
                                                    BHK</span>
                                                <span
                                                    class="text-[11px] text-slate-400">Bedrooms</span>
                                            </div>
                                            <div>
                                                <span
                                                    class="block font-bold text-slate-900">{{ $property->bathrooms }}</span>
                                                <span
                                                    class="text-[11px] text-slate-400">Baths</span>
                                            </div>
                                            <div>
                                                <span
                                                    class="block font-bold text-slate-900">{{ number_format($property->area_sqft) }}</span>
                                                <span
                                                    class="text-[11px] text-slate-400">Sq.Ft</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card Action Footer -->
                                    <div
                                        class="flex items-center justify-between pt-2">
                                        <div
                                            class="text-xs text-slate-400">
                                            👁️
                                            {{ number_format($property->view_count) }}
                                            views
                                        </div>
                                        <a href="{{ route('properties.show', $property->slug) }}"
                                            class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-semibold hover:bg-emerald-600 transition duration-200">
                                            View Details →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-10">
                        {{ $properties->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
