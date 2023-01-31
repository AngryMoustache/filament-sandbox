@props([
    'blocks',
    'statePath',
])

<x-filament::modal id="new-block" width="7xl">
    <x-filament::modal.heading>
        Adding a new block
    </x-filament::modal.heading>

    <ul>
        @foreach ($blocks as $block)
            <li x-on:click.prevent="$wire.dispatchFormEvent(
                'architect::createBlock', @js($statePath), modalData.index, @js(get_class($block))
            ) && close()">
                {{ $block->label() }} -
                {{ $block->description() }}
            </li>
        @endforeach
    </ul>

    <x-filament::modal.actions>
        <x-filament::button x-on:click.prevent="close()">
            Cancel
        </x-filament::button>
    </x-filament::modal.actions>
</x-filament::modal>
