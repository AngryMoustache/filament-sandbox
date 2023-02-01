<?php

namespace App\Forms\Components;

use App\SettingsBag;
use Filament\Forms\Components\Repeater;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ArchitectInput extends Repeater
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

        $this->registerListeners([
            'architect::createBlock' => [
                function (ArchitectInput $component, string $statePath, string $uuid, string $block): void {
                    if ($statePath !== $component->getStatePath()) {
                        return;
                    }

                    $state = $component->getState() ?? [];

                    $newUuid = (string) Str::uuid();
                    $newBlock = [
                        'type' => $block,
                        'data' => [],
                        'settings' => [],
                    ];

                    // Put the new block after the selected item with $uuid if it's not 0
                    if ($uuid === '0') {
                        $state = [$newUuid => $newBlock] + $state;
                    } else {
                        $index = array_search($uuid, array_keys($state));
                        $state = array_merge(
                            array_slice($state, 0, $index + 1),
                            [$newUuid => $newBlock],
                            array_slice($state, $index + 1)
                        );
                    }

                    $this->saveState($component, $state);
                },
            ],
            'architect::openSettings' => [
                function (ArchitectInput $component, string $statePath, string $uuid): void {
                    if ($statePath !== $component->getStatePath()) {
                        return;
                    }

                    $livewire = $component->getLivewire();
                    data_set($livewire, 'settingsUuid', $uuid);
                },
            ],
            'architect::updateSettings' => [
                function (ArchitectInput $component, string $statePath, string $uuid): void {
                    if ($statePath !== $component->getStatePath()) {
                        return;
                    }

                    $this->saveState($component, $component->getState());
                },
            ],
        ]);

        $this->dehydrateStateUsing(function (array &$state) {
            // Remove unimportant data
            foreach (array_keys($state) as $uuid) {
                unset($state[$uuid]['object']);
            }

            return $state;
        });
    }

    public function saveState(ArchitectInput $component, array $state)
    {
        $livewire = $component->getLivewire();
        data_set($livewire, $component->getStatePath(), $state);
    }

    public function getState(): array
    {
        return collect(parent::getState() ?? [])
            ->filter()
            ->map(function ($block) {
                $object = new $block['type'];
                $object->getSettingFields();

                $block['object'] = $object;
                $block['object']->state = $block['data'];
                $block['settings'] += $object->defaultSettings;

                return $block;
            })
            ->toArray();
    }

    public function getChildComponentContainers(bool $withHidden = false): array
    {
        $containers = parent::getChildComponentContainers($withHidden);
        $state = $this->getState();

        foreach ($state ?? [] as $uuid => $block) {
            $containers[$uuid]->block = $block;
            $containers[$uuid]->components((new $block['type'])->getFields(
                $block['settings'] ?? []
            ));
        }

        return $containers;
    }

    public function getSettingsChildComponentContainer()
    {
        $containers = parent::getChildComponentContainers();

        $livewire = $this->getLivewire();
        $uuid = data_get($livewire, 'settingsUuid');

        if (! $uuid) {
            return null;
        }

        $state = $this->getState();
        $block = $state[$uuid] ?? null;
        if (! $block) {
            return null;
        }

        $containers[$uuid]->block = $block;
        $containers[$uuid]->components((new $block['type'])->getSettingFields());

        return $containers[$uuid];
    }
}
