<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

class JsonField extends FieldOptions
{
    const TYPE = 'json';

    /**
     * @param bool $required
     */
    public function __construct(bool $required = false)
    {
        parent::__construct(self::TYPE, $required);
    }
}
