<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

interface ApiValidatorInterface
{
    public function validate(string $fieldName, mixed $value, FieldOptions $fieldOptions, mixed $oldValue);

    public function getType(): FieldType;
}
