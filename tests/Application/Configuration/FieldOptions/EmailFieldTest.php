<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Configuration\FieldOptions;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\EmailField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

#[CoversClass(EmailField::class)]
class EmailFieldTest extends TestCase
{
    private EmailField $testField;

    protected function setUp(): void
    {
        $this->testField = new EmailField();
    }

    public function testItIsOfTypeEmailField(): void
    {
        $this->assertEquals(FieldType::EMAIL, $this->testField->getType());
    }
}