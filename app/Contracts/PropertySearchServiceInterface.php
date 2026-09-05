<?php

namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PropertySearchServiceInterface
{
    /**
     * Search and filter properties based on criteria array.
     */
    public function search(array $filters, int $perPage = 9): LengthAwarePaginator;

    /**
     * Retrieve featured properties for hero sections.
     */
    public function getFeatured(int $limit = 6);

    /**
     * Retrieve price statistics by city.
     */
    public function getCityMarketStats(): array;
}
