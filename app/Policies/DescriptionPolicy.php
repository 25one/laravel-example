<?php

namespace App\Policies;

use App\Models\ {User, Description};

class DescriptionPolicy extends Policy
{
    /**
     * Determine whether the user can manage the comment.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Description $description
     * @return mixed
     */
    public function manage(User $user, Description $description)
    {
        return $user->id === $description->user_id;
    }
}
