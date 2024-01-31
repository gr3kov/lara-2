<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\AuctionPayed;

class AuctionPayedPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, AuctionPayed $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, AuctionPayed $item)
    {
        return true;
    }

    public function create(User $user, AuctionPayed $item)
    {
        return true;
    }

    public function edit(User $user, AuctionPayed $item)
    {
        return true;
    }

    public function delete(User $user, AuctionPayed $item)
    {
        return true;
    }

    public function restore(User $user, AuctionPayed $item)
    {
        return true;
    }
}
