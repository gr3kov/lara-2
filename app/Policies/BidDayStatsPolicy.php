<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\BidDayStats;

class BidDayStatsPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, BidDayStats $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, BidDayStats $item)
    {
        return true;
    }

    public function create(User $user, BidDayStats $item)
    {
        return true;
    }

    public function edit(User $user, BidDayStats $item)
    {
        return true;
    }

    public function delete(User $user, BidDayStats $item)
    {
        return true;
    }

    public function restore(User $user, BidDayStats $item)
    {
        return true;
    }
}
