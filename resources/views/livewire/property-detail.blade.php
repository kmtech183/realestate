<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumbs -->
    <div
        class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div
                class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                <a href="{{ route('properties.index') }}"
                    class="hover:text-emerald-600">Properties</a>
                <span>/</span>
                <span
                    class="text-slate-600">{{ $property->city }}</span>
                <span>/</span>
                <span
                    class="text-slate-800 font-semibold">{{ $property->locality }}</span>
            </div>
            <h1
                class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                {{ $property->title }}</h1>
            <p
                class="text-slate-500 text-sm mt-1 flex items-center gap-1.5">
                📍 {{ $property->address }},
                {{ $property->city }},
                {{ $property->state }} -
                {{ $property->pincode }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <div class="text-right">
                <span
                    class="text-xs text-slate-400 uppercase font-semibold">Listing
                    Price</span>
                <div
                    class="text-2xl sm:text-3xl font-black text-emerald-600">
                    {{ $property->formatted_price }}
                    @if ($property->property_type === 'rent')
                        <span
                            class="text-sm font-normal text-slate-500">/
                            month</span>
                    @endif
                </div>
            </div>

            @auth
                <form
                    action="{{ route('favorites.toggle', $property->id) }}"
                    method="POST">
                    @csrf
                    <button type="submit"
                        class="p-3 bg-white border border-slate-200 rounded-2xl hover:bg-rose-50 hover:text-rose-600 shadow-sm transition">
                        ❤️
                    </button>
                </form>
            @endauth
        </div>
    </div>

    <!-- Gallery & Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <!-- Interactive Gallery -->
            <div
                class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm p-4">
                <div
                    class="h-80 sm:h-[450px] bg-slate-900 rounded-2xl overflow-hidden relative">
                    <img src="{{ $activeImage }}"
                        alt="{{ $property->title }}"
                        class="w-full h-full object-cover transition-all duration-300" />
                    <span
                        class="absolute top-4 left-4 bg-slate-900/80 text-white text-xs px-3 py-1 rounded-xl font-bold uppercase backdrop-blur-md">
                        For
                        {{ ucfirst($property->property_type) }}
                    </span>
                </div>

                @if ($property->getMedia('images')->count() > 1)
                    <div
                        class="flex gap-3 mt-4 overflow-x-auto pb-2">
                        @foreach ($property->getMedia('images') as $media)
                            <button type="button"
                                wire:click="selectImage('{{ $media->getUrl() }}')"
                                class="w-20 h-20 rounded-xl overflow-hidden shrink-0 border-2 transition focus:outline-none {{ $activeImage === $media->getUrl() ? 'border-emerald-500 ring-2 ring-emerald-200' : 'border-transparent opacity-70 hover:opacity-100' }}">
                                <img src="{{ $media->getUrl('thumb') }}"
                                    class="w-full h-full object-cover" />
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Specifications Metric Bar -->
            <div
                class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                <div class="p-3 bg-slate-50 rounded-2xl">
                    <span
                        class="text-xs text-slate-400 block font-semibold">Configuration</span>
                    <span
                        class="text-base sm:text-lg font-bold text-slate-800">{{ $property->bedrooms }}
                        BHK</span>
                </div>
                <div class="p-3 bg-slate-50 rounded-2xl">
                    <span
                        class="text-xs text-slate-400 block font-semibold">Super
                        Area</span>
                    <span
                        class="text-base sm:text-lg font-bold text-slate-800">{{ number_format($property->area_sqft) }}
                        sq.ft</span>
                </div>
                <div class="p-3 bg-slate-50 rounded-2xl">
                    <span
                        class="text-xs text-slate-400 block font-semibold">Bathrooms</span>
                    <span
                        class="text-base sm:text-lg font-bold text-slate-800">{{ $property->bathrooms }}
                        Baths</span>
                </div>
                <div class="p-3 bg-slate-50 rounded-2xl">
                    <span
                        class="text-xs text-slate-400 block font-semibold">Balconies</span>
                    <span
                        class="text-base sm:text-lg font-bold text-slate-800">{{ $property->balconies }}
                        Balconies</span>
                </div>
            </div>

            <!-- Description -->
            <div
                class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                <h3
                    class="text-lg font-bold text-slate-900 mb-4">
                    Property Description</h3>
                <div
                    class="text-slate-600 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                    {{ $property->description }}
                </div>
            </div>

            <!-- Amenities -->
            @if ($property->features->isNotEmpty())
                <div
                    class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                    <h3
                        class="text-lg font-bold text-slate-900 mb-4">
                        Amenities & Premium Features</h3>
                    <div
                        class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach ($property->features as $feature)
                            <div
                                class="flex items-center gap-2 p-3 bg-emerald-50/60 border border-emerald-100 rounded-xl text-emerald-900 text-xs font-semibold">
                                <span>✨</span>
                                <span>{{ $feature->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Similar Properties Grid -->
            @if ($similarProperties->isNotEmpty())
                <div class="mt-12">
                    <h3
                        class="text-xl font-bold text-slate-900 mb-6">
                        Similar Properties in
                        {{ $property->city }}</h3>
                    <div
                        class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($similarProperties as $sim)
                            <x-property-card
                                :property="$sim" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sticky Sidebar with Inquiry & Modal Trigger -->
        <div class="lg:col-span-1">
            <livewire:property-inquiry-form
                :property="$property" />
        </div>
    </div>
</div>
