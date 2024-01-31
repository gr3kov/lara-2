<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\TargetRegister;

class TargetRegisterPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, TargetRegister $item)
    {
        return $user->isSuperAdmin() || $user->isManager();
    }

    public function display(User $user, TargetRegister $item)
    {
        return true;
    }

    public function create(User $user, TargetRegister $item)
    {
        return true;
    }

    public function edit(User $user, TargetRegister $item)
    {
        return true;
    }

    public function delete(User $user, TargetRegister $item)
    {
        return true;
    }

    public function restore(User $user, TargetRegister $item)
    {
        return true;
    }
}
