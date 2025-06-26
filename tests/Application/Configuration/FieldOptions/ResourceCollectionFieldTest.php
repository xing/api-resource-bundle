<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Configuration\FieldOptions;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Prescreen\ApiResourceBundle\Application\ApiResources\ExampleResource;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\ResourceCollectionField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

#[CoversClass(ResourceCollectionField::class)]
class ResourceCollectionFieldTest extends TestCase
{
    private ResourceCollectionField $testField;

    protected function setUp(): void
    {
        $this->testField = new ResourceCollectionField(ExampleResource::class);
    }

    public function testItIsOfTypeResourceCollectionField(): void
    {
        $this->assertEquals(FieldType::RESOURCE_COLLECTION, $this->testField->getType());
    }
}