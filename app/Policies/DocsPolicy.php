<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Docs;

class DocsPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, Docs $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, Docs $item)
    {
        return true;
    }

    public function create(User $user, Docs $item)
    {
        return true;
    }

    public function edit(User $user, Docs $item)
    {
        return true;
    }

    public function delete(User $user, Docs $item)
    {
        return true;
    }

    public function restore(User $user, Docs $item)
    {
        return true;
    }
}
