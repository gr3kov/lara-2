<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Operations;

class OperationsPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, Operations $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, Operations $item)
    {
        return true;
    }

    public function create(User $user, Operations $item)
    {
        return true;
    }

    public function edit(User $user, Operations $item)
    {
        return true;
    }

    public function delete(User $user, Operations $item)
    {
        return true;
    }

    public function restore(User $user, Operations $item)
    {
        return true;
    }
}
