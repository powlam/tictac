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
        $this->currentIndex = -1;
        $this->setCurrentTimer();
    }

    public function setCurrentTimer()
    {
        if ($this->currentIndex < $this->routine->timers->count()) {
            if ($this->currentIndex >= 0) {
                $this->currentTimer = $this->routine->timers[$this->currentIndex];
            } else {
                $this->currentTimer = (new Timer())->forceFill([
                    'name' => 'Get Ready',
                    'duration' => 5,
                ]);
            }
            $this->timeLeft = $this->currentTimer->duration;
        } else {
            $this->isPlaying = false;
            $this->currentTimer = null;
            $this->timeLeft = 0;
        }
    }

    public function nextTimer()
    {
        $finishedTimer = $this->currentTimer;

        $this->currentIndex++;
        $this->setCurrentTimer();

        if ($finishedTimer !== null) {
            $this->dispatch('routine-timer-ended', [
                'timerId' => $finishedTimer->id,
                'timerName' => $finishedTimer->name,
            ]);
        }
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
    },
    playTimerEndSound() {
        console.log('Playing sound');
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const gain = audioContext.createGain();
        gain.gain.setValueAtTime(0, audioContext.currentTime);
        gain.gain.linearRampToValueAtTime(0.16, audioContext.currentTime + 0.02);
        gain.gain.linearRampToValueAtTime(0, audioContext.currentTime + 0.22);
        gain.connect(audioContext.destination);

        const createTone = (frequency, start, duration) => {
            const oscillator = audioContext.createOscillator();
            oscillator.type = 'sine';
            oscillator.frequency.setValueAtTime(frequency, start);
            oscillator.connect(gain);
            oscillator.start(start);
            oscillator.stop(start + duration);
        };

        const now = audioContext.currentTime;
        createTone(880, now, 0.08);
        createTone(1100, now + 0.10, 0.12);
    },
    handleTimerChange() {
        this.playTimerEndSound();
    }
}" x-init="
    $watch('$wire.isPlaying', (isPlaying) => {
        if (isPlaying) {
            startTimer();
        } else {
            stopTimer();
        }
    });

    window.addEventListener('routine-timer-ended', () => {
        handleTimerChange();
    });
" class="flex place-content-center">

    <button type="button" wire:click="play" @click="$event.target.blur()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 gap-2 cursor-pointer">
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