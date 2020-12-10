<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\BoolField;
use Prescreen\ApiResourceBundle\Application\Services\Validators\BoolValidator;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use PHPUnit\Framework\TestCase;

class BoolValidatorTest extends TestCase
{
    /**
     * @var BoolValidator
     */
    private $testService;

    public function setUp(): void
    {
        $this->testService = new BoolValidator();
    }

    /**
     * @test
     */
    public function givenValueIsNotOfTypeBoolThenThrowException()
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('someField', 'string value', new BoolField());
    }

    /**
     * @test
     */
    public function givenValueIsOfTypeBoolThenReturnIt()
    {
        $this->assertTrue($this->testService->validate('someField', true, new BoolField()));
    }

    /**
     * @test
     */
    public function itIsOfTypeBool()
    {
        $this->assertSame(BoolField::TYPE, $this->testService->getType());
    }
}
