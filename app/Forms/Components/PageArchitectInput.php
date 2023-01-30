<?php

namespace App\Forms\Components;

use App\Blocks;

class PageArchitectInput extends ArchitectInput
{
    public array $blocks = [
        Blocks\TextBlock::class,
        Blocks\ImageBlock::class,
    ];

    public function blocks(array $blocks, bool $withDefaults = true): self
    {
        $this->blocks = $withDefaults
            ? array_merge($this->blocks, $blocks)
            : $blocks;

        return $this;
    }
}
