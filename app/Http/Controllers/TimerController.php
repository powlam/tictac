<?php

namespace App\Http\Controllers;

use App\Models\Routine;
use App\Models\Timer;
use Illuminate\Http\Request;

class TimerController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Routine $routine)
    {
        return view('timers.create', [
            'routine' => $routine,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Routine $routine)
    {
        $timer = $routine->timers()->create($request->validate([
            'order' => ['required', 'integer', 'min:1', 'max:'.($routine->timers()->count() + 1)],
            'name' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'integer', 'min:1'],
        ]));

        $this->reorderTimers($routine, $timer);

        return redirect()->route('routines.edit', $routine);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Routine $routine, Timer $timer)
    {
        return view('timers.edit', [
            'routine' => $routine,
            'timer' => $timer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Routine $routine, Timer $timer)
    {
        $validated = $request->validate([
            'order' => ['required', 'integer', 'min:1', 'max:'.($routine->timers()->count() + 1)],
            'name' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'integer', 'min:1'],
        ]);
        $timer->update($validated);
        $timer->refresh();

        $this->reorderTimers($routine, $timer);

        return redirect()->route('routines.edit', $routine);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Routine $routine, Timer $timer)
    {
        Timer::destroy($timer->id);
        $this->reorderTimers($routine);

        return redirect()->route('routines.edit', $routine);
    }

    private function reorderTimers(Routine $routine, ?Timer $changedTimer = null): void
    {
        $changedTimerOrder = $changedTimer?->order;

        $order = 1;
        foreach ($routine->timers as $timer) {
            if ($timer->is($changedTimer)) {
                // Skip the changed timer, it has already been updated with the correct order
            } elseif ($changedTimerOrder === $order) {
                $timer->update([
                    'order' => $order + 1,
                ]);
                $timer->refresh();
            } elseif ($timer->order != $order) {
                $timer->update([
                    'order' => $order,
                ]);
                $timer->refresh();
            }
            $order++;
        }

        $routine->refresh();
    }
}
