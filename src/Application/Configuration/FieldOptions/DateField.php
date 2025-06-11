<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

class DateField extends FieldOptions
{
    public function __construct(bool $required = false)
    {
        parent::__construct($required);
    }

    public function getType(): FieldType
    {
        return FieldType::DATE;
    }
}
