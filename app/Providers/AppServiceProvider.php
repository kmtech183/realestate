<?php

namespace App\Providers;

use App\Contracts\PropertySearchServiceInterface;
use App\Models\Inquiry;
use App\Models\Property;
use App\Models\PropertyVisit;
use App\Models\User;
use App\Observers\PropertyObserver;
use App\Policies\InquiryPolicy;
use App\Policies\PropertyPolicy;
use App\Policies\PropertyVisitPolicy;
use App\Services\PropertySearchService;
use App\View\Composers\CategoryNavigationComposer;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind Interface to Concrete Service Implementation (Singleton for performance)
        $this->app->singleton(PropertySearchServiceInterface::class, PropertySearchService::class);
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Explicit Policy Bindings (Ensures zero ambiguity)
        Gate::policy(Property::class, PropertyPolicy::class);
        Gate::policy(Inquiry::class, InquiryPolicy::class);
        Gate::policy(PropertyVisit::class, PropertyVisitPolicy::class);

        // 2. Global Role-Based Gates
        Gate::define('access-admin-panel', fn(User $user) => $user->isAdmin());
        Gate::define('access-agent-portal', fn(User $user) => $user->isAgent());
        Gate::define('manage-properties', fn(User $user) => $user->isAgent());

        // 3. Register Model Observers for Automated Cache Invalidation
        Property::observe(\App\Observers\PropertyObserver::class);

        // 4. View Composers for Global Navigation
        View::composer(['layouts.app', 'welcome', 'livewire.layout.navigation'], CategoryNavigationComposer::class);
    }
}
