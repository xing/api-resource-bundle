<?php

namespace Xing\ApiResourceBundle\Application\Configuration\FieldOptions;

use Xing\ApiResourceBundle\Application\Enum\FieldType;

class JsonField extends FieldOptions
{
    public function __construct(bool $required = false)
    {
        parent::__construct($required);
    }

    public function getType(): string
    {
        return FieldType::JSON;
    }
}
