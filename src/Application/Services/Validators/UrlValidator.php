<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

class UrlValidator extends StringValidator
{
    public function getType(): string
    {
        return FieldType::URL;
    }
}
