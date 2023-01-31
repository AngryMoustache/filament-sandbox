<?php

namespace App\Blocks;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class Block extends Component implements HasForms
{
    use InteractsWithForms;

    // abstract public function label(): string;
    // abstract public function description(): string;
    // abstract public function form(): Form;

    public array $state = [];

    public string $fieldId;
    public string $blockId;

    public function mount(string $fieldId, array $block)
    {
        $this->fieldId = $fieldId;
        $this->blockId = $block['id'];

        $this->form->fill($block['data']);
    }

    public function render()
    {
        return view('livewire.block-form', [
            'form' => $this->form,
        ]);
    }

    public function getFormStatePath(): ?string
    {
        return "block-{$this->blockId}";
    }

    public function updateBlockData(): void
    {
        $this->dispatchBrowserEvent("architect::update-block-data:{$this->fieldId}", [
            'blockId' => $this->blockId,
            'state' => $this->form->getState(),
        ]);
    }
}
