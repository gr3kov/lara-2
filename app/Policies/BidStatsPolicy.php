<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\BidStats;

class BidStatsPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, BidStats $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, BidStats $item)
    {
        return true;
    }

    public function create(User $user, BidStats $item)
    {
        return true;
    }

    public function edit(User $user, BidStats $item)
    {
        return true;
    }

    public function delete(User $user, BidStats $item)
    {
        return true;
    }

    public function restore(User $user, BidStats $item)
    {
        return true;
    }
}
