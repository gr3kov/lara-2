<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\ProGuard;

class ProGuardPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, ProGuard $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, ProGuard $item)
    {
        return true;
    }

    public function create(User $user, ProGuard $item)
    {
        return true;
    }

    public function edit(User $user, ProGuard $item)
    {
        return true;
    }

    public function delete(User $user, ProGuard $item)
    {
        return true;
    }

    public function restore(User $user, ProGuard $item)
    {
        return true;
    }
}
