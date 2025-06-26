<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Configuration\FieldOptions;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\IdCollectionField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;
use Prescreen\ApiResourceBundle\Entity\ExampleEntity;

#[CoversClass(IdCollectionField::class)]
class IdCollectionFieldTest extends TestCase
{
    private IdCollectionField $testField;

    protected function setUp(): void
    {
        $this->testField = new IdCollectionField(ExampleEntity::class);
    }

    public function testItIsOfTypeIdCollectionField(): void
    {
        $this->assertEquals(FieldType::ID_COLLECTION, $this->testField->getType());
    }
}