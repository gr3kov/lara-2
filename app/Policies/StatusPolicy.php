<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Status;

class StatusPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, Status $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, Status $item)
    {
        return true;
    }

    public function create(User $user, Status $item)
    {
        return true;
    }

    public function edit(User $user, Status $item)
    {
        return true;
    }

    public function delete(User $user, Status $item)
    {
        return true;
    }

    public function restore(User $user, Status $item)
    {
        return true;
    }
}
