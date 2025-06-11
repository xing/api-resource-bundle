<?php

namespace Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions;

class IntField extends FieldOptions
{
    const string TYPE = 'int';

    public function __construct(
        protected readonly ?int $min = null,
        protected readonly ?int $max = null,
        bool $required = false,
    ) {
        parent::__construct(IntField::TYPE, $required);
    }

    public function getMin(): ?int
    {
        return $this->min;
    }

    public function getMax(): ?int
    {
        return $this->max;
    }
}
