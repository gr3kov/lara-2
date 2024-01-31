<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\UsersToUrl;

class UsersToUrlPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, UsersToUrl $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, UsersToUrl $item)
    {
        return true;
    }

    public function create(User $user, UsersToUrl $item)
    {
        return true;
    }

    public function edit(User $user, UsersToUrl $item)
    {
        return true;
    }

    public function delete(User $user, UsersToUrl $item)
    {
        return true;
    }

    public function restore(User $user, UsersToUrl $item)
    {
        return true;
    }
}
