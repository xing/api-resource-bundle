<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Configuration\FieldOptions;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\JsonField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

#[CoversClass(JsonField::class)]
class JsonFieldTest extends TestCase
{
    private JsonField $testField;

    protected function setUp(): void
    {
        $this->testField = new JsonField();
    }

    public function testItIsOfTypeJsonField(): void
    {
        $this->assertEquals(FieldType::JSON, $this->testField->getType());
    }
}