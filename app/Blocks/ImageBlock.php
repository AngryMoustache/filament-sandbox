<?php

namespace App\Blocks;

use App\Forms\Components\ArchitectInput;
use Filament\Forms\Components\Checkbox;
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

    public function fields(array $settings = []): array
    {
        return [
            TextInput::make('image_link')
                // ->rules('email')
                ->required(),

            TextInput::make('caption')
                ->hidden(fn () => ! ($settings['show_caption'] ?? false)),
        ];
    }

    public function settings(): array
    {
        return [
            Checkbox::make('show_caption')
                ->label('Has a caption under the image'),
        ];
    }
}
