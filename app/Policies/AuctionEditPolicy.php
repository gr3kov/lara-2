<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\AuctionEdit;

class AuctionEditPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, AuctionEdit $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, AuctionEdit $item)
    {
        return true;
    }

    public function create(User $user, AuctionEdit $item)
    {
        return true;
    }

    public function edit(User $user, AuctionEdit $item)
    {
        return true;
    }

    public function delete(User $user, AuctionEdit $item)
    {
        return true;
    }

    public function restore(User $user, AuctionEdit $item)
    {
        return true;
    }
}
