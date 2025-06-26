<?php

namespace Xing\ApiResourceBundle\Application\Configuration\FieldOptions;

use Xing\ApiResourceBundle\Application\Enum\FieldType;

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
