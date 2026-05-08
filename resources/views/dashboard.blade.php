<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative md:col-start-2 aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 grid place-content-center">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                <h1 class="text-lg font-bold">My routines</h1>
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 grid place-content-center">
            <ul>
                @foreach (auth()->user()->routines as $routine)
                    <li class="flex items-center gap-2 place-content-center border-b border-gray-200 dark:border-neutral-700 py-2 last:border-b-0">
                        <a href="{{ route('routines.show', $routine) }}" class="text-2xl font-bold hover:text-blue-500">{{ $routine->name }}</a>
                        <a href="{{ route('routines.edit', $routine) }}" class="ml-2 text-sm text-gray-500 hover:text-blue-500">
                            <flux:icon.pencil-square variant="mini" class="inline-block" />
                        </a>
                    </li>
                @endforeach
            </ul>

            <a href="{{ route('routines.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Create new routine
            </a>
        </div>
    </div>
</x-layouts::app>
