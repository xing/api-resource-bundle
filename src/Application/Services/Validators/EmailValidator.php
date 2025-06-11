<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

class EmailValidator extends StringValidator
{
    public function getType(): FieldType
    {
        return FieldType::EMAIL;
    }
}
