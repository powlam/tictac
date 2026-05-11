<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative md:col-start-2 aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 grid place-content-center">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                <h1 class="text-lg font-bold">New routine</h1>
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 grid place-content-center">
            <form action="{{ route('routines.store') }}" method="POST" class="flex flex-col gap-4 w-full max-w-md">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Name</label>
                    <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Create
                </button>
            </form>

            <a href="{{ route('dashboard') }}" class="inline-flex place-content-center mt-4 px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-500 dark:text-neutral-400 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 gap-2">
                <flux:icon.arrow-left />
                <span class="place-content-center">Go back</span>
            </a>
        </div>
    </div>
</x-layouts::app>
