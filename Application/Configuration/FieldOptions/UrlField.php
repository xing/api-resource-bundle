<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

class UrlField extends FieldOptions
{
    const TYPE = 'url';
    const REGEX = '#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#';

    /**
     * @param bool $required
     * @param string $regex
     */
    public function __construct(bool $required = false, string $regex = self::REGEX)
    {
        parent::__construct(self::TYPE, $required);

        $this->regex = $regex;
    }
}
