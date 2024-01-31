<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, User $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, User $item)
    {
        return true;
    }

    public function create(User $user, User $item)
    {
        return true;
    }

    public function edit(User $user, User $item)
    {
        return true;
    }

    public function delete(User $user, User $item)
    {
        return true;
    }

    public function restore(User $user, User $item)
    {
        return true;
    }
}
