<?php

namespace App\Http\Controllers;

use App\Models\Routine;
use Illuminate\Http\Request;

class RoutineController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('routines.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $routine = auth()->user()->routines()->create($request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]));

        return redirect()->route('routines.edit', $routine);
    }

    /**
     * Display the specified resource.
     */
    public function show(Routine $routine)
    {
        return view('routines.show', [
            'routine' => $routine,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Routine $routine)
    {
        return view('routines.edit', [
            'routine' => $routine,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Routine $routine)
    {
        $routine->update($request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]));

        return redirect()->route('routines.edit', $routine);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Routine $routine)
    {
        Routine::destroy($routine->id);

        return redirect()->route('dashboard');
    }
}
