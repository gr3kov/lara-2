<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\SiteConfig;

class SiteConfigPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, SiteConfig $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, SiteConfig $item)
    {
        return true;
    }

    public function create(User $user, SiteConfig $item)
    {
        return true;
    }

    public function edit(User $user, SiteConfig $item)
    {
        return true;
    }

    public function delete(User $user, SiteConfig $item)
    {
        return true;
    }

    public function restore(User $user, SiteConfig $item)
    {
        return true;
    }
}
