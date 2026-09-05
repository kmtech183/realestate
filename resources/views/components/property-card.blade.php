@props(['property'])

<div
    class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col">
    <!-- Property Image & Badges -->
    <div class="relative h-56 bg-slate-900 overflow-hidden">
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
        <div class="absolute top-3 right-3">
            <span
                class="px-2.5 py-1 text-xs font-bold rounded-lg uppercase tracking-wide {{ $property->property_type === 'sale' ? 'bg-emerald-500 text-white' : 'bg-indigo-600 text-white' }}">
                For {{ ucfirst($property->property_type) }}
            </span>
        </div>
    </div>

    <!-- Card Body -->
    <div class="p-5 flex-1 flex flex-col justify-between">
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
                    fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ $property->locality }},
                {{ $property->city }}
            </p>

            <!-- Specifications Metric Row -->
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

        <!-- Action Footer -->
        <div class="flex items-center justify-between pt-2">
            <div class="text-xs text-slate-400">
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
