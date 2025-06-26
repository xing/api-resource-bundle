<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Configuration\FieldOptions;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Prescreen\ApiResourceBundle\Application\ApiResources\ExampleResource;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\ResourceField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

#[CoversClass(ResourceField::class)]
class ResourceFieldTest extends TestCase
{
    private ResourceField $testField;

    protected function setUp(): void
    {
        $this->testField = new ResourceField(ExampleResource::class);
    }

    public function testItIsOfTypeResourceField(): void
    {
        $this->assertEquals(FieldType::RESOURCE, $this->testField->getType());
    }
}