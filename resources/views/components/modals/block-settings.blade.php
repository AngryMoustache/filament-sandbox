@props([
    'statePath',
    'fields',
])

<x-filament::modal id="block-settings" width="4xl">
    <x-filament::modal.heading>
        Block settings
    </x-filament::modal.heading>

    <div class="mt-4 mb-6" wire:loading>
        Loading the settings, please wait
    </div>

    <div class="mt-4 mb-6" wire:loading.remove>
        {{ $fields }}
    </div>

    <x-filament::modal.actions :full-width="true">
        <x-filament::button color="secondary" x-on:click.prevent="close()">
            Cancel
        </x-filament::button>

        <x-filament::button color="danger" x-on:click.prevent="$wire.dispatchFormEvent(
            'architect::updateSettings', '{{ $statePath }}', modalData.index
        ) && close()">
            Confirm
        </x-filament::button>
    </x-filament::modal.actions>
</x-filament::modal>
