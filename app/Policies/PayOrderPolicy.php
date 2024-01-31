<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\PayOrder;

class PayOrderPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, PayOrder $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, PayOrder $item)
    {
        return true;
    }

    public function create(User $user, PayOrder $item)
    {
        return true;
    }

    public function edit(User $user, PayOrder $item)
    {
        return true;
    }

    public function delete(User $user, PayOrder $item)
    {
        return true;
    }

    public function restore(User $user, PayOrder $item)
    {
        return true;
    }
}
