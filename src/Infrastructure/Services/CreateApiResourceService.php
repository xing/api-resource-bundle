<?php

namespace Xing\ApiResourceBundle\Infrastructure\Services;

use Xing\ApiResourceBundle\Application\Services\Traits\CaseConverter;
use Xing\ApiResourceBundle\Infrastructure\ExtendedReflectionClass;

class CreateApiResourceService
{
    use CaseConverter;

    public function handle(string $entityClass): string
    {
        $reflector = new ExtendedReflectionClass($entityClass);

        [$resourceClassDir, $resourceClassFullPath] = $this->getResourceClassDirAndPath($reflector);

        if (file_exists($resourceClassFullPath)) {
            throw new \InvalidArgumentException('Resource class for this service already exists');
        }

        if (!is_dir($resourceClassDir)) {
            mkdir($resourceClassDir, 0777, true);
        }

        $resourceClassNamespace = $this->getResourceClassNamespace($reflector->getNamespaceName());
        $useStatements = $this->getUseStatements($reflector);
        $className = $reflector->getShortName() . 'Resource';

        $properties = $this->getProperties($reflector);
        $fromEntityMethodContent = $this->createFromEntityMethodContent($reflector);

        $resourceClassContent = <<<EOT
<?php
        
namespace $resourceClassNamespace;
        
use Xing\ApiResourceBundle\Application\Interfaces\ApiResource;
$useStatements
        
class $className implements ApiResource
{
    $properties
    public static function fromEntity(object \$entity): ApiResource
    {
        $fromEntityMethodContent
        return \$resource;
    }
}
EOT;

        file_put_contents($resourceClassFullPath, $resourceClassContent);

        return $resourceClassNamespace . '\\' . $className;
    }

    private function getResourceClassDirAndPath(ExtendedReflectionClass $reflector): array
    {
        $resourceClassDir = 'src/' . str_replace('\\', '/', $this->getResourceClassNamespace($reflector->getNamespaceName()));

        return [
            $resourceClassDir,
            $resourceClassDir . '/' . $reflector->getShortName() . 'Resource.php'
        ];
    }

    private function getResourceClassNamespace(string $entityNamespace): string
    {
        $resourceClassNamespaceArray = [];

        $entityNamespaceArray = explode('\\', $entityNamespace);

        foreach ($entityNamespaceArray as $part) {
            if (strpos($part, 'Entity') !== false) {
                break;
            }

            $resourceClassNamespaceArray[] = $part;
        }

        $resourceClassNamespaceArray[] = 'Application';
        $resourceClassNamespaceArray[] = 'ApiResources';

        return implode('\\', $resourceClassNamespaceArray);
    }

    private function getUseStatements(ExtendedReflectionClass $reflector): string
    {
        $useStatements = '';
        $serviceClass = $reflector->getName();

        $useStatements .= "use $serviceClass;";

        return $useStatements;
    }

    /**
     * @param \ReflectionClass $reflector
     *
     * @return string
     */
    private function getProperties(\ReflectionClass $reflector): string
    {
        $propertiesString = '';

        foreach ($reflector->getProperties() as $property) {
            $propertyName = $property->getName();
            $snakeCasePropertyName = $this->toSnakeCase($propertyName);

            $propertiesString .= "public $$snakeCasePropertyName;\n\t";
        }

        return $propertiesString;
    }

    /**
     * @param \ReflectionClass $reflector
     *
     * @return string
     */
    private function createFromEntityMethodContent(\ReflectionClass $reflector): string
    {
        $methodContent = '';
        $entityClassName = $reflector->getShortName();

        $methodContent .= "/** @var $entityClassName \$entity */\n\t\t";
        $methodContent .= "\$resource = new self();\n\t\t\n\t\t";

        foreach ($reflector->getProperties() as $property) {
            $propertyName = $property->getName();

            $snakeCasePropertyName = $this->toSnakeCase($propertyName);
            $getter = 'get' . ucfirst($propertyName);

            $methodContent .= "\$resource->$snakeCasePropertyName = \$entity->$getter();\n\t\t";
        }

        return $methodContent;
    }
}
