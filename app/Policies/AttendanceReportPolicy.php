<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Extra;
use App\Models\AttendanceReport;

class AttendanceReportPolicy
{
    /**
     * Create a new policy instance.
     */
    use HandlesAuthorization;
   public function viewAny(User $user)
    {
        // Anyone in the system can see reports related to them
        return in_array($user->role, ['admin','pembina','student']);
    }

    public function create(User $user)
    {
        // Only student reps may create reports
        return $user->role === 'student' || $user->role === 'pembina';
    }

    public function approve(User $user, AttendanceReport $report)
    {
        // Only the pembina of that extra or admin
        return $user->role === 'admin'
            || ($user->role === 'pembina' && $report->extra->pembina_id === $user->id);
    }

    public function delete(User $user, AttendanceReport $report)
    {
        // Admin only
        return $user->role === 'admin';
    }
}
