<?php

namespace Xing\ApiResourceBundle\Application\Configuration\FieldOptions;

use Xing\ApiResourceBundle\Application\Enum\FieldType;

class IntField extends FieldOptions
{
    public function __construct(
        protected readonly ?int $min = null,
        protected readonly ?int $max = null,
        bool $required = false,
    ) {
        parent::__construct($required);
    }

    public function getMin(): ?int
    {
        return $this->min;
    }

    public function getMax(): ?int
    {
        return $this->max;
    }

    public function getType(): string
    {
        return FieldType::INT;
    }
}
