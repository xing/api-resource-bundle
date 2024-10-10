<?php

namespace Prescreen\ApiResourceBundle\Command;

use Prescreen\ApiResourceBundle\Application\Services\Traits\CaseConverter;
use Prescreen\ApiResourceBundle\Infrastructure\Services\CreateApiResourceService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateApiResourceCommand extends Command
{
    use CaseConverter;

    /**
     * @var CreateApiResourceService
     */
    private $createApiResourceService;

    public function __construct(
        CreateApiResourceService $createApiResourceService
    ) {
        parent::__construct();
        $this->createApiResourceService = $createApiResourceService;
    }

    protected function configure()
    {
        parent::configure();

        $this
            ->setName('api_resource:create')
            ->setDescription('Generate an api resource for a given entity.')
            ->addArgument('entity-class');
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $entityClassFile = $input->getArgument('entity-class');
        $entityClass = $this->getClassFromFile($entityClassFile);

        if (!$entityClass || !class_exists($entityClass)) {
            throw new \InvalidArgumentException('Entity class does not exist');
        }

        $resourceClass = $this->createApiResourceService->handle($entityClass);

        $output->writeln('<info>Created resource:</info> ' . $resourceClass);

        $output->writeln('---');
        $output->writeln('What\'s left to do?');
        $output->writeln('> Check the fields in the resource and remove those that are not needed (all fields from the entity were added)');
        $output->writeln('> Create a resource transformer if needed');
        $output->writeln('> Create an API controller and start using your new resource!');
        $output->writeln('> <info>Happy coding!</info>');

        return Command::SUCCESS;
    }

    private function getClassFromFile($path_to_file)
    {
        //Grab the contents of the file
        $contents = file_get_contents($path_to_file);

        //Start with a blank namespace and class
        $namespace = $class = '';

        //Set helper values to know that we have found the namespace/class token and need to collect the string values after them
        $getting_namespace = $getting_class = false;

        //Go through each token and evaluate it as necessary
        foreach (token_get_all($contents) as $token) {
            $getting_namespace = $this->isGettingNamespace($token, $getting_namespace);
            $getting_class = $this->isGettingClass($token, $getting_class);

            //While we're grabbing the namespace name...
            if ($getting_namespace === true) {

                //If the token is a string or the namespace separator...
                if (is_array($token) && in_array($token[0], [T_STRING, T_NS_SEPARATOR])) {

                    //Append the token's value to the name of the namespace
                    $namespace .= $token[1];
                } elseif ($token === ';') {

                    //If the token is the semicolon, then we're done with the namespace declaration
                    $getting_namespace = false;
                }
            }

            //While we're grabbing the class name...
            if ($getting_class === true && is_array($token) && $token[0] == T_STRING) {
                //Store the token's value as the class name
                $class = $token[1];

                //Got what we need, stope here
                break;
            }
        }

        //Build the fully-qualified class name and return it
        return $namespace ? $namespace . '\\' . $class : $class;
    }

    /**
     * @param $token
     * @param bool $getting_namespace
     *
     * @return bool
     */
    private function isGettingNamespace($token, bool $getting_namespace): bool
    {
        //If this token is the namespace declaring, then flag that the next tokens will be the namespace name
        if (is_array($token) && $token[0] == T_NAMESPACE) {
            $getting_namespace = true;
        }
        return $getting_namespace;
    }

    /**
     * @param $token
     * @param bool $getting_class
     *
     * @return bool
     */
    private function isGettingClass($token, bool $getting_class): bool
    {
        //If this token is the class declaring, then flag that the next tokens will be the class name
        if (is_array($token) && $token[0] == T_CLASS) {
            $getting_class = true;
        }
        return $getting_class;
    }
}
