<div x-data="{
    openModal (modalId, data = []) {
        $wire.set('modalData', data, true)

        window.dispatchEvent(new CustomEvent('open-modal', {
            detail: { id: modalId }
        }))
    }
}">
    <div class="flex flex-col gap-4">
        <x-filament::button x-on:click="openModal('new-block', { index: 0 })">
            +
        </x-filament::button>

        @foreach ($state as $key => $block)
            {{ $block['label'] }}

            <x-filament::button x-on:click="openModal('new-block', { index: {{ $key + 1 }} })">
                +
            </x-filament::button>
        @endforeach
    </div>

    {{-- Add block modal --}}
    <x-filament::modal id="new-block" width="7xl">
        <x-filament::modal.heading>
            Adding a new block
        </x-filament::modal.heading>

        <ul>
            @foreach ($blocks->items as $block)
                <li x-on:click="$wire.addBlock(@js(get_class($block))) && close()">
                    {{ $block->label() }} -
                    {{ $block->description() }}
                </li>
            @endforeach
        </ul>

        <x-filament::modal.actions>
            <x-filament::button x-on:click="close()">
                Cancel
            </x-filament::button>
        </x-filament::modal.actions>
    </x-filament::modal>
</div>
