<?php

namespace App\Blocks;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Field;

abstract class Block
{
    abstract public function label(): string;
    abstract public function description(): string;
    abstract public function fields(array $settings = []): array;

    public array $defaultSettings = [];

    public function getFields(array $settings = [])
    {
        $settings += $this->defaultSettings;

        return $this->fillFields($this->fields($settings));
    }

    public function getSettingFields()
    {
        return $this->fillFields($this->settings(), 'settings');
    }

    public function settings(): array
    {
        return [];
    }

    public function fillFields($fields, $prefix = 'data')
    {
        return collect($fields)->each(function (Component $field) use ($prefix) {
            if ($field instanceof Field) {
                $name = $field->getName();
                $field->statePath("{$prefix}.{$name}");

                if ($prefix === 'settings') {
                    $this->defaultSettings[$name] ??= $field->getDefaultState();
                }
            } else {
                // Recursive filling
                $this->fillFields($field->getChildComponents(), $prefix);
            }
        })->toArray();
    }
}
