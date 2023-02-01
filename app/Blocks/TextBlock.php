<?php

namespace App\Blocks;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
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

    public function fields(array $settings = []): array
    {
        $columns = [];
        for ($i = 1; $i <= 3; $i++) {
            // TODO: markdown valdiation
            $columns[] = Textarea::make("content_{$i}")
                ->hidden(fn () => $i > ($settings['columns'] ?? 1))
                ->required();
        }

        return [
            Grid::make(($settings['has_subtitle'] ?? true) ? 2 : 1)->schema([
                TextInput::make('title')
                    ->required(),

                TextInput::make('subtitle')
                    ->hidden(fn () => ! ($settings['has_subtitle'] ?? true))
                    ->required(),
            ]),

            ...$columns,
        ];
    }

    public function settings(): array
    {
        return [
            Grid::make(2)->schema([
                TextInput::make('columns')
                    ->label('Number of columns')
                    ->type('number')
                    ->rules(['min:1'])
                    ->default(1)
                    ->required(),
            ]),

            Checkbox::make('has_subtitle')
                ->label('Has a subtitle')
                ->default(false),
        ];
    }
}
