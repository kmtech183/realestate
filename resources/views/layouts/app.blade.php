<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="h-full bg-slate-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'Gujarat Premier Realty') }} —
        Luxury Real Estate Ahmedabad</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap"
        rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body
    class="font-sans antialiased text-slate-800 min-h-full flex flex-col justify-between">
    <div>
        <livewire:layout.navigation />

        <!-- Global Flash Messages Notification Toast -->
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show"
                x-init="setTimeout(() => show = false, 4000)"
                class="fixed bottom-5 right-5 z-50 bg-emerald-600 text-white px-5 py-3 rounded-2xl shadow-2xl flex items-center gap-3 transition-all">
                <span>✨</span>
                <span
                    class="text-sm font-semibold">{{ session('success') }}</span>
                <button @click="show = false"
                    class="text-emerald-200 hover:text-white font-bold ml-2">✕</button>
            </div>
        @endif

        <!-- Main Page Content -->
        <main>
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>

    <!-- Modern Footer -->
    <footer
        class="bg-slate-950 text-slate-400 border-t border-slate-900 mt-20">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div
                class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div
                        class="flex items-center gap-2 mb-3">
                        <span class="text-2xl">🏰</span>
                        <span
                            class="font-bold text-lg text-white">Gujarat<span
                                class="text-emerald-400">Realty</span></span>
                    </div>
                    <p
                        class="text-sm text-slate-500 max-w-sm">
                        Ahmedabad & Gandhinagar's most
                        trusted luxury real estate advisory.
                        High-value villas, sky penthouses,
                        and prime commercial plots.
                    </p>
                </div>
                <div>
                    <h4
                        class="text-sm font-bold text-white uppercase tracking-wider mb-3">
                        Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('properties.index') }}"
                                class="hover:text-emerald-400 transition">Browse
                                Properties</a></li>
                        <li><a href="{{ route('properties.index', ['type' => 'sale']) }}"
                                class="hover:text-emerald-400 transition">Buy
                                Property</a></li>
                        <li><a href="{{ route('properties.index', ['type' => 'rent']) }}"
                                class="hover:text-emerald-400 transition">Rent
                                Property</a></li>
                    </ul>
                </div>
                <div>
                    <h4
                        class="text-sm font-bold text-white uppercase tracking-wider mb-3">
                        Contact Support</h4>
                    <p class="text-sm text-slate-500">
                        Bodakdev / SG Highway, Ahmedabad,
                        Gujarat 380015</p>
                    <p
                        class="text-sm text-emerald-400 font-semibold mt-2">
                        +91 98765 43210</p>
                </div>
            </div>
            <div
                class="border-t border-slate-900 mt-8 pt-8 text-center text-xs text-slate-600">
                © {{ date('Y') }} GujaratRealty. Crafted
                with Laravel 13, Livewire 3 & Tailwind CSS.
            </div>
        </div>
    </footer>

    @livewireScripts
</body>

</html>
