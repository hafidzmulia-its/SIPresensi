<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Extra;
use App\Models\User;
use App\Policies\ExtraPolicy;
use Illuminate\Support\Facades\Gate;

class ExtraController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Extra::class, 'extra');
    }

    public function index()
    {
        // List all extras
        // if (Gate::denies('viewAny', Extra::class)) {
        //     abort(403, 'Unauthorized action.');
        // }


        $extras = Extra::with('pembina')->get();
        return view('extras.index', compact('extras'));
    }

    public function create()
    {
        // Show form to create new extra

        $pembinas = User::where('role', 'pembina')->get();
        return view('extras.create', compact('pembinas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'pembina_id' => 'required|exists:users,id',
        ]);

        Extra::create($data);

        return redirect()
            ->route('extras.index')
            ->with('success', 'Ekstrakurikuler berhasil dibuat.');
    }

    public function show(Extra $extra)
    {
        // Eager-load anggota for display
        $extra->load('pembina', 'anggota');
        return view('extras.show', compact('extra'));
    }

    public function edit(Extra $extra)
    {
        $pembinas = User::where('role', 'pembina')->get();
        return view('extras.create', [ // reuse create form
            'extra'    => $extra,
            'pembinas' => $pembinas,
        ]);
    }

    public function update(Request $request, Extra $extra)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'pembina_id' => 'required|exists:users,id',
        ]);

        $extra->update($data);

        return redirect()
            ->route('extras.index')
            ->with('success', 'Ekstrakurikuler berhasil diupdate.');
    }

    public function destroy(Extra $extra)
    {
        $extra->delete();

        return redirect()
            ->route('extras.index')
            ->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }
}
