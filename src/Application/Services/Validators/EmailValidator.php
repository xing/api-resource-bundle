<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\EmailField;

class EmailValidator extends StringValidator
{
    public function getType(): string
    {
        return EmailField::TYPE;
    }
}
