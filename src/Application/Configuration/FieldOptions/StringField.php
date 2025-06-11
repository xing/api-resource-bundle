<?php

namespace Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions;

class StringField extends FieldOptions
{
    const string TYPE = 'string';

    public function __construct(
        bool $required = false,
        ?string $regex = null,
    ) {
        parent::__construct(self::TYPE, $required);

        $this->regex = $regex;
    }
}
