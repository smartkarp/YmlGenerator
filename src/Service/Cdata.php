<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle;

final class Cdata
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
