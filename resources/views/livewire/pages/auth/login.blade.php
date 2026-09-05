<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="space-y-6">
    <!-- Header -->
    <div class="text-center">
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Welcome Back</h2>
        <p class="text-xs text-slate-500 mt-1">Sign in to manage listings, inquiries, and VIP property tours.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-4">
        <!-- Email Address -->
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Email Address</label>
            <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username"
                placeholder="agent@example.com"
                class="w-full bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition shadow-sm" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 hover:underline" href="{{ route('password.request') }}" wire:navigate>
                        Forgot password?
                    </a>
                @endif
            </div>

            <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password"
                placeholder="••••••••"
                class="w-full bg-slate-50 hover:bg-white focus:bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition shadow-sm" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember" class="inline-flex items-center cursor-pointer">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded-lg border-slate-300 text-emerald-600 shadow-sm focus:ring-emerald-500">
                <span class="ms-2 text-xs font-medium text-slate-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div>
            <button type="submit" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold rounded-2xl text-sm transition shadow-xl shadow-emerald-900/20 flex items-center justify-center gap-2">
                <span>🔐</span> Sign In to Account
            </button>
        </div>
    </form>

    <div class="pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
        Don't have an account? 
        <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:underline">Register here</a>
    </div>
</div>
