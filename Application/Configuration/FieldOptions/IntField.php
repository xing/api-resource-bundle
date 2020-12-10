<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

class IntField extends FieldOptions
{
    const TYPE = 'int';

    /**
     * @var int
     */
    private $min;
    /**
     * @var int
     */
    private $max;

    /**
     * @param int|null $min
     * @param int|null $max
     * @param bool $required
     */
    public function __construct(
        int $min = null,
        int $max = null,
        bool $required = false
    ) {
        parent::__construct(IntField::TYPE, $required);
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * @return int
     */
    public function getMin(): ?int
    {
        return $this->min;
    }

    /**
     * @return int
     */
    public function getMax(): ?int
    {
        return $this->max;
    }
}
