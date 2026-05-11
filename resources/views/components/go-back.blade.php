@props([
    'url' => null,
])

<a href="{{ $url ?: route('dashboard') }}" {{ $attributes->merge(['class' => 'inline-flex place-content-center mt-4 px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-500 dark:text-neutral-400 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 gap-2']) }}>
    <flux:icon.arrow-left />
    <span class="place-content-center">Go back</span>
</a>
