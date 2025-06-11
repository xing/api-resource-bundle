<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services;

use Prescreen\ApiResourceBundle\Application\Services\ExampleTranslationResourceTransformer;
use Prescreen\ApiResourceBundle\Application\Services\Validators\ApiValidatorRegistry;
use Prescreen\ApiResourceBundle\Application\Services\Validators\StringValidator;
use Prescreen\ApiResourceBundle\Entity\ExampleTranslationEntity;
use PHPUnit\Framework\TestCase;

class ExampleTranslationResourceTransformerTest extends TestCase
{
    protected ApiValidatorRegistry $apiValidatorRegistry;
    private ExampleTranslationResourceTransformer $testService;

    public function setUp(): void
    {
        $this->apiValidatorRegistry = $this->createMock(ApiValidatorRegistry::class);
        $this->testService = new ExampleTranslationResourceTransformer($this->apiValidatorRegistry);
    }

    public function testItFillsEntityFromGivenArray(): void
    {
        $entity = new ExampleTranslationEntity();

        $stringValidator = new StringValidator();

        $this->apiValidatorRegistry->expects($this->exactly(2))
            ->method('get')
            ->willReturnOnConsecutiveCalls(
                $stringValidator,
                $stringValidator
            );

        $this->testService->fromArray([
            'name' => 'Cool translation',
            'locale' => 'en'
        ], $entity);

        $this->assertEquals('Cool translation', $entity->getName());
        $this->assertEquals('en', $entity->getLocale());
    }

    public function testItFillsResourceFieldsFromGivenEntity(): void
    {
        $entity = new ExampleTranslationEntity();
        $entity->setId(1);
        $entity->setName('Cool translation');
        $entity->setLocale('en');

        $resource = $this->testService->fromEntity($entity);

        $this->assertEquals(1, $resource->id);
        $this->assertEquals('Cool translation', $resource->name);
        $this->assertEquals('en', $resource->locale);
    }
}
