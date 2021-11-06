<?php

namespace Console\Command;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixtureCommand extends Command
{
    private EntityManagerInterface $em;
    private string $path;

    public function __construct(ContainerInterface $container, string $path)
    {
        parent::__construct();
        $this->em = $container->get(EntityManagerInterface::class);
        $this->path = $path;
    }

    protected function configure(): void
    {
        $this
            ->setName('fixtures:load')
            ->setDescription('Load fixtures');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<comment>Loading fixtures</comment>');

        $loader = new Loader();
        $loader->loadFromDirectory($this->path);

        $executor = new ORMExecutor($this->em, new ORMPurger());

        $executor->setLogger(function ($message) use ($output) {
            $output->writeln($message);
        });

        $executor->execute($loader->getFixtures());

        $output->writeln('<info>Done!</info>');
		return 0;
    }
}
