<?php

namespace App\Blocks;

abstract class Block
{
    public array $state = [];

    abstract public function label(): string;
    abstract public function description(): string;
    abstract public function form(): array;
}
