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
        return $chapter->status == Chapter::STATUS_PUBLISHED || $user->id == $chapter->story->user_id;
    }
}
