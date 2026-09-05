<?php

namespace App\Policies;

use App\Models\Inquiry;
use App\Models\User;

class InquiryPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view the inquiry list.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAgent();
    }

    /**
     * Determine whether the user can view the specific inquiry.
     * Only the submitter (buyer) or the listing agent/admin can view.
     */
    public function view(User $user, Inquiry $inquiry): bool
    {
        return $user->id === $inquiry->user_id
            || $user->id === $inquiry->property->agent_id;
    }

    /**
     * Determine whether the user can reply/update the inquiry status (Listing Agent).
     */
    public function reply(User $user, Inquiry $inquiry): bool
    {
        return $user->id === $inquiry->property->agent_id;
    }

    /**
     * Determine whether the user can delete the inquiry.
     */
    public function delete(User $user, Inquiry $inquiry): bool
    {
        return $user->isAdmin();
    }
}
