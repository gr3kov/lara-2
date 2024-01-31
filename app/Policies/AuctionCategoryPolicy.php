<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\AuctionCategory;

class AuctionCategoryPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, AuctionCategory $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, Auction $item)
    {
        return true;
    }

    public function create(User $user, Auction $item)
    {
        return true;
    }

    public function edit(User $user, Auction $item)
    {
        return true;
    }

    public function delete(User $user, Auction $item)
    {
        return true;
    }

    public function restore(User $user, Auction $item)
    {
        return true;
    }
}
