<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Configuration\FieldOptions;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\BoolField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

#[CoversClass(BoolField::class)]
class BoolFieldTest extends TestCase
{
    private BoolField $testField;

    protected function setUp(): void
    {
        $this->testField = new BoolField();
    }

    public function testItIsOfTypeBoolField(): void
    {
        $this->assertEquals(FieldType::BOOL, $this->testField->getType());
    }
}