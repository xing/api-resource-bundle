<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

class BoolField extends FieldOptions
{
    const TYPE = 'bool';

    /**
     * @param bool $required
     * @param bool $default
     */
    public function __construct(bool $required = false, bool $default = false)
    {
        parent::__construct(self::TYPE, $required, $default);
    }
}
