<x-app-layout>
    <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <span
                class="text-xs font-bold uppercase text-emerald-600 tracking-wider">Your
                Shortlist</span>
            <h1
                class="text-3xl font-black text-slate-900 mt-1">
                Saved Properties ❤️</h1>
            <p class="text-sm text-slate-500 mt-1">Properties
                you have shortlisted for quick access and
                price tracking.</p>
        </div>

        @if ($favorites->isEmpty())
            <div
                class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm max-w-lg mx-auto">
                <div class="text-4xl mb-3">🏡</div>
                <h3 class="text-lg font-bold text-slate-800">
                    No saved properties yet</h3>
                <p class="text-slate-500 text-sm mt-1 mb-6">
                    Browse listings and click the heart icon
                    to save your favorite homes.</p>
                <a href="{{ route('properties.index') }}"
                    class="px-6 py-3 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-2xl text-xs transition">
                    Browse Ahmedabad Properties →
                </a>
            </div>
        @else
            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($favorites as $property)
                    <x-property-card :property="$property" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $favorites->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
