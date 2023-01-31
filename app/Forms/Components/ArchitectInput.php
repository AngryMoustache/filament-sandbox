<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;
use Illuminate\Support\Collection;
use Livewire\Livewire;

class ArchitectInput extends Field
{
    protected string $view = 'forms.components.architect';

    public array $blocks = [];

    public function getBlocks(): Collection
    {
        return collect($this->blocks)->map(fn ($block) => new $block);
    }

    protected function setUp(): void
    {
        parent::setUp();

        // TODO: doesn't work after hydrate - set Livewire aliases for rendering forms
        // collect($this->blocks)->each(function (string $block) {
        //     Livewire::component((new $block)->getName(), $block);
        // });

        $this->registerListeners([
            'architect::add-block' => [
                function (ArchitectInput $component, int $index, string $block): void {
                    $state  = $component->getState();

                    $state = array_merge(
                        array_slice($state, 0, $index),
                        [[
                            'id' => uniqid(),
                            'type' => $block,
                            'label' => (new $block)->label(),
                            'data' => [],
                        ]],
                        array_slice($state, $index)
                    );

                    $this->saveState($component, $state);
                },
            ],
            'architect::delete-block' => [
                function (ArchitectInput $component, int $index): void {
                    $state  = $component->getState();

                    $state = array_merge(
                        array_slice($state, 0, $index),
                        array_slice($state, $index + 1)
                    );

                    $this->saveState($component, $state);
                },
            ],
            'architect::sort-blocks' => [
                function (ArchitectInput $component, array $order): void {
                    $state  = $component->getState();

                    $state = collect($order)
                        ->map(fn ($index) => $state[$index])
                        ->toArray();

                    $this->saveState($component, $state);
                },
            ],
            'architect::update-block-fields' => [
                function (ArchitectInput $component, array $data): void {
                    $state  = $component->getState();

                    $state = collect($state)->map(function ($block) use ($data) {
                        if ($block['id'] === $data['blockId']) {
                            $block['data'] = $data['state'];
                        }

                        return $block;
                    })->toArray();

                    $this->saveState($component, $state);
                },
            ],
        ]);
    }

    public function saveState(ArchitectInput $component, array $state)
    {
        $livewire = $component->getLivewire();
        data_set($livewire, $component->getStatePath(), $state);
    }

    public function getState(): array
    {
        return collect(parent::getState() ?? [])->map(function ($block) {
            $block['object'] = new $block['type'];
            $block['object']->state = $block['data'];

            return $block;
        })->toArray();
    }
}
