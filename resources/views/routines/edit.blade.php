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
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Name</label>
                    <input type="text" name="name" id="name" value="{{ $routine->name }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update
                </button>
            </form>

            <form action="{{ route('routines.destroy', $routine) }}" method="POST" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 dark:text-neutral-300 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to delete this routine? This action cannot be undone.')" class="text-red-600 hover:text-red-800">
                    Delete
                </button>
            </form>

            <ul>
                @foreach ($routine->timers as $timer)
                    <li class="flex items-center gap-2 place-content-center border-b border-gray-200 dark:border-neutral-700 py-2 last:border-b-0">
                        <span class="text-2xl font-bold gap-6 flex cursor-default">
                            <span>{{ $timer->order }}</span>
                            <span>{{ $timer->name }}</span>
                            <span>{{ $timer->duration }} seconds</span>
                        </span>
                        <a href="{{ route('routines.timers.edit', ['routine' => $routine, 'timer' => $timer]) }}" class="ml-2 text-sm text-gray-500 hover:text-blue-500">
                            <flux:icon.pencil-square variant="mini" class="inline-block" />
                        </a>
                    </li>
                @endforeach
            </ul>

            <a href="{{ route('routines.timers.create', ['routine' => $routine]) }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Create new timer
            </a>

            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 dark:text-neutral-300 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Go back
            </a>
        </div>
    </div>
</x-layouts::app>
