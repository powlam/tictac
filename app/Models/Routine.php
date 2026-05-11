<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'name'])]
class Routine extends Model
{
    /**
     * Get the user that owns the routine.
     *
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the timers for the routine.
     *
     * @return HasMany<Timer>
     */
    public function timers(): HasMany
    {
        return $this->hasMany(Timer::class)->orderBy('order');
    }
}
