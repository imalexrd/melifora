<?php

namespace App\Policies;

use App\Models\ApiaryNote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApiaryNotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ApiaryNote  $apiaryNote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ApiaryNote $apiaryNote)
    {
        return $user->id === $apiaryNote->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ApiaryNote  $apiaryNote
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ApiaryNote $apiaryNote)
    {
        return $user->id === $apiaryNote->user_id;
    }
}
