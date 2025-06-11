<?php

namespace Prescreen\ApiResourceBundle\src\Application\Services\Validators;

use Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions\EmailField;

class EmailValidator extends StringValidator
{
    public function getType(): string
    {
        return EmailField::TYPE;
    }
}
