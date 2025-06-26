<?php

namespace Xing\ApiResourceBundle\Application\Services\Validators;

use Xing\ApiResourceBundle\Application\Enum\FieldType;

class EmailValidator extends StringValidator
{
    public function getType(): string
    {
        return FieldType::EMAIL;
    }
}
