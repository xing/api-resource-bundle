<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Configuration\FieldOptions;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\StringField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

#[CoversClass(StringField::class)]
class StringFieldTest extends TestCase
{
    private StringField $testField;

    protected function setUp(): void
    {
        $this->testField = new StringField();
    }

    public function testItIsOfTypeStringField(): void
    {
        $this->assertEquals(FieldType::STRING, $this->testField->getType());
    }
}