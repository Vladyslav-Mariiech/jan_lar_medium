<?php

namespace App\Policies;

use App\Models\Photos;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PhotoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function owner(User $user, Photos $photo)
    {
        return $user->id === $photo->user_id;
    }
}
