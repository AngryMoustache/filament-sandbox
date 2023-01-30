<?php

namespace App\Blocks;

use Filament\Forms\Components\TextInput;

class TextBlock extends Block
{
    public function label(): string
    {
        return 'Text';
    }

    public function description(): string
    {
        return 'A simple text block.';
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->required(),

            TextInput::make('subtitle')
                ->required(),
        ];
    }
}
