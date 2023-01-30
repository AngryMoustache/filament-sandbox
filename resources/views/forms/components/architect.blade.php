<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-action="$getHintAction()"
    :hint-color="$getHintColor()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div x-data="{
        state: $wire.entangle('{{ $getStatePath() }}').defer,
        modalData: [],
        openModal (modalId, data = {}) {
            this.modalData = data

            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: { id: modalId }
            }))
        },
    }">

        <div
            class="flex flex-col gap-4"
            wire:sortable
            wire:end.stop="dispatchFormEvent('architect::sort-blocks', $event.target.sortable.toArray())"
        >
            <x-buttons.plus />

            @foreach ($getState() as $index => $block)
                <div
                    x-data="{ collapsed: false }"
                    wire:key="block-{{ $getStatePath() }}-{{ $index }}"
                    wire:sortable.item="{{ $index }}"
                >
                    <div class="border rounded-lg">
                        <div class="flex justify-between items-center px-4 py-2 bg-gray-100">
                            <div
                                class="flex gap-4 items-center"
                                wire:sortable.handle
                            >
                                <x-heroicon-o-menu class="h-4 w-4 cursor-move text-gray-600" />
                                <span class="font-bold">{{ $block['label'] }}</span>
                            </div>

                            <div class="flex gap-2 items-center">
                                <span
                                    class="transition duration-200"
                                    x-on:click.prevent="collapsed = ! collapsed"
                                    :style="collapsed ? 'transform: rotate(180deg)' : ''"
                                >
                                    <x-heroicon-o-chevron-down
                                        class="p-1 h-8 w-8 cursor-pointer text-gray-400"
                                    />
                                </span>

                                <span x-on:click.prevent="openModal('delete-block', { index: {{ $index }} })">
                                    <x-heroicon-s-trash
                                        class="p-1 h-8 w-8 cursor-pointer text-gray-400"
                                    />
                                </span>
                            </div>
                        </div>

                        {{-- FORM FIELDS --}}
                        <div
                            x-show="! collapsed"
                            x-transition
                            style="display: none"
                            class="px-6 py-4 border-t"
                        >
                            {!! Livewire::mount($block['object']->getName(), [
                                'block' => $block,
                            ])->html() !!}
                        </div>
                    </div>

                    <x-buttons.plus :$index />
                </div>
            @endforeach
        </div>

        {{-- Modals --}}
        <x-modals.add-block :blocks="$getBlocks()" />
        <x-modals.delete-block />
    </div>
</x-dynamic-component>
