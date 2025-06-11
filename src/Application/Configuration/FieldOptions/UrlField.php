<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

class UrlField extends FieldOptions
{
    const string REGEX = '#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#';

    public function __construct(
        bool $required = false,
        string $regex = self::REGEX,
    ) {
        parent::__construct($required);

        $this->regex = $regex;
    }

    public function getType(): FieldType
    {
        return FieldType::URL;
    }
}
