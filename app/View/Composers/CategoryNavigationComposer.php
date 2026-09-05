<?php

namespace App\View\Composers;

use App\Models\PropertyCategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CategoryNavigationComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $categories = Cache::remember('global:navigation_categories', 3600, function () {
            return PropertyCategory::withCount(['properties' => fn($q) => $q->active()])
                ->orderBy('name')
                ->get();
        });

        $view->with('globalCategories', $categories);
    }
}
