<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Configuration\FieldOptions;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\HtmlField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

#[CoversClass(HtmlField::class)]
class HtmlFieldTest extends TestCase
{
    private HtmlField $testField;

    protected function setUp(): void
    {
        $this->testField = new HtmlField();
    }

    public function testItIsOfTypeHtmlField(): void
    {
        $this->assertEquals(FieldType::HTML, $this->testField->getType());
    }
}