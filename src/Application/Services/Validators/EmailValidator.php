<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

class EmailValidator extends StringValidator
{
    public function getType(): string
    {
        return FieldType::EMAIL;
    }
}
