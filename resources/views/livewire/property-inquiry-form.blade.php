<div
    class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm sticky top-6">
    <div
        class="flex items-center gap-3 pb-4 border-b border-slate-100">
        <div
            class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-bold">
            🏢
        </div>
        <div>
            <h4 class="font-bold text-slate-900 text-sm">
                Contact Listing Agent</h4>
            <p class="text-xs text-slate-500">
                {{ $property->agent->agency_name ?? 'Premier Realty' }}
            </p>
        </div>
    </div>

    @if ($submitted)
        <div
            class="my-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 text-center">
            <div class="text-2xl mb-1">🎉</div>
            <h5 class="font-bold text-sm">Inquiry Received!
            </h5>
            <p class="text-xs text-emerald-700 mt-1">The
                listing agent has been notified and will
                contact you promptly.</p>
        </div>
    @else
        <form wire:submit="submitInquiry"
            class="mt-4 space-y-3">
            <div>
                <label
                    class="block text-xs font-semibold text-slate-700 mb-1">Your
                    Full Name</label>
                <input type="text" wire:model="name"
                    class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    placeholder="e.g. Pooja Mehta" />
                @error('name')
                    <span
                        class="text-[11px] text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label
                    class="block text-xs font-semibold text-slate-700 mb-1">Email
                    Address</label>
                <input type="email" wire:model="email"
                    class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    placeholder="pooja@example.com" />
                @error('email')
                    <span
                        class="text-[11px] text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label
                    class="block text-xs font-semibold text-slate-700 mb-1">Phone
                    / WhatsApp</label>
                <input type="tel" wire:model="phone"
                    class="w-full border border-slate-300 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    placeholder="+91 98765 43210" />
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
                wire:loading.attr="disabled"
                class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition duration-200 shadow-md">
                <span wire:loading.remove>Send Inquiry Now
                    →</span>
                <span wire:loading>Sending...</span>
            </button>
        </form>
    @endif
</div>
