<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\ActiveUsers;

class ActiveUsersPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, ActiveUsers $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, ActiveUsers $item)
    {
        return true;
    }

    public function create(User $user, ActiveUsers $item)
    {
        return true;
    }

    public function edit(User $user, ActiveUsers $item)
    {
        return true;
    }

    public function delete(User $user, ActiveUsers $item)
    {
        return true;
    }

    public function restore(User $user, ActiveUsers $item)
    {
        return true;
    }
}
