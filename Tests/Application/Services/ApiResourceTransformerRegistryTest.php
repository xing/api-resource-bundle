<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services;

use Prescreen\ApiResourceBundle\Application\ApiResources\ExampleResource;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\BoolField;
use Prescreen\ApiResourceBundle\Application\Services\ApiResourceTransformer;
use Prescreen\ApiResourceBundle\Application\Services\ApiResourceTransformerRegistry;
use PHPUnit\Framework\TestCase;

class ApiResourceTransformerRegistryTest extends TestCase
{
    /**
     * @var iterable
     */
    private $apiResourceTransformers;
    /**
     * @var ApiResourceTransformerRegistry
     */
    private $testService;

    public function setUp(): void
    {
        $this->apiResourceTransformers = [
            $this->createInternalApiResourceTransformer(ExampleResource::class)
        ];
        $this->testService = new ApiResourceTransformerRegistry($this->apiResourceTransformers);
    }

    /**
     * @test
     */
    public function givenResourceTransformerForGivenResourceClassHasNotBeenRegisteredThenThrowException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->testService->get(BoolField::class);
    }

    /**
     * @test
     */
    public function givenResourceClassThenReturnResourceTransformer()
    {
        $this->assertInstanceOf(ApiResourceTransformer::class, $this->testService->get(ExampleResource::class));
    }

    /**
     * @param string $resourceClass
     *
     * @return ApiResourceTransformer
     */
    private function createInternalApiResourceTransformer(string $resourceClass): ApiResourceTransformer
    {
        $resourceTransformer = $this->createMock(ApiResourceTransformer::class);
        $resourceTransformer->method('getResourceClass')->willReturn($resourceClass);

        return $resourceTransformer;
    }
}
