<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

class HtmlField extends FieldOptions
{
    public function __construct(private bool $purify = true, bool $required = false)
    {
        parent::__construct($required);
    }

    public function getPurify(): bool
    {
        return $this->purify;
    }

    public function getType(): string
    {
        return FieldType::HTML;
    }
}
