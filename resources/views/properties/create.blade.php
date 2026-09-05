<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-200">
            <div>
                <a href="{{ route('agent.dashboard') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1 mb-2">
                    ← Back to Dashboard
                </a>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Create Luxury Listing</h1>
                <p class="text-sm text-slate-500 mt-1">Fill in property details, configurations, pricing, and upload high-res photography.</p>
            </div>
            <div class="hidden sm:flex items-center gap-2 bg-emerald-50 border border-emerald-100 px-4 py-2 rounded-2xl">
                <span class="text-emerald-600 font-bold text-xs">🏛️ GujaratRealty Verified Agent</span>
            </div>
        </div>

        <form action="{{ route('agent.properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Section 1: Basic Information -->
            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                    <div class="w-9 h-9 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-bold text-sm">
                        1
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Basic Information</h3>
                        <p class="text-xs text-slate-400">Headline, property category, and pricing strategy.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Property Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" required 
                            class="w-full bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition shadow-sm" 
                            placeholder="e.g. 4 BHK Ultra Luxury Sky Villa in Bodakdev" />
                        @error('title') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Category</label>
                        <select name="category_id" required class="w-full bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition shadow-sm">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Listing Type</label>
                        <select name="property_type" required class="w-full bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition shadow-sm">
                            <option value="sale">For Sale (Outright Purchase)</option>
                            <option value="rent">For Rent (Monthly Lease)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Asking Price (₹ INR)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-slate-400 font-bold text-sm">₹</span>
                            <input type="number" step="any" name="price" value="{{ old('price') }}" required 
                                class="w-full pl-8 bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition shadow-sm" 
                                placeholder="25000000" />
                        </div>
                        @error('price') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Super Built-up Area (Sq.Ft)</label>
                        <div class="relative">
                            <input type="number" step="any" name="area_sqft" value="{{ old('area_sqft') }}" required 
                                class="w-full bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition shadow-sm" 
                                placeholder="3800" />
                            <span class="absolute right-4 top-3.5 text-slate-400 text-xs font-semibold">sq.ft</span>
                        </div>
                        @error('area_sqft') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Layout & Configuration -->
            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                    <div class="w-9 h-9 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-bold text-sm">
                        2
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Specifications & Layout</h3>
                        <p class="text-xs text-slate-400">Bedrooms, bathrooms, balconies, and internal layout.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Bedrooms (BHK)</label>
                        <input type="number" name="bedrooms" value="{{ old('bedrooms', 3) }}" min="0" max="20" required 
                            class="w-full bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition shadow-sm" />
                        @error('bedrooms') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Bathrooms</label>
                        <input type="number" name="bathrooms" value="{{ old('bathrooms', 3) }}" min="0" max="20" required 
                            class="w-full bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition shadow-sm" />
                        @error('bathrooms') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Balconies</label>
                        <input type="number" name="balconies" value="{{ old('balconies', 2) }}" min="0" max="10" required 
                            class="w-full bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition shadow-sm" />
                        @error('balconies') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Section 3: Location Details -->
            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                    <div class="w-9 h-9 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-bold text-sm">
                        3
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Location & Address</h3>
                        <p class="text-xs text-slate-400">Neighborhood, city, and postal code in Gujarat.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Locality / Area</label>
                        <input type="text" name="locality" value="{{ old('locality', 'Bodakdev') }}" required 
                            class="w-full bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition shadow-sm" 
                            placeholder="e.g. SG Highway, Bodakdev" />
                        @error('locality') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">City</label>
                        <input type="text" name="city" value="{{ old('city', 'Ahmedabad') }}" required 
                            class="w-full bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition shadow-sm" />
                        @error('city') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Pincode</label>
                        <input type="text" name="pincode" value="{{ old('pincode', '380015') }}" required 
                            class="w-full bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition shadow-sm" 
                            placeholder="380015" />
                        @error('pincode') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Complete Address</label>
                        <input type="text" name="address" value="{{ old('address') }}" required 
                            class="w-full bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition shadow-sm" 
                            placeholder="Tower 4, Near Sindhu Bhavan Road, Bodakdev" />
                        @error('address') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Section 4: Narrative & Media Upload -->
            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                    <div class="w-9 h-9 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center font-bold text-sm">
                        4
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Description & Gallery</h3>
                        <p class="text-xs text-slate-400">Property story, unique selling points, and high-res photography.</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Detailed Property Description</label>
                        <textarea name="description" rows="4" required 
                            class="w-full bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-2xl p-4 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition shadow-sm" 
                            placeholder="Describe architecture, flooring, interior fittings, terrace views, society amenities, and nearby landmarks...">{{ old('description') }}</textarea>
                        @error('description') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Upload Property Photos</label>
                        <div class="border-2 border-dashed border-slate-200 hover:border-emerald-400 rounded-3xl p-8 text-center bg-slate-50/50 hover:bg-emerald-50/20 transition cursor-pointer relative">
                            <input type="file" name="images[]" multiple accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-3 text-xl">
                                📸
                            </div>
                            <h4 class="font-bold text-slate-800 text-sm">Click or Drag & Drop Property Images</h4>
                            <p class="text-xs text-slate-400 mt-1">Upload multiple photos (JPEG, PNG, WEBP up to 5MB each)</p>
                        </div>
                        @error('images') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        @error('images.*') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Action -->
            <div class="flex items-center justify-end gap-4 pt-4">
                <a href="{{ route('agent.dashboard') }}" class="px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-2xl text-sm transition">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold rounded-2xl text-sm transition shadow-xl shadow-emerald-900/20 flex items-center gap-2">
                    <span>✨</span> Publish Property Listing
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
