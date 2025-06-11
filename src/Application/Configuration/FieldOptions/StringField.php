<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

class StringField extends FieldOptions
{
    public function __construct(
        bool $required = false,
        ?string $regex = null,
    ) {
        parent::__construct($required);

        $this->regex = $regex;
    }

    public function getType(): FieldType
    {
        return FieldType::STRING;
    }
}
