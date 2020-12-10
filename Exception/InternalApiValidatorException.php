<?php

namespace Prescreen\ApiResourceBundle\Exception;

class InternalApiValidatorException extends \Exception
{
    /**
     * @var string
     */
    protected $fieldName;

    /**
     * @param string $fieldName
     * @param string $message
     */
    public function __construct(string $fieldName, string $message)
    {
        $message = sprintf('Error in field: "%s".', $fieldName) . ' ' . $message;

        parent::__construct($message);
        $this->fieldName = $fieldName;
    }
}
