<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;

class PropertyPolicy
{
    /**
     * Perform pre-authorization checks.
     * Admins have full access to all property actions.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null; // Fall through to specific methods
    }

    /**
     * Determine whether the user can view any models (Public catalog).
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the specific property.
     * Active properties are public; inactive/pending ones are only visible to the owner agent or admin.
     */
    public function view(?User $user, Property $property): bool
    {
        if ($property->status === 'active') {
            return true;
        }

        return $user !== null && $user->id === $property->agent_id;
    }

    /**
     * Determine whether the user can create properties (Agents & Admins).
     */
    public function create(User $user): bool
    {
        return $user->isAgent();
    }

    /**
     * Determine whether the user can update the property (Owner Agent or Admin).
     */
    public function update(User $user, Property $property): bool
    {
        return $user->id === $property->agent_id;
    }

    /**
     * Determine whether the user can delete the property (Owner Agent or Admin).
     */
    public function delete(User $user, Property $property): bool
    {
        return $user->id === $property->agent_id;
    }

    /**
     * Determine whether the user can upload/manage media on the property.
     */
    public function manageMedia(User $user, Property $property): bool
    {
        return $user->id === $property->agent_id;
    }
}
