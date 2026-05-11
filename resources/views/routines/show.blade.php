<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative md:col-start-2 aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 grid place-content-center">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                <h1 class="text-lg font-bold">{{ $routine->name }}</h1>
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 grid place-content-center">
            <div class="relative p-4">
                <ul>
                    @foreach ($routine->timers as $timer)
                        <li class="flex items-center gap-2 place-content-center border-b border-gray-200 dark:border-neutral-700 py-2 last:border-b-0">
                            <span class="text-lg font-bold gap-6 flex cursor-default items-center">
                                <span class="flex-none text-gray-500 dark:text-neutral-400 text-sm">{{ $timer->order }}</span>
                                <span class="shrink">{{ $timer->name }}</span>
                                <span class="flex-none text-gray-500 dark:text-neutral-400">{{ $timer->duration }} "</span>
                            </span>
                            <a href="{{ route('routines.timers.edit', ['routine' => $routine, 'timer' => $timer]) }}" class="ml-2 text-sm text-gray-500 hover:text-purple-500">
                                <flux:icon.pencil-square variant="mini" class="inline-block" />
                            </a>
                        </li>
                    @endforeach
                </ul>

                <livewire:routine.play :routine="$routine" />
            </div>

            <a href="{{ route('dashboard') }}" class="inline-flex place-content-center mt-4 px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-500 dark:text-neutral-400 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 gap-2 absolute bottom-4 left-1/2 -translate-x-1/2">
                <flux:icon.arrow-left />
                <span class="place-content-center">Go back</span>
            </a>
        </div>
    </div>
</x-layouts::app>
