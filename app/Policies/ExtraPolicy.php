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

    public function view(User $user)
    {
                // Admin can view all extras
        if ($user->role === 'admin') {
            return true;
        }


        // Default deny
        return false;
    }
    public function regis(User $user)
    {
                // Admin can view all extras
        if ($user->role === 'pembina') {
            return false;
        }
        // Default deny
        return true;
    }

    public function create(User $user, Extra $extra)
    {
                // Admin can view all extras
        if ($user->role === 'admin') {
            return true;
        }

        // Pembina can view extras they manage
        if ($user->role === 'pembina') {
            return $extra->pembina_id === $user->id;
        }

        // Students can view extras they are registered in
        if ($user->role === 'student') {
            return $extra->registrations()
                ->where('user_id', $user->id)
                ->exists();
        }

        // Default deny
        return false;
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
