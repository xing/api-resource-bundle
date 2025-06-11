<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\UrlField;

class UrlValidator extends StringValidator
{
    public function getType(): string
    {
        return UrlField::TYPE;
    }
}
