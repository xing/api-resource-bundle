<?php

namespace Prescreen\ApiResourceBundle\src\Application\Services\Validators;

use Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions\UrlField;

class UrlValidator extends StringValidator
{
    public function getType(): string
    {
        return UrlField::TYPE;
    }
}
