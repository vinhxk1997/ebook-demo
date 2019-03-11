<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Chapter;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChapterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the chapter.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chapter  $chapter
     * @return mixed
     */
    public function view(User $user, Chapter $chapter)
    {
        return $chapter->status == Chapter::STATUS_PUBLISH || $user->id == $chapter->story->user_id;
    }

    /**
     * Determine whether the user can create chapters.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the chapter.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chapter  $chapter
     * @return mixed
     */
    public function update(User $user, Chapter $chapter)
    {
        return $user->id == $chapter->story->user_id;
    }

    /**
     * Determine whether the user can delete the chapter.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chapter  $chapter
     * @return mixed
     */
    public function delete(User $user, Chapter $chapter)
    {
        return $user->id == $chapter->story->user_id;
    }

    /**
     * Determine whether the user can restore the chapter.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chapter  $chapter
     * @return mixed
     */
    public function restore(User $user, Chapter $chapter)
    {
        return $user->id == $chapter->story->user_id;
    }

    /**
     * Determine whether the user can permanently delete the chapter.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Chapter  $chapter
     * @return mixed
     */
    public function forceDelete(User $user, Chapter $chapter)
    {
        return $user->id == $chapter->story->user_id;
    }
}
