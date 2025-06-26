<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\BoolField;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\ResourceCollectionField;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\ResourceField;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\StringField;
use Prescreen\ApiResourceBundle\Application\Services\PermissionValidators\CoolPermissionValidator;
use Prescreen\ApiResourceBundle\Application\Services\Validators\ApiValidator;
use Prescreen\ApiResourceBundle\Exception\ApiValidatorException;
use Prescreen\ApiResourceBundle\Exception\WrongObjectTypeGivenException;
use Doctrine\Common\Collections\ArrayCollection;
use Prescreen\ApiResourceBundle\Application\ApiResources\ExampleResource;
use Prescreen\ApiResourceBundle\Application\Services\ExampleResourceTransformer;
use Prescreen\ApiResourceBundle\Application\Services\Validators\ApiValidatorRegistry;
use Prescreen\ApiResourceBundle\Application\Services\Validators\BoolValidator;
use Prescreen\ApiResourceBundle\Application\Services\Validators\ResourceCollectionValidator;
use Prescreen\ApiResourceBundle\Application\Services\Validators\StringValidator;
use Prescreen\ApiResourceBundle\Entity\ExampleEntity;
use Prescreen\ApiResourceBundle\Entity\ExampleTranslationEntity;
use Prescreen\ApiResourceBundle\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;
use PHPUnit\Framework\TestCase;

#[CoversClass(ExampleResourceTransformer::class)]
#[UsesClass(BoolField::class)]
#[UsesClass(ResourceCollectionField::class)]
#[UsesClass(ResourceField::class)]
#[UsesClass(StringField::class)]
#[UsesClass(CoolPermissionValidator::class)]
#[UsesClass(ExampleEntity::class)]
#[UsesClass(ExampleTranslationEntity::class)]
#[UsesClass(ExampleResource::class)]
#[UsesClass(ApiValidatorException::class)]
class ExampleResourceTransformerTest extends TestCase
{
    protected ApiValidatorRegistry $apiValidatorRegistry;
    protected object $resource;
    private ExampleResourceTransformer $testService;

    public function setUp(): void
    {
        $this->apiValidatorRegistry = $this->createMock(ApiValidatorRegistry::class);
        $this->testService = new ExampleResourceTransformer($this->apiValidatorRegistry);
    }

    public function testItThrowsExceptionIfGivenWrongEntityClass()
    {
        $this->expectException(WrongObjectTypeGivenException::class);

        $this->testService->fromEntity(new \stdClass());
    }

    public function testItCreatesNewResourceAndSetsFieldsOnFromEntityMethod(): void
    {
        $resource = $this->testService->fromEntity(
            (new ExampleEntity())
                ->setId(1)
                ->setName('Cool example entity')
                ->setIsCool(true)
        );

        $this->assertInstanceOf(ExampleResource::class, $resource);
        $this->assertSame(1, $resource->id);
        $this->assertSame('Cool example entity', $resource->name);
        $this->assertTrue($resource->is_cool);
        $this->assertEmpty($resource->translations);
    }

    public function testItThrowsExceptionIfRequiredFieldIsMissingInInputArray(): void
    {
        $this->expectException(RequiredFieldMissingException::class);

        $this->testService->fromArray([
            'id' => 1,
            'is_cool' => false
        ], new ExampleEntity());
    }

    public function testItThrowsExceptionIfPermissionIsMissingForField(): void
    {
        $this->expectException(PermissionDeniedException::class);

        $exampleEntity = new ExampleEntity();
        $exampleEntity->setIsCool(true);

        $boolValidator = $this->createValidator(BoolValidator::class, false);
        $boolValidator->method('validate')->willThrowException($this->createMock(PermissionDeniedException::class));

        $this->apiValidatorRegistry->expects($this->once())
            ->method('get')->willReturn($boolValidator);

        $this->testService->setUserIsCool(false);

        $this->testService->fromArray([
            'id' => 1,
            'is_cool' => false,
            'name' => 'Great entity'
        ], new ExampleEntity());
    }

    public function testItSetsFieldsInEntityIfGivenArrayValidates(): void
    {
        $exampleEntity = new ExampleEntity();

        $this->apiValidatorRegistry->expects($this->exactly(2))->method('get')
            ->willReturnOnConsecutiveCalls(
                $this->createValidator(StringValidator::class, 'Cool example entity'),
                $this->createValidator(BoolValidator::class, false),
            );

        $this->testService->fromArray([
            'id' => 1,
            'name' => 'Cool example entity',
            'is_cool' => false
        ], $exampleEntity);

        $this->assertNull($exampleEntity->getId()); // Should not be filled from array because the field is not writable.
        $this->assertSame('Cool example entity', $exampleEntity->getName());
        $this->assertFalse($exampleEntity->isCool());
    }

    public function testItUpdatesCollectionInEntityIfResourceCollectionFieldGiven(): void
    {
        $exampleEntity = new ExampleEntity();
        $oldTranslation = (new ExampleTranslationEntity())->setId(1);
        $exampleEntity->setTranslations(new ArrayCollection([$oldTranslation]));

        $newTranslation = (new ExampleTranslationEntity())->setId(2);

        $this->apiValidatorRegistry->expects($this->exactly(3))->method('get')
            ->willReturnOnConsecutiveCalls(
                $this->createValidator(StringValidator::class, 'Cool example entity'),
                $this->createValidator(BoolValidator::class, false),
                $this->createValidator(ResourceCollectionValidator::class, new ArrayCollection([$newTranslation])),
            );

        $this->testService->fromArray([
            'id' => 1,
            'name' => 'Cool example entity',
            'is_cool' => false,
            'translations' => [
                ['id' => null, 'locale' => 'en', 'name' => 'Cool example translation']
            ]
        ], $exampleEntity);

        $this->assertNull($exampleEntity->getId()); // Should not be filled from array because the field is not writable.
        $this->assertSame('Cool example entity', $exampleEntity->getName());
        $this->assertFalse($exampleEntity->isCool());
        $this->assertFalse($exampleEntity->getTranslations()->contains($oldTranslation));
        $this->assertTrue($exampleEntity->getTranslations()->contains($newTranslation));
    }

    public function testItUsesEntitySetterIfCollectionDoesNotExistYet(): void
    {
        $exampleEntity = new ExampleEntity();

        $newTranslation = (new ExampleTranslationEntity())->setId(1);

        $this->apiValidatorRegistry->expects($this->exactly(3))->method('get')
            ->willReturnOnConsecutiveCalls(
                $this->createValidator(StringValidator::class, 'Cool example entity'),
                $this->createValidator(BoolValidator::class, false),
                $this->createValidator(ResourceCollectionValidator::class, new ArrayCollection([$newTranslation])),
            );

        $this->testService->fromArray([
            'id' => 1,
            'name' => 'Cool example entity',
            'is_cool' => false,
            'translations' => [
                ['id' => null, 'locale' => 'en', 'name' => 'Cool example translation']
            ]
        ], $exampleEntity);

        $this->assertNull($exampleEntity->getId()); // Should not be filled from array because the field is not writable.
        $this->assertSame('Cool example entity', $exampleEntity->getName());
        $this->assertFalse($exampleEntity->isCool());
        $this->assertTrue($exampleEntity->getTranslations()->contains($newTranslation));
    }

    public function testItCreatesResourceForAllGivenEntitiesOnFromIterable(): void
    {
        $resources = $this->testService->fromIterable([
            (new ExampleEntity())
                ->setId(1)
                ->setName('Cool example entity')
                ->setIsCool(true),
            (new ExampleEntity())
                ->setId(2)
                ->setName('Not so cool example entity')
                ->setIsCool(false),
        ]);

        foreach ($resources as $resource) {
            $this->assertInstanceOf(ExampleResource::class, $resource);
        }

        $this->assertSame(1, $resources[0]->id);
        $this->assertSame('Cool example entity', $resources[0]->name);
        $this->assertTrue($resources[0]->is_cool);

        $this->assertSame(2, $resources[1]->id);
        $this->assertSame('Not so cool example entity', $resources[1]->name);
        $this->assertFalse($resources[1]->is_cool);
    }

    private function createValidator(string $validatorClass, mixed $returnValue): ApiValidator&MockObject
    {
        /** @var ApiValidator&MockObject $validator */
        $validator = $this->createMock($validatorClass);
        $validator->method('validate')->willReturn($returnValue);

        return $validator;
    }
}
