<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }"
    class="bg-slate-900 border-b border-slate-800 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Brand Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-2">
                        <span class="text-2xl">🏰</span>
                        <span
                            class="font-extrabold text-lg tracking-tight text-white">Gujarat<span
                                class="text-emerald-400">Realty</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div
                    class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center px-1 pt-1 text-sm font-semibold transition {{ request()->routeIs('home') ? 'text-emerald-400 border-b-2 border-emerald-400' : 'text-slate-300 hover:text-white' }}">
                        Home
                    </a>
                    <a href="{{ route('properties.index') }}"
                        class="inline-flex items-center px-1 pt-1 text-sm font-semibold transition {{ request()->routeIs('properties.*') ? 'text-emerald-400 border-b-2 border-emerald-400' : 'text-slate-300 hover:text-white' }}">
                        Browse Properties
                    </a>
                    @auth
                        <a href="{{ route('favorites.index') }}"
                            class="inline-flex items-center px-1 pt-1 text-sm font-semibold transition {{ request()->routeIs('favorites.*') ? 'text-emerald-400 border-b-2 border-emerald-400' : 'text-slate-300 hover:text-white' }}">
                            Saved ❤️
                        </a>
                        @if (auth()->user()->isAgent())
                            <a href="{{ route('agent.dashboard') }}"
                                class="inline-flex items-center px-1 pt-1 text-sm font-semibold transition {{ request()->routeIs('agent.*') ? 'text-emerald-400 border-b-2 border-emerald-400' : 'text-slate-300 hover:text-white' }}">
                                Agent Portal
                            </a>
                        @endif
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center px-1 pt-1 text-sm font-semibold transition {{ request()->routeIs('admin.*') ? 'text-emerald-400 border-b-2 border-emerald-400' : 'text-slate-300 hover:text-white' }}">
                                Admin Panel
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Action / User Profile -->
            <div
                class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-slate-700 text-sm leading-4 font-semibold rounded-xl text-slate-200 bg-slate-800 hover:text-white hover:bg-slate-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ auth()->user()->name }}
                                </div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile')" wire:navigate>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <button wire:click="logout"
                                class="w-full text-start">
                                <x-dropdown-link>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </button>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}"
                            class="text-sm font-semibold text-slate-300 hover:text-white transition">Log
                            in</a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl shadow-md transition">Register</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger Button for Mobile -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none transition">
                    <svg class="h-6 w-6"
                        stroke="currentColor" fill="none"
                        viewBox="0 0 24 24">
                        <path
                            :class="{ 'hidden': open, 'inline-flex':
                                    !open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path
                            :class="{ 'hidden': !
                                open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Mobile Menu -->
    <div :class="{ 'block': open, 'hidden': !open }"
        class="hidden sm:hidden bg-slate-900 border-b border-slate-800 px-4 pt-2 pb-4 space-y-2">
        <a href="{{ route('home') }}"
            class="block text-slate-300 font-semibold py-2">Home</a>
        <a href="{{ route('properties.index') }}"
            class="block text-slate-300 font-semibold py-2">Browse
            Properties</a>
        @auth
            <a href="{{ route('favorites.index') }}"
                class="block text-slate-300 font-semibold py-2">Saved
                Properties</a>
            <a href="{{ route('profile') }}"
                class="block text-slate-300 font-semibold py-2">Profile</a>
            <button wire:click="logout"
                class="block w-full text-left text-red-400 font-semibold py-2">Log
                Out</button>
        @else
            <a href="{{ route('login') }}"
                class="block text-slate-300 font-semibold py-2">Log
                In</a>
            <a href="{{ route('register') }}"
                class="block text-emerald-400 font-semibold py-2">Register</a>
        @endauth
    </div>
</nav>
