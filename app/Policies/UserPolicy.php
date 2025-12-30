<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Super-admin shortcut.
     */
    public function before(User $user, $ability)
    {
        if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, User $model): bool
    {
        return $user->getKey() === $model->getKey();
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, User $model): bool
    {
        return $user->getKey() === $model->getKey();
    }

    public function delete(User $user, User $model): bool
    {
        return false;
    }
}
