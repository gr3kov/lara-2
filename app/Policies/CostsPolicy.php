<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Costs;

class CostsPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, Costs $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, Costs $item)
    {
        return true;
    }

    public function create(User $user, Costs $item)
    {
        return true;
    }

    public function edit(User $user, Costs $item)
    {
        return true;
    }

    public function delete(User $user, Costs $item)
    {
        return true;
    }

    public function restore(User $user, Costs $item)
    {
        return true;
    }
}
