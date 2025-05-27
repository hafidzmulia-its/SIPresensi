<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Extra;
use App\Models\ExtraRegistration;

class ExtraRegistrationController extends Controller
{
    public function __construct()
    {
        // Only students can register/unregister
        // $this->middleware('can:create,App\Models\ExtraRegistration')->only('store');
        // $this->middleware('can:delete,extraRegistration')->only('destroy');
    }

    public function index()
    {
        $extras = Extra::with('pembina')->get();

        // 1) Pull the already-registered extras as a Collection
        $userExtras = auth()->user()->extrasAsStudent; // no ->() here, so it's already loaded

        // 2) Map [ extra_id => registration_id ] from the pivot
        $userRegs = $userExtras
                    ->pluck('pivot.id', 'id')
                    ->toArray();
                    // keys   are Extra model id
                    // values are ExtraRegistration pivot id

    return view('registrations.index', compact('extras','userRegs'));
    }
    public function store(Request $request, Extra $extra)
    {
        $data = $request->validate([
            'extra_id' => ['required','exists:extras,id'],
        ]);

        // Use the validated `extra_id` to find the Extra model
        $extra = Extra::findOrFail($data['extra_id']);
        // Prevent double-registration for same semester/year
        // dd(date('Y'));
        auth()->user()
            ->extrasAsStudent()
            ->syncWithoutDetaching([
                $extra->id => [
                    'year'     => date('Y'),
                ]
            ]);

        return back()->with('success', "Anda telah terdaftar di “{$extra->name}”.");
    }

    public function destroy(Request $request, Extra $extra)
    {
        auth()->user()
            ->extrasAsStudent()
            ->wherePivot('year', date('Y'))
            ->detach($extra->id);
        // $registration->delete();

        return back()->with('success', "Pendaftaran di “{$extra->name}” dibatalkan.");
    }
}
