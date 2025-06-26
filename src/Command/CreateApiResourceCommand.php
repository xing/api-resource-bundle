<?php

namespace Xing\ApiResourceBundle\Command;

use Xing\ApiResourceBundle\Application\Services\Traits\CaseConverter;
use Xing\ApiResourceBundle\Infrastructure\Services\CreateApiResourceService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateApiResourceCommand extends Command
{
    use CaseConverter;

    public function __construct(
        private readonly CreateApiResourceService $createApiResourceService
    ) {
        parent::__construct();
    }

    protected function configure(): void
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
        $contents = file_get_contents($path_to_file);

        $namespace = $class = '';

        $gettingNamespace = $gettingClass = false;

        foreach (token_get_all($contents) as $token) {
            $gettingNamespace = $this->isGettingNamespace($token, $gettingNamespace);
            $gettingClass = $this->isGettingClass($token, $gettingClass);

            if ($gettingNamespace === true) {
                if (is_array($token) && in_array($token[0], [T_STRING, T_NS_SEPARATOR])) {
                    $namespace .= $token[1];
                } elseif ($token === ';') {
                    $gettingNamespace = false;
                }
            }

            if ($gettingClass === true && is_array($token) && $token[0] == T_STRING) {
                $class = $token[1];

                break;
            }
        }

        return $namespace ? $namespace . '\\' . $class : $class;
    }

    private function isGettingNamespace($token, bool $gettingNamespace): bool
    {
        if (is_array($token) && $token[0] == T_NAMESPACE) {
            $gettingNamespace = true;
        }

        return $gettingNamespace;
    }

    private function isGettingClass($token, bool $gettingClass): bool
    {
        if (is_array($token) && $token[0] == T_CLASS) {
            $gettingClass = true;
        }

        return $gettingClass;
    }
}
