<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class ArchitectInput extends Field
{
    protected string $view = 'forms.components.architect';

    public array $blocks = [];

    public function getBlocks(): array
    {
        return $this->blocks;
    }
}
