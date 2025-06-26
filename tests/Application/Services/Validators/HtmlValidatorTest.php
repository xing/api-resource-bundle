<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services\Validators;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\HtmlField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;
use Prescreen\ApiResourceBundle\Application\Services\HtmlPurifier;
use Prescreen\ApiResourceBundle\Application\Services\Validators\HtmlValidator;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;

#[CoversClass(HtmlValidator::class)]
class HtmlValidatorTest extends TestCase
{
    private HtmlPurifier $htmlPurifier;
    private HtmlValidator $testService;

    protected function setUp(): void
    {
        $this->htmlPurifier = $this->createMock(HtmlPurifier::class);

        $this->testService = new HtmlValidator($this->htmlPurifier);
    }

    public function testItThrowsExceptionIfValueIsNotOfTypeHtml(): void
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('string', false, new HtmlField());
    }

    public function testItReturnsHtml(): void
    {
        $this->assertSame('<p>some value</p>', $this->testService->validate('string', '<p>some value</p>', new HtmlField(purify: false)));
    }

    public function testItReturnsPurifiedHtml(): void
    {
        $this->htmlPurifier->expects($this->once())->method('purify')->willReturn('<p>some value</p>');

        $this->assertSame('<p>some value</p>', $this->testService->validate('string', '<p><img onerror="alert(1);">some value</p>', new HtmlField()));
    }

    public function testItReturnsUnpurifiedHtml(): void
    {
        $this->htmlPurifier->expects($this->never())->method('purify');

        $this->assertSame('<p><img onerror="alert(1);">some value</p>', $this->testService->validate('string', '<p><img onerror="alert(1);">some value</p>', new HtmlField(false)));
    }

    public function testItReturnsNullIfValueIsNullAndFieldIsNotRequired(): void
    {
        $this->assertNull($this->testService->validate('string', null, new HtmlField()));
    }

    public function testItIsOfTypeHtml(): void
    {
        $this->assertSame(FieldType::HTML, $this->testService->getType());
    }
}
