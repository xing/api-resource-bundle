<?php

namespace Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions;

class FloatField extends IntField
{
    const string TYPE = 'float';

    public function __construct(
        int $min = null,
        int $max = null,
        bool $required = false,
    ) {
        parent::__construct($min, $max, $required);
        $this->type = self::TYPE;
    }
}
