<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Story;
use Illuminate\Auth\Access\HandlesAuthorization;

class StoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create stories.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return (!! $user->email_verified_at);
    }

    /**
     * Determine whether the user can update the story.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Story  $story
     * @return mixed
     */
    public function update(User $user, Story $story)
    {
        return $user->id == $story->id;
    }

    /**
     * Determine whether the user can delete the story.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Story  $story
     * @return mixed
     */
    public function delete(User $user, Story $story)
    {
        return $user->id == $story->id;
    }

    /**
     * Determine whether the user can restore the story.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Story  $story
     * @return mixed
     */
    public function restore(User $user, Story $story)
    {
        return $user->id == $story->id;
    }

    /**
     * Determine whether the user can permanently delete the story.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Story  $story
     * @return mixed
     */
    public function forceDelete(User $user, Story $story)
    {
        return $user->id == $story->id;
    }
}
