<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

class FloatField extends IntField
{
    const TYPE = 'float';

    /**
     * @param int|null $min
     * @param int|null $max
     * @param bool $required
     */
    public function __construct(
        int $min = null,
        int $max = null,
        bool $required = false
    ) {
        parent::__construct($min, $max, $required);
        $this->type = self::TYPE;
    }
}
