<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Configuration\FieldOptions;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FloatField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

#[CoversClass(FloatField::class)]
class FloatFieldTest extends TestCase
{
    private FloatField $testField;

    protected function setUp(): void
    {
        $this->testField = new FloatField();
    }

    public function testItIsOfTypeFloatField(): void
    {
        $this->assertEquals(FieldType::FLOAT, $this->testField->getType());
    }
}