<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Shop;

class ShopPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, Shop $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, Shop $item)
    {
        return true;
    }

    public function create(User $user, Shop $item)
    {
        return true;
    }

    public function edit(User $user, Shop $item)
    {
        return true;
    }

    public function delete(User $user, Shop $item)
    {
        return true;
    }

    public function restore(User $user, Shop $item)
    {
        return true;
    }
}
