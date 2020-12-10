<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;

interface ApiValidatorInterface
{
    public function validate(string $fieldName, $value, FieldOptions $fieldOptions, $oldValue);

    public function getType(): string;
}
