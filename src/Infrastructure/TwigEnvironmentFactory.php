<?php

namespace Infrastructure;

use Framework\Template\Extension\RouteExtension;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class TwigEnvironmentFactory
{
    public function __invoke(ContainerInterface $container): Environment
    {
        $loader = new FilesystemLoader();
        $loader->addPath(ROOT . 'templates/layout');

        $debug = $container->get('config')['debug'];

        $environment = new Environment($loader, [
            'debug' => $debug,
            'cache' => $debug ? false : ROOT . 'var/cache/twig'
        ]);

        if ($debug) {
            $environment->addExtension(new DebugExtension());
        }
        $environment->addExtension($container->get(RouteExtension::class));
        return $environment;
    }
}
