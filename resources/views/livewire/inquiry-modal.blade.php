<div>
    @if ($isOpen && $property)
        <div
            class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div
                class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl relative">
                <button wire:click="closeModal"
                    class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 text-xl font-bold">✕</button>

                <div class="mb-4">
                    <span
                        class="text-xs font-bold uppercase text-emerald-600 tracking-wider">Quick
                        Inquiry</span>
                    <h3
                        class="text-lg font-extrabold text-slate-900 mt-1">
                        {{ $property->title }}</h3>
                    <p class="text-xs text-slate-500">📍
                        {{ $property->locality }},
                        {{ $property->city }}</p>
                </div>

                @if ($submitted)
                    <div
                        class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-6 text-center">
                        <div class="text-3xl mb-2">🎉</div>
                        <h4 class="font-bold text-base">
                            Inquiry Submitted!</h4>
                        <p
                            class="text-xs text-emerald-700 mt-1">
                            Our listing agent will reach out
                            to you within 24 hours.</p>
                        <button wire:click="closeModal"
                            class="mt-4 px-4 py-2 bg-emerald-600 text-white font-bold rounded-xl text-xs">
                            Close Window
                        </button>
                    </div>
                @else
                    <form wire:submit="submit"
                        class="space-y-3">
                        <div>
                            <label
                                class="block text-xs font-semibold text-slate-700 mb-1">Your
                                Name</label>
                            <input type="text"
                                wire:model="name"
                                class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none" />
                            @error('name')
                                <span
                                    class="text-[11px] text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-slate-700 mb-1">Email
                                Address</label>
                            <input type="email"
                                wire:model="email"
                                class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none" />
                            @error('email')
                                <span
                                    class="text-[11px] text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-slate-700 mb-1">Phone
                                Number</label>
                            <input type="tel"
                                wire:model="phone"
                                class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none" />
                            @error('phone')
                                <span
                                    class="text-[11px] text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-slate-700 mb-1">Message</label>
                            <textarea wire:model="message" rows="3"
                                class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none"></textarea>
                            @error('message')
                                <span
                                    class="text-[11px] text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition duration-200 shadow-md">
                            Submit Inquiry Now →
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @endif
</div>
