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
                detail: { id: modalId + '-{{ $getStatePath() }}' }
            }))
        },
    }">

        <div
            class="flex flex-col gap-4"
            wire:sortable
            wire:end.stop="dispatchFormEvent('repeater::moveItems', '{{ $getStatePath() }}', $event.target.sortable.toArray())"
        >
            <x-buttons.plus />

            @foreach ($getChildComponentContainers() as $uuid => $block)
                <div
                    x-data="{ collapsed: false }"
                    wire:key="block-{{ $getStatePath() }}-{{ $uuid }}"
                    wire:sortable.item="{{ $uuid }}"
                >
                    <div class="border rounded-lg overflow-hidden">
                        <div class="flex justify-between items-center px-4 py-2 bg-gray-100">
                            <div
                                class="flex gap-4 items-center"
                                wire:sortable.handle
                            >
                                <x-heroicon-o-menu class="h-4 w-4 cursor-move text-gray-600" />
                                <span class="font-bold">{{ $block->block['object']->label() }}</span>
                            </div>

                            <div class="flex gap-2 items-center">
                                @if (count($block->block['object']->settings()) > 0)
                                    <span x-on:click.prevent="$wire.dispatchFormEvent(
                                        'architect::openSettings',
                                        '{{ $getStatePath() }}',
                                        '{{ $uuid }}'
                                    ) && openModal('block-settings', { index: '{{ $uuid }}' })">
                                        <x-heroicon-o-cog
                                            class="p-1 h-8 w-8 cursor-pointer text-gray-400"
                                        />
                                    </span>
                                @endif

                                <span
                                    class="transition duration-200"
                                    x-on:click.prevent="collapsed = ! collapsed"
                                    :style="collapsed ? 'transform: rotate(180deg)' : ''"
                                >
                                    <x-heroicon-o-chevron-down
                                        class="p-1 h-8 w-8 cursor-pointer text-gray-400"
                                    />
                                </span>

                                <span x-on:click.prevent="openModal('delete-block', { index: '{{ $uuid }}' })">
                                    <x-heroicon-s-trash
                                        class="p-1 h-8 w-8 cursor-pointer text-gray-400"
                                    />
                                </span>
                            </div>
                        </div>

                        <div
                            style="display: none"
                            class="px-6 py-4 border-t"
                            wire:key="block-{{ $getStatePath() }}-{{ $uuid }}-fields"
                            x-show="! collapsed"
                            x-transition
                        >
                            {{ $block }}
                        </div>
                    </div>

                    <x-buttons.plus :index="$uuid" />
                </div>
            @endforeach
        </div>

        {{-- Modals --}}
        <x-modals.add-block :blocks="$getBlocks()" :state-path="$getStatePath()" />
        <x-modals.delete-block :state-path="$getStatePath()" />
        <x-modals.block-settings
            :state-path="$getStatePath()"
            :fields="$getSettingsChildComponentContainer()"
        />
    </div>
</x-dynamic-component>
