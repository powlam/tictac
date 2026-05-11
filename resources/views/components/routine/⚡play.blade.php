<?php

use App\Models\Routine;
use App\Models\Timer;
use Livewire\Component;

new class extends Component
{
    public Routine $routine;

    public bool $isPlaying = false;

    public ?Timer $currentTimer = null;

    public int $currentIndex = 0;

    public int $timeLeft = 0;

    public function play()
    {
        $this->isPlaying = true;
        $this->currentIndex = 0;
        $this->setCurrentTimer();
    }

    public function setCurrentTimer()
    {
        if ($this->currentIndex < $this->routine->timers->count()) {
            $this->currentTimer = $this->routine->timers[$this->currentIndex];
            $this->timeLeft = $this->currentTimer->duration;
        } else {
            $this->isPlaying = false;
            $this->currentTimer = null;
            $this->timeLeft = 0;
        }
    }

    public function nextTimer()
    {
        $this->currentIndex++;
        $this->setCurrentTimer();
    }

    public function decrementTime()
    {
        if ($this->timeLeft > 0) {
            $this->timeLeft--;
        } else {
            $this->nextTimer();
        }
    }
};
?>

<div x-data="{
    interval: null,
    startTimer() {
        if (this.interval) clearInterval(this.interval);
        this.interval = setInterval(() => {
            $wire.call('decrementTime');
        }, 1000);
    },
    stopTimer() {
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
        }
    }
}" x-init="
    $watch('$wire.isPlaying', (isPlaying) => {
        if (isPlaying) {
            startTimer();
        } else {
            stopTimer();
        }
    });
" class="flex place-content-center">

    <button type="button" wire:click="play" @click="$event.target.blur()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 gap-2 cursor-pointer">
        PLAY
        <flux:icon.play class="ml-2" />
    </button>
    @if ($isPlaying)
        <div class="flex flex-col items-center gap-4 absolute top-0 left-0 w-full h-full bg-white/95 dark:bg-neutral-900/95 p-4">
            <span class="inline-flex items-center px-4 py-2 text-3xl font-bold">
                {{ $currentTimer?->name ?? '...' }}
            </span>
            <span class="inline-flex items-center px-4 py-2 border border-transparent font-mono text-3xl font-medium text-purple-500">
                {{ $timeLeft }}
            </span>
        </div>
    @endif
</div>