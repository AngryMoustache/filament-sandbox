<x-filament::modal id="delete-block">
    <x-filament::modal.heading>
        Are you sure?
    </x-filament::modal.heading>

    <p class="py-1">
        You are about to remove this block along with its contents, this action cannot be undone.
    </p>

    <x-filament::modal.actions :full-width="true">
        <x-filament::button color="secondary" x-on:click.prevent="close()">
            Cancel
        </x-filament::button>

        <x-filament::button color="danger" x-on:click.prevent="$wire.dispatchFormEvent(
            'architect::delete-block', modalData.index
        ) && close()">
            Confirm
        </x-filament::button>
    </x-filament::modal.actions>
</x-filament::modal>
