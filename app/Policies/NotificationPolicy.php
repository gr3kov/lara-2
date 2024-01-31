<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Notification;

class NotificationPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, Notification $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, Notification $item)
    {
        return true;
    }

    public function create(User $user, Notification $item)
    {
        return true;
    }

    public function edit(User $user, Notification $item)
    {
        return true;
    }

    public function delete(User $user, Notification $item)
    {
        return true;
    }

    public function restore(User $user, Notification $item)
    {
        return true;
    }
}
