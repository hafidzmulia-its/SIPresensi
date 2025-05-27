<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Extra;
use App\Models\ExtraRegistration;
use App\Models\AttendanceReport;
use PDF;

class AttendanceReportController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(AttendanceReport::class, 'attendance_report');
        // Map model binding param 'attendance' → AttendanceReport
        // $this->authorizeResource(AttendanceReport::class, 'attendance');
    }

     public function index(Extra $extra)
    {
        // Students see only their own reports; pembina/admin see all
        $this->authorize('create', $extra);

        $reports = $extra->reports()
            ->with('reporter')
            ->when(auth()->user()->role === 'student', function ($query) {
            // Students can only view reports for extras they are registered in
            $query->whereHas('extra.registrations', function ($subQuery) {
                $subQuery->where('user_id', auth()->id());
            });
        })
        ->when(auth()->user()->role === 'pembina', function ($query) {
            // Pembina can view all reports for extras they manage
            $query->whereHas('extra', function ($subQuery) {
                $subQuery->where('pembina_id', auth()->id());
            });
        })
            ->latest()
            ->get();

        return view('extras.attendances.index', compact('extra','reports'));
    }

    /** Show form to submit attendance for a new meeting */
    public function create(Extra $extra)
    {
        $this->authorize('create', $extra);
        // Ensure students are registered in the extra
    // if (auth()->user()->role === 'student' && !$extra->registrations()->where('user_id', auth()->id())->exists()) {
    //     abort(403, __('You are not registered in this extracurricular.'));
    // }
        $members = $extra->anggota; // Collection of Users
        return view('extras.attendances.create', compact('extra','members'));
    }

    /** Store the new attendance report + details */
    public function store(Request $request, Extra $extra)
    {
        // $this->authorize('create', AttendanceReport::class);

        $data = $request->validate([
            'date'                 => 'required|date',
            'berita_acara'         => 'nullable|string',
            'presence'             => 'required|array',
            'presence.*.student_id'=> 'required|exists:users,id',
            'presence.*.status'    => 'required|in:hadir,izin,sakit,alfa',
            'image'                 => 'nullable|image|max:2048', // jpeg/png/gif, ≤2MB
        ]);

        $report = AttendanceReport::create([
            'extra_id'     => $extra->id,
            'date'         => $data['date'],
            'berita_acara' => $data['berita_acara'] ?? null,
            'submitted_by' => auth()->id(),
        ]);

        $report->details()->createMany(
            array_map(fn($row) => [
                'student_id' => $row['student_id'],
                'presence'   => $row['status'],
            ], $data['presence'])
        );

        // If an image was uploaded, store it and update the report
        if ($request->hasFile('image')) {
            $path = $request->file('image')
                            ->store('reports', 'public');
            // e.g. "reports/abcdef12345.jpg"
            $report->update(['image_path' => $path]);
        }

        $reports = $extra->reports()
            ->with('reporter')
            ->when(auth()->user()->role === 'student', fn($q) =>
                $q->where('submitted_by', auth()->id())
            )
            ->latest()
            ->get();

        return redirect()
        ->route('attendances.show', $report)
        ->with('success', __('Laporan dikirim untuk approval.'));
        // return redirect()
        //     ->route('extras.attendances.index',  compact('extra','reports'))
        //     ->with('success', __('Laporan dikirim untuk approval.'));
    }

    /** Show a single report and its details */
    public function show(AttendanceReport $attendance)
    { 
        $attendance->load('extra', 'reporter', 'details.student');
        return view('extras.attendances.show', ['report' => $attendance]);
    }

    /** Show approval form (status) */
    public function edit(AttendanceReport $attendance)
    {
        // Only pembina/admin can edit (approve/reject)
        $this->authorize('approve', $attendance);
        return view('extras.attendances.edit', ['report' => $attendance]);
    }

    /** Approve or reject */
    public function update(Request $request, AttendanceReport $attendance)
    {
        // $this->authorize('approve', $attendance);

        $data = $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $attendance->update(['status' => $data['status']]);

        return back()->with('success', __('Status updated.'));
    }

    /** (Optional) delete a report */
    public function destroy(AttendanceReport $attendance)
    {
        $attendance->delete();
        return redirect()
            ->route('extras.attendances.index', $attendance->extra_id)
            ->with('success', __('Laporan dihapus.'));
    }
    public function pdf(AttendanceReport $attendance)
    {
        // Policy check
        $this->authorize('generatePdf', $attendance);

        // Load relationships
        $attendance->load('extra', 'reporter', 'details.student');

        // Render a PDF-friendly Blade view
        $pdf = PDF::loadView('extras.attendances.pdf', [
            'report' => $attendance,
        ]);

        $filename = 'Presensi_'.$attendance->extra->name.'_'.$attendance->date.'.pdf';

        return $pdf->download($filename);
    }
}
