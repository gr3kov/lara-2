<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\UserStats;

class UserStatsPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, UserStats $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, UserStats $item)
    {
        return true;
    }

    public function create(User $user, UserStats $item)
    {
        return true;
    }

    public function edit(User $user, UserStats $item)
    {
        return true;
    }

    public function delete(User $user, UserStats $item)
    {
        return true;
    }

    public function restore(User $user, UserStats $item)
    {
        return true;
    }
}
