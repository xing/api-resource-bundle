<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

class JsonField extends FieldOptions
{
    public function __construct(bool $required = false)
    {
        parent::__construct($required);
    }

    public function getType(): FieldType
    {
        return FieldType::JSON;
    }
}
