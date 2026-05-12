<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative md:col-start-2 aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 grid place-content-center">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                <h1 class="text-lg font-bold">{{ $routine->name }}</h1>
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 grid place-content-center">
            <form action="{{ route('routines.update', $routine) }}" method="POST" class="flex flex-col gap-4 w-full max-w-md">
                @csrf
                @method('PUT')

                <!-- Name -->
                <flux:input
                    name="name"
                    :label="__('Name')"
                    :value="old('name') ?? $routine->name"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="John Doe"
                />

                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full" data-test="update-routine-button">
                        {{ __('Update') }}
                    </flux:button>

                    <flux:button variant="danger" type="submit" class="w-full" data-test="delete-routine-button" onclick="return confirm('Are you sure you want to delete this routine? This action cannot be undone.')" form="delete-routine-form">
                        {{ __('Delete') }}
                    </flux:button>
                </div>
            </form>

            <form action="{{ route('routines.destroy', $routine) }}" id="delete-routine-form" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>

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

            <a href="{{ route('routines.timers.create', ['routine' => $routine]) }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                Create new timer
            </a>

            <x-go-back url="{{ route('dashboard') }}" />
        </div>
    </div>
</x-layouts::app>
