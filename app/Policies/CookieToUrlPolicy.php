<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\CookieToUrl;

class CookieToUrlPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, CookieToUrl $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, CookieToUrl $item)
    {
        return true;
    }

    public function create(User $user, CookieToUrl $item)
    {
        return true;
    }

    public function edit(User $user, CookieToUrl $item)
    {
        return true;
    }

    public function delete(User $user, CookieToUrl $item)
    {
        return true;
    }

    public function restore(User $user, CookieToUrl $item)
    {
        return true;
    }
}
