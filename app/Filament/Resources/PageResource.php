<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Forms\Components\PageArchitectInput;
use App\Models\Page;
use Closure;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('General info')
                ->columns(1)
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->autofocus()
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set, ?string $state) {
                            $set('slug', Str::slug($state));
                        }),

                    // Repeater::make('test')
                    //     ->schema([
                    //         TextInput::make('title')->required(),
                    //         TextInput::make('slug')
                    //     ]),

                    PageArchitectInput::make('body'),

                    // TableRepeater::make('test')->schema([
                    //     TextInput::make('title'),
                    // ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
