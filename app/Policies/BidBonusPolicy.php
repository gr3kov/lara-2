<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\BidBonus;

class BidBonusPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, BidBonus $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, BidBonus $item)
    {
        return true;
    }

    public function create(User $user, BidBonus $item)
    {
        return true;
    }

    public function edit(User $user, BidBonus $item)
    {
        return true;
    }

    public function delete(User $user, BidBonus $item)
    {
        return true;
    }

    public function restore(User $user, BidBonus $item)
    {
        return true;
    }
}
