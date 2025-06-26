<?php

namespace Xing\ApiResourceBundle\Application\Services\Validators;

use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;

interface ApiValidatorInterface
{
    public function validate(string $fieldName, mixed $value, FieldOptions $fieldOptions, mixed $oldValue);

    public function getType(): string;
}
