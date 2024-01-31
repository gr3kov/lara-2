<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\NotificationsNews;

class NotificationsNewsPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, NotificationsNews $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, NotificationsNews $item)
    {
        return true;
    }

    public function create(User $user, NotificationsNews $item)
    {
        return true;
    }

    public function edit(User $user, NotificationsNews $item)
    {
        return true;
    }

    public function delete(User $user, NotificationsNews $item)
    {
        return true;
    }

    public function restore(User $user, NotificationsNews $item)
    {
        return true;
    }
}
