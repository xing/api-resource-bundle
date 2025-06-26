<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Configuration\FieldOptions;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\IdField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;
use Prescreen\ApiResourceBundle\Entity\ExampleEntity;

#[CoversClass(IdField::class)]
class IdFieldTest extends TestCase
{
    private IdField $testField;

    protected function setUp(): void
    {
        $this->testField = new IdField(ExampleEntity::class);
    }

    public function testItIsOfTypeIdField(): void
    {
        $this->assertEquals(FieldType::ID, $this->testField->getType());
    }
}