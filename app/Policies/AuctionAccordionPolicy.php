<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\AuctionAccordion;

class AuctionAccordionPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability, AuctionAccordion $item)
    {
        return $user->isSuperAdmin();
    }

    public function display(User $user, AuctionAccordion $item)
    {
        return true;
    }

    public function create(User $user, AuctionAccordion $item)
    {
        return true;
    }

    public function edit(User $user, AuctionAccordion $item)
    {
        return true;
    }

    public function delete(User $user, AuctionAccordion $item)
    {
        return true;
    }

    public function restore(User $user, AuctionAccordion $item)
    {
        return true;
    }
}
