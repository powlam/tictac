<?php

use App\Models\Routine;
use App\Models\Timer;
use Livewire\Component;

new class extends Component
{
    public Routine $routine;

    public bool $isPlaying = false;

    public bool $isPaused = false;

    public ?Timer $currentTimer = null;

    public int $currentIndex = 0;

    public int $timeLeft = 0;

    public function play()
    {
        $this->isPlaying = true;
        $this->currentIndex = -1;
        $this->setCurrentTimer();
    }

    public function pause()
    {
        $this->isPaused = true;
    }

    public function resume()
    {
        $this->isPaused = false;
    }

    public function stop()
    {
        $this->currentIndex = $this->routine->timers->count() - 1;
        $this->currentTimer = $this->routine->timers[$this->currentIndex] ?? null;
        $this->nextTimer();
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
            if ($this->currentTimer !== null) {
                $this->dispatch('routine-timer-ended', [
                    'timerId' => $finishedTimer->id,
                    'timerName' => $finishedTimer->name,
                ]);
            } else {
                $this->dispatch('routine-ended');
            }
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
    pauseTimer() {
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
        }
    },
    resumeTimer() {
        if (!this.interval) {
            this.startTimer();
        }
    },
    stopTimer() {
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
        }
    },
    playTimerEndSound() {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const gain = audioContext.createGain();
        gain.gain.setValueAtTime(0, audioContext.currentTime);
        gain.gain.linearRampToValueAtTime(0.16, audioContext.currentTime + 0.02);
        gain.gain.linearRampToValueAtTime(0, audioContext.currentTime + 0.32);
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
        createTone(1500, now + 0.10, 0.22);
    },
    playRoutineEndSound() {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const gain = audioContext.createGain();
        gain.gain.setValueAtTime(0, audioContext.currentTime);
        gain.gain.linearRampToValueAtTime(0.16, audioContext.currentTime + 0.02);
        gain.gain.linearRampToValueAtTime(0, audioContext.currentTime + 0.42);
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
        createTone(1500, now, 0.08);
        createTone(1100, now + 0.10, 0.08);
        createTone(880, now + 0.20, 0.22);
    },
    handleTimerChange() {
        this.playTimerEndSound();
    },
    handleRoutineEnded() {
        this.playRoutineEndSound();
    }
}" x-init="
    $watch('$wire.isPlaying', (isPlaying) => {
        if (isPlaying) {
            startTimer();
        } else {
            stopTimer();
        }
    });

    $watch('$wire.isPaused', (isPaused) => {
        if (isPaused) {
            pauseTimer();
        } else {
            resumeTimer();
        }
    });

    window.addEventListener('routine-timer-ended', () => {
        handleTimerChange();
    });

    window.addEventListener('routine-ended', () => {
        handleRoutineEnded();
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

            @if (! $isPaused)
                <button type="button" wire:click="pause" @click="$event.target.blur()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 gap-2 cursor-pointer">
                    PAUSE
                    <flux:icon.pause class="ml-2" />
                </button>
            @else
                <button type="button" wire:click="resume" @click="$event.target.blur()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 gap-2 cursor-pointer">
                    RESUME
                    <flux:icon.play class="ml-2" />
                </button>
                <button type="button" wire:click="stop" @click="$event.target.blur()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 gap-2 cursor-pointer">
                    STOP
                    <flux:icon.stop class="ml-2" />
                </button>
            @endif
        </div>
    @endif
</div>