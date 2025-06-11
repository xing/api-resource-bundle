<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

class UrlField extends FieldOptions
{
    const string TYPE = 'url';
    const string REGEX = '#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#';

    public function __construct(
        bool $required = false,
        string $regex = self::REGEX,
    ) {
        parent::__construct(self::TYPE, $required);

        $this->regex = $regex;
    }
}
