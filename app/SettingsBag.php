<?php

namespace App;

use Illuminate\Support\Arr;

class SettingsBag
{
    public array $_defaults = [];
    public array $_values = [];

    public function __get($name)
    {
        return Arr::get($this->_values, $name)
            ?? Arr::get($this->_defaults, $name)
            ?? null;
    }

    public function fill(array $settings)
    {
        $this->_values += $settings;

        return $this;
    }

    public function setDefault($name, $value)
    {
        Arr::set($this->_defaults, $name, $value);

        return $this;
    }
}
