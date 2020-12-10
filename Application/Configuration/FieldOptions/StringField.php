<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

class StringField extends FieldOptions
{
    const TYPE = 'string';

    /**
     * @param bool $required
     */
    public function __construct(bool $required = false)
    {
        parent::__construct(self::TYPE, $required);
    }
}
