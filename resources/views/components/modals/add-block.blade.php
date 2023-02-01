@props([
    'blocks',
    'statePath',
])

<x-filament::modal id="new-block-{{ $statePath }}" width="7xl">
    <x-filament::modal.heading>
        Adding a new block
    </x-filament::modal.heading>

    <ul class="grid grid-cols-4 gap-4" style="margin: 2rem 0 4rem">
        @foreach ($blocks as $block)
            <li
                class="cursor-pointer bg-gray-100 hover:bg-gray-200 py-2 px-4 rounded-lg"
                x-on:click.prevent="$wire.dispatchFormEvent(
                    'architect::createBlock', @js($statePath), modalData.index, @js(get_class($block))
                ) && close()"
            >
                <h3 class="font-bold">{{ $block->label() }}</h3>
                <p>{{ $block->description() }}</p>
            </li>
        @endforeach
    </ul>

    <x-filament::modal.actions>
        <x-filament::button x-on:click.prevent="close()">
            Cancel
        </x-filament::button>
    </x-filament::modal.actions>
</x-filament::modal>
