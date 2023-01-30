<?php

namespace App\Blocks;

use Filament\Forms\Components\TextInput;

class ImageBlock extends Block
{
    public function label(): string
    {
        return 'Image';
    }

    public function description(): string
    {
        return 'A simple image block.';
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('image_link')
                ->required(),
        ];
    }
}
