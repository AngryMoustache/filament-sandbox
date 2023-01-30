<?php

namespace App\Http\Livewire\Wireables;

use App\Blocks\Block;
use Illuminate\Support\Collection;
use Livewire\Wireable;

class BlockCollection implements Wireable
{
    public Collection $items;

    public function __construct(array $blocks)
    {
        $this->items = collect($blocks)->mapWithKeys(function ($block) {
            return [$block => new $block];
        });
    }

    public function get(string $class): Block
    {
        return $this->items[$class];
    }

    public function toLivewire()
    {
        return [
            'items' => $this->items->values()
                ->map(fn ($block) => get_class($block))
                ->toArray(),
        ];
    }

    public static function fromLivewire($value)
    {
        return new static($value['items']);
    }
}
