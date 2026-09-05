<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-950">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Gujarat Premier Realty') }} — Sign In</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased text-slate-800 min-h-full flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-950 relative overflow-hidden">
        <!-- Background Ambient Glow -->
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#059669_1px,transparent_1px)] [background-size:16px_16px]"></div>
        <div class="absolute w-96 h-96 bg-emerald-600/10 rounded-full blur-3xl pointer-events-none -top-20 -left-20"></div>

        <div class="relative z-10 w-full max-w-md">
            <!-- Brand Logo -->
            <div class="text-center mb-6">
                <a href="/" wire:navigate class="inline-flex items-center gap-2">
                    <span class="text-3xl">🏰</span>
                    <span class="font-black text-2xl tracking-tight text-white">Gujarat<span class="text-emerald-400">Realty</span></span>
                </a>
            </div>

            <!-- Main Auth Card -->
            <div class="w-full bg-white rounded-3xl p-8 shadow-2xl border border-slate-200">
                {{ $slot }}
            </div>
        </div>

        @livewireScripts
    </body>
</html>
