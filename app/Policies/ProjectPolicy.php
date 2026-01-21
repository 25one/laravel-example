<?php

namespace App\Policies;

use App\Models\ {User, Project};

class ProjectPolicy extends Policy
{
    /**
     * Determine whether the user can manage the comment.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Project $project
     * @return mixed
     */
    public function manage(User $user, Project $project)
    {
        return $user->id === $project->user_id;
    }
}
