<?php

namespace Xing\ApiResourceBundle\Application\Configuration\FieldOptions;

use Xing\ApiResourceBundle\Application\Enum\FieldType;

class FloatField extends IntField
{
    public function __construct(
        int $min = null,
        int $max = null,
        bool $required = false,
    ) {
        parent::__construct($min, $max, $required);
    }

    public function getType(): string
    {
        return FieldType::FLOAT;
    }
}
