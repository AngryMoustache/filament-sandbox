<?php

namespace App\Blocks;

use Filament\Forms\Components\Field;

abstract class Block
{
    abstract public function label(): string;
    abstract public function description(): string;
    abstract public function fields(array $settings = []): array;

    public function getFields(array $settings = [])
    {
        return collect($this->fields($settings))->each(function (Field $field) {
            $field->statePath('data.' . $field->getName());
        })->toArray();
    }

    public function getSettingFields()
    {
        return collect($this->settings())->each(function (Field $field) {
            $field->statePath('settings.' . $field->getName());
        })->toArray();
    }

    public function settings(): array
    {
        return [];
    }
}
