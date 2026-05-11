<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative md:col-start-2 aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 grid place-content-center">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                <h1 class="text-lg font-bold">{{ $timer->name }} of routine {{ $routine->name }}</h1>
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 grid place-content-center">
            <form action="{{ route('routines.timers.update', ['routine' => $routine, 'timer' => $timer]) }}" method="POST" class="flex flex-col gap-4 w-full max-w-md">
                @csrf
                @method('PUT')
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Order</label>
                    <input type="number" name="order" id="order" value="{{ $timer->order }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm" min="1" max="{{ $routine->timers()->count() }}">
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Name</label>
                    <input type="text" name="name" id="name" value="{{ $timer->name }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                </div>
                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Duration (seconds)</label>
                    <input type="number" name="duration" id="duration" value="{{ $timer->duration }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm" placeholder="Duration in seconds" min="1">
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Update
                </button>
            </form>

            <form action="{{ route('routines.timers.destroy', ['routine' => $routine, 'timer' => $timer]) }}" method="POST" class="mt-4 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 dark:text-neutral-300 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to delete this timer? This action cannot be undone.')" class="text-red-600 hover:text-red-800">
                    Delete
                </button>
            </form>

            <x-go-back url="{{ route('routines.show', $routine) }}" />
        </div>
    </div>
</x-layouts::app>
