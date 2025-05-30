<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Extra;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'student') {
            // Student-specific logic
            $extras = $user->extrasAsStudent()->with('reports.details')->get();

            $summaries = $extras->map(function ($extra) use ($user) {
                $approvedReports = $extra->reports->where('status', 'approved');

                $hadir = $approvedReports->flatMap->details->where('student_id', $user->id)->where('presence', 'hadir')->count();
                $izin = $approvedReports->flatMap->details->where('student_id', $user->id)->where('presence', 'izin')->count();
                $sakit = $approvedReports->flatMap->details->where('student_id', $user->id)->where('presence', 'sakit')->count();
                $alfa = $approvedReports->flatMap->details->where('student_id', $user->id)->where('presence', 'alfa')->count();
                $meetings = $approvedReports->count();

                return [
                    'extra'    => $extra,
                    'hadir'    => $hadir,
                    'izin'     => $izin,
                    'sakit'    => $sakit,
                    'alfa'     => $alfa,
                    'meetings' => $meetings,
                ];
            });

            return view('dashboard', [
                'user'      => $user,
                'summaries' => $summaries,
            ]);
        } elseif ($user->role === 'admin' || $user->role === 'pembina') {
            // Admin/Pembina-specific logic
            $extras = $user->role === 'pembina'
            ? Extra::with('reports.details', 'registrations')->where('pembina_id', $user->id)->get()
            : Extra::with('reports.details', 'registrations')->get();

            $extra =  $extras->first();

            // Filter pending reports based on role
        $pendingReports = $user->role === 'pembina'
            ? $extras->flatMap->reports->where('status', 'pending')->filter(function ($report) use ($user) {
                return $report->extra->pembina_id === $user->id;
            })
            : $extras->flatMap->reports->where('status', 'pending');

        // Retrieve students for pembina
        $students = $user->role === 'pembina'
            ? $extras->flatMap->registrations->filter(function ($registration) use ($user) {
                return $registration->extra->pembina_id === $user->id;
            })->map(function ($registration) {
                $student = $registration->student;
                $approvedReports = $registration->extra->reports->where('status', 'approved');

                $student->hadir = $approvedReports->flatMap->details->where('student_id', $student->id)->where('presence', 'hadir')->count();
                $student->izin = $approvedReports->flatMap->details->where('student_id', $student->id)->where('presence', 'izin')->count();
                $student->sakit = $approvedReports->flatMap->details->where('student_id', $student->id)->where('presence', 'sakit')->count();
                $student->alfa = $approvedReports->flatMap->details->where('student_id', $student->id)->where('presence', 'alfa')->count();

                return $student;
            })
            : collect();

            return view('teacher.dashboard', [
                'user'           => $user,
                'extras'         => $extras,
                'pendingReports' => $pendingReports,
                'students'       => $students,
                'extra'          => $extra,
            ]);
        }
    }
}
