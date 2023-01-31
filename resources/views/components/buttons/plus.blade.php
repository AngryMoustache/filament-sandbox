@props([
    'index' => 0,
])

<button
    class="border-t h-0 relative pb-4 w-full"
    style="margin-top: 2rem" {{-- TODO: check why mb-4 does not work --}}
    x-on:click.prevent="openModal('new-block', { index: '{{ $index }}' })"
>
    <span
        style="margin-top: -1rem"
        class="absolute top-0 py-2 px-4 bg-white border rounded-lg"
    >
        <x-heroicon-s-plus class="h-4 w-4" />
    </span>
</button>
