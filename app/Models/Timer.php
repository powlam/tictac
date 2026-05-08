<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['routine_id', 'name', 'duration', 'order'])]
class Timer extends Model
{
    /**
     * Get the routine that owns the timer.
     * 
     * @return BelongsTo<Routine>
     */
    public function routine(): BelongsTo
    {
        return $this->belongsTo(Routine::class);
    }

    public function getPreviousTimer(): ?Timer
    {
        return $this->routine->timers()->where('order', '<', $this->order)->latest('order')->first();
    }

    public function getNextTimer(): ?Timer
    {
        return $this->routine->timers()->where('order', '>', $this->order)->first();
    }
}
