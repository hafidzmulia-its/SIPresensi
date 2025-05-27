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
        return in_array($user->role, ['admin','pembina']);
    }
    public function view(User $user, AttendanceReport $report)
    {
        // Admin can view all extras
    if ($user->role === 'admin') {
        return true;
    }

    // Pembina can view extras they manage
    if ($user->role === 'pembina') {
        return $report->extra()->pembina_id === $user->id;
    }

    // Students can view extras they are registered in
    if ($user->role === 'student') {
        return $report->extra()->registrations()
            ->where('user_id', $user->id)
            ->exists();
    }

    // Default deny
    return false;
    }

    public function create(User $user, AttendanceReport $report)
    {
        // Admin can view all extras
    if ($user->role === 'admin') {
        return true;
    }

    // Pembina can view extras they manage
    if ($user->role === 'pembina') {
        return $report->extra()->pembina_id === $user->id;
    }

    // Students can view extras they are registered in
    if ($user->role === 'student') {
        return $report->extra()->registrations()
            ->where('user_id', $user->id)
            ->exists();
    }

    // Default deny
    return false;
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
    public function generatePdf(User $user, AttendanceReport $report): bool
    {
        // Admin always allowed
        if ($user->role === 'admin') {
            return true;
        }

        // Pembina of this extra allowed
        if ($user->role === 'pembina' && $report->extra->pembina_id === $user->id) {
            return true;
        }

        // Student only if this report was approved
        if ($user->role === 'student'
            && $report->extra->registrations()
            ->where('user_id', $user->id)
            ->exists() && $report->status === 'approved') {
            return true;
        }

        return false;
    }
}
