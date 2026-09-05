<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filter Sidebar -->
            <div class="w-full lg:w-72 shrink-0">
                <div
                    class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm sticky top-24">
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

                    <!-- Search Box -->
                    <div class="mt-4">
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Keywords</label>
                        <input type="text"
                            wire:model.live.debounce.350ms="search"
                            placeholder="Search..."
                            class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none" />
                    </div>

                    <!-- Property Type -->
                    <div class="mt-4">
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Type</label>
                        <select
                            wire:model.live="propertyType"
                            class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            <option value="">All (Sale
                                & Rent)</option>
                            <option value="sale">For Sale
                            </option>
                            <option value="rent">For Rent
                            </option>
                        </select>
                    </div>

                    <!-- Category -->
                    <div class="mt-4">
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Category</label>
                        <select
                            wire:model.live="selectedCategory"
                            class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            <option value="">All
                                Categories</option>
                            @foreach ($categories as $cat)
                                <option
                                    value="{{ $cat->slug }}">
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Locality -->
                    <div class="mt-4">
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Locality</label>
                        <select wire:model.live="locality"
                            class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
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

                    <!-- BHK -->
                    <div class="mt-4">
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Bedrooms
                            (BHK)</label>
                        <select wire:model.live="bedrooms"
                            class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            <option value="">Any BHK
                            </option>
                            <option value="2">2 BHK
                            </option>
                            <option value="3">3 BHK
                            </option>
                            <option value="4">4 BHK
                            </option>
                            <option value="4+">5+ BHK
                            </option>
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="mt-4">
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Price
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
                    <div class="mt-4">
                        <label
                            class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Sort
                            By</label>
                        <select wire:model.live="sortBy"
                            class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
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
                @if ($properties->isEmpty())
                    <div
                        class="bg-white rounded-2xl p-12 text-center border border-slate-200">
                        <h3
                            class="text-lg font-bold text-slate-800">
                            No properties found</h3>
                        <p
                            class="text-slate-500 text-sm mt-1">
                            Try adjusting your filters.</p>
                    </div>
                @else
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach ($properties as $property)
                            <x-property-card
                                :property="$property" />
                        @endforeach
                    </div>

                    <div class="mt-10">
                        {{ $properties->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
