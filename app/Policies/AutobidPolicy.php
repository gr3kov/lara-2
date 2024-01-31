<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Autobid;

class AutobidPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, Autobid $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, Autobid $item)
    {
        return true;
    }

    public function create(User $user, Autobid $item)
    {
        return true;
    }

    public function edit(User $user, Autobid $item)
    {
        return true;
    }

    public function delete(User $user, Autobid $item)
    {
        return true;
    }

    public function restore(User $user, Autobid $item)
    {
        return true;
    }
}
