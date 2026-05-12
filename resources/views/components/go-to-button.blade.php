@props([
    'url' => null,
])

<flux:button
    href="{{ $url ?: route('dashboard') }}"
    icon:trailing="arrow-up-right"
    variant="primary"
    color="purple"
    class="mt-4"
>
    {{ $slot }}
</flux:button>