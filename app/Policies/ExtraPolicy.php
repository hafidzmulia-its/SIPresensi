<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Extra;


class ExtraPolicy
{
    /**
     * Create a new policy instance.
     */
    use HandlesAuthorization;
    public function viewAny(User $user)
    {
        // Everyone can see the list of extras
        return in_array($user->role, ['admin','pembina','student']);
    }

    public function view(User $user, Extra $extra)
    {
        return $this->viewAny($user);
    }

    public function create(User $user)
    {
        // Only admin can create a new extra
        return $user->role === 'admin';
    }

    public function update(User $user, Extra $extra)
    {
        // Admin always; pembina only their own
        return $user->role === 'admin'
            || ($user->role === 'pembina' && $extra->pembina_id === $user->id);
    }

    public function delete(User $user, Extra $extra)
    {
        // Same as update
        return $this->update($user, $extra);
    }
}
