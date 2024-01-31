<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Bid;

class BidPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, Bid $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, Bid $item)
    {
        return true;
    }

    public function create(User $user, Bid $item)
    {
        return true;
    }

    public function edit(User $user, Bid $item)
    {
        return true;
    }

    public function delete(User $user, Bid $item)
    {
        return true;
    }

    public function restore(User $user, Bid $item)
    {
        return true;
    }
}
