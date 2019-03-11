<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SaveList;
use Illuminate\Auth\Access\HandlesAuthorization;

class SaveListPolicy
{
    use HandlesAuthorization;

    // Add, remove story from list
    public function edit(User $user, SaveList $list)
    {
        return $user->id == $list->user_id;
    }

    /**
     * Determine whether the user can create save lists.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return (!! $user->email_verified_at);
    }

    /**
     * Determine whether the user can update the save list.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SaveList  $saveList
     * @return mixed
     */
    public function update(User $user, SaveList $saveList)
    {
        return $user->id === $saveList->user_id;
    }

    /**
     * Determine whether the user can delete the save list.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SaveList  $saveList
     * @return mixed
     */
    public function delete(User $user, SaveList $saveList)
    {
        return $user->id === $saveList->user_id;
    }
}
