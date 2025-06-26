<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Configuration\FieldOptions;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\DateField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

#[CoversClass(DateField::class)]
class DateFieldTest extends TestCase
{
    private DateField $testField;

    protected function setUp(): void
    {
        $this->testField = new DateField();
    }

    public function testItIsOfTypeDateField(): void
    {
        $this->assertEquals(FieldType::DATE, $this->testField->getType());
    }
}