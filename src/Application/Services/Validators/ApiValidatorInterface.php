<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;

interface ApiValidatorInterface
{
    public function validate(string $fieldName, mixed $value, FieldOptions $fieldOptions, mixed $oldValue);

    public function getType(): string;
}
