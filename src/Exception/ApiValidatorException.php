<?php

namespace Xing\ApiResourceBundle\Exception;

class ApiValidatorException extends \Exception
{
    public function __construct(protected readonly string $fieldName, string $message)
    {
        $message = sprintf('Error in field: "%s".', $fieldName) . ' ' . $message;

        parent::__construct($message);
    }
}
