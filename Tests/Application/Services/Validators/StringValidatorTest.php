<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\StringField;
use Prescreen\ApiResourceBundle\Application\Services\Validators\StringValidator;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use PHPUnit\Framework\TestCase;

class StringValidatorTest extends TestCase
{
    /**
     * @var StringValidator
     */
    private $testService;

    public function setUp(): void
    {
        $this->testService = new StringValidator();
    }

    /**
     * @test
     */
    public function givenValueIsNotOfTypeStringThenThrowException()
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('string', false, new StringField());
    }

    /**
     * @test
     */
    public function givenValidStringValueThenReturnIt()
    {
        $this->assertSame('Some value', $this->testService->validate('string', 'Some value', new StringField()));
    }

    /**
     * @test
     */
    public function givenFieldIsNotRequiredAndValueIsNullThenReturnNull()
    {
        $this->assertNull($this->testService->validate('string', null, new StringField()));
    }

    /**
     * @test
     */
    public function itIsOfTypeString()
    {
        $this->assertSame(StringField::TYPE, $this->testService->getType());
    }
}
