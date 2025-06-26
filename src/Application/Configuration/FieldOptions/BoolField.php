<?php

namespace Xing\ApiResourceBundle\Application\Configuration\FieldOptions;

use Xing\ApiResourceBundle\Application\Enum\FieldType;

class BoolField extends FieldOptions
{
    public function __construct(bool $required = false, bool $default = false)
    {
        parent::__construct($required, $default);
    }

    public function getType(): string
    {
        return FieldType::BOOL;
    }
}
