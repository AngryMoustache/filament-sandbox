<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Wireables\BlockCollection;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class Architect extends Field
{
    public ?array $state;
    // public string $statePath;

    public ?string $modal = null;
    public array $modalData = [];

    public BlockCollection $blocks;

    public function mount(?array $state, array $blockList)
    {
        $this->state = $state ?? [];
        $this->blocks = new BlockCollection($blockList);
    }

    public function addBlock($class)
    {
        $block = $this->blocks->get($class);
        $index = $this->modalData['index'] ?? count($this->state);

        $this->state = array_merge(
            array_slice($this->state, 0, $index),
            [[
                'id' => uniqid(),
                'type' => $class,
                'label' => $block->label(),
                'data' => [],
            ]],
            array_slice($this->state, $index)
        );
    }

    // public function render()
    // {
    //     // Save the state with each render
    //     $this->dispatchBrowserEvent("update-state:{$this->statePath}", $this->state);

    //     return view('livewire.architect', [
    //         //
    //     ]);
    // }
}
