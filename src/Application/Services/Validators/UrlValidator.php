<?php

namespace Xing\ApiResourceBundle\Application\Services\Validators;

use Xing\ApiResourceBundle\Application\Enum\FieldType;

class UrlValidator extends StringValidator
{
    public function getType(): string
    {
        return FieldType::URL;
    }
}
