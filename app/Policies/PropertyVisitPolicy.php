<?php

namespace App\Policies;

use App\Models\PropertyVisit;
use App\Models\User;

class PropertyVisitPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->isAgent();
    }

    public function view(User $user, PropertyVisit $visit): bool
    {
        return $user->id === $visit->user_id
            || $user->id === $visit->property->agent_id;
    }

    public function updateStatus(User $user, PropertyVisit $visit): bool
    {
        return $user->id === $visit->property->agent_id;
    }
}
