<?php

namespace App\Policies;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IdeaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the idea.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Idea  $idea
     * @return mixed
     */
    public function view(User $user, Idea $idea)
    {
        return true;
    }

    /**
     * Determine whether the user can create ideas.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the idea.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Idea  $idea
     * @return mixed
     */
    public function update(User $user, Idea $idea)
    {
        return (int) $user->id === (int) $idea->user_id;
    }

    /**
     * Determine whether the user can delete the idea.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Idea  $idea
     * @return mixed
     */
    public function delete(User $user, Idea $idea)
    {
        return (int) $user->id === (int) $idea->user_id;
    }
}
