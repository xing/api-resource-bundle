<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Configuration\FieldOptions;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\UrlField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

#[CoversClass(UrlField::class)]
class UrlFieldTest extends TestCase
{
    private UrlField $testField;

    protected function setUp(): void
    {
        $this->testField = new UrlField();
    }

    public function testItIsOfTypeUrlField(): void
    {
        $this->assertEquals(FieldType::URL, $this->testField->getType());
    }
}