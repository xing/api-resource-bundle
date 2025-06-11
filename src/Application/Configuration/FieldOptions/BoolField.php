<?php

namespace Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions;

class BoolField extends FieldOptions
{
    const string TYPE = 'bool';

    public function __construct(bool $required = false, bool $default = false)
    {
        parent::__construct(self::TYPE, $required, $default);
    }
}
