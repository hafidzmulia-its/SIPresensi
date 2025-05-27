<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Extra;
use App\Models\ExtraRegistration;

class ExtraRegistrationPolicy
{
    /**
     * Create a new policy instance.
     */
    use HandlesAuthorization;
     public function create(User $user)
    {
        // Only students may register
        return $user->role === 'student';
    }

    public function delete(User $user, ExtraRegistration $registration)
    {
        // Students can unregister only their own registrations
        return $user->role === 'student'
            && $registration->user_id === $user->id;
    }

    public function viewAny(User $user)
    {
        // Admin sees all, pembina sees their extras’ regs, students see their own
        return in_array($user->role, ['admin','pembina','student']);
    }
}
