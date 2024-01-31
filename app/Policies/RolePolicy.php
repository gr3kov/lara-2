<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, Role $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, Role $item)
    {
        return true;
    }

    public function create(User $user, Role $item)
    {
        return true;
    }

    public function edit(User $user, Role $item)
    {
        return true;
    }

    public function delete(User $user, Role $item)
    {
        return true;
    }

    public function restore(User $user, Role $item)
    {
        return true;
    }
}
