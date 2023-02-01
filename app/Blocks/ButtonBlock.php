<?php

namespace App\Blocks;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;

class ButtonBlock extends Block
{
    public function label(): string
    {
        return 'CTA Button';
    }

    public function description(): string
    {
        return 'A simple button.';
    }

    public function fields(array $settings = []): array
    {
        return [
            TextInput::make('label')->required(),

            TextInput::make('link')->required(),

            Checkbox::make('new_tab')
                ->label('Open in new tab'),
        ];
    }
}
