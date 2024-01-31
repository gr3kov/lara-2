<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\UserBidAdd;

class UserBidAddPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, UserBidAdd $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, UserBidAdd $item)
    {
        return true;
    }

    public function create(User $user, UserBidAdd $item)
    {
        return true;
    }

    public function edit(User $user, UserBidAdd $item)
    {
        return true;
    }

    public function delete(User $user, UserBidAdd $item)
    {
        return true;
    }

    public function restore(User $user, UserBidAdd $item)
    {
        return true;
    }
}
