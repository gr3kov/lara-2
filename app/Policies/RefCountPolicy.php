<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\RefCount;

class RefCountPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, RefCount $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, RefCount $item)
    {
        return true;
    }

    public function create(User $user, RefCount $item)
    {
        return true;
    }

    public function edit(User $user, RefCount $item)
    {
        return true;
    }

    public function delete(User $user, RefCount $item)
    {
        return true;
    }

    public function restore(User $user, RefCount $item)
    {
        return true;
    }
}
