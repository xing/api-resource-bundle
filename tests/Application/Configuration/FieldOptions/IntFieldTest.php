<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Configuration\FieldOptions;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\IntField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

#[CoversClass(IntField::class)]
class IntFieldTest extends TestCase
{
    private IntField $testField;

    protected function setUp(): void
    {
        $this->testField = new IntField();
    }

    public function testItIsOfTypeIntField(): void
    {
        $this->assertEquals(FieldType::INT, $this->testField->getType());
    }
}