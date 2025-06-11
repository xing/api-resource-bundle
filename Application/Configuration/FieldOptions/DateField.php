<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

class DateField extends FieldOptions
{
    const string TYPE = 'date';

    public function __construct(bool $required = false)
    {
        parent::__construct(self::TYPE, $required);
    }
}
