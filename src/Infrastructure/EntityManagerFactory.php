<?php

namespace Infrastructure;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

class EntityManagerFactory
{
    /**
     * @throws ORMException
     */
    public function __invoke(ContainerInterface $container): EntityManager
    {
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;

        $config = Setup::createAnnotationMetadataConfiguration(
            ['src/App/Entity'],
            $isDevMode,
            $proxyDir,
            $cache,
            $useSimpleAnnotationReader
        );

        $conn = $container->get('config')['sqlite'];
        return EntityManager::create($conn, $config);
    }
}
