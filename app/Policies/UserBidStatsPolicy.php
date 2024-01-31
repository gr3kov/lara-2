<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\UserBidStats;

class UserBidStatsPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, UserBidStats $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, UserBidStats $item)
    {
        return true;
    }

    public function create(User $user, UserBidStats $item)
    {
        return true;
    }

    public function edit(User $user, UserBidStats $item)
    {
        return true;
    }

    public function delete(User $user, UserBidStats $item)
    {
        return true;
    }

    public function restore(User $user, UserBidStats $item)
    {
        return true;
    }
}
