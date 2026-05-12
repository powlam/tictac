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

                <!-- Name -->
                <flux:input
                    name="name"
                    :label="__('Name')"
                    :value="old('name')"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="John Doe"
                />

                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full" data-test="create-routine-button">
                        {{ __('Create') }}
                    </flux:button>
                </div>
            </form>

            <x-go-back url="{{ route('dashboard') }}" />
        </div>
    </div>
</x-layouts::app>
