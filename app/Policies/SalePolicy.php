<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Sale;

class SalePolicy
{
    public function before(User $user, $ability)
    {
        if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isAttendant();
    }

    public function view(User $user, Sale $sale): bool
    {
        return $user->isAdmin() || $sale->user_id === $user->getKey();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isAttendant();
    }

    public function update(User $user, Sale $sale): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Sale $sale): bool
    {
        return $user->isAdmin();
    }
}
