<?php

use App\Http\Middleware\AuthMiddleware;
use Aura\Router\RouterContainer;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Application;
use Framework\Http\Pipelines\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Framework\Template\TemplateRenderer;
use Framework\Template\TwigRenderer;
use Infrastructure\EntityManagerFactory;
use Infrastructure\PDOFactory;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Laminas\ServiceManager\ServiceManager;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;

$container = new ServiceManager([
	'abstract_factories' => [
		ReflectionBasedAbstractFactory::class
	],
	'factories' => [
		AuthMiddleware::class => function (ContainerInterface $container) {
			return new AuthMiddleware($container->get('config')['users']);
		},
		MiddlewareResolver::class => function (ContainerInterface $container) {
			return new MiddlewareResolver($container);
		},
		Router::class => function () {
			return new AuraRouterAdapter(new RouterContainer());
		},
		Application::class => function (ContainerInterface $container) {
			return new Application($container->get(MiddlewareResolver::class));
		},
		TemplateRenderer::class => function (ContainerInterface $container) {
			return new TwigRenderer($container->get(Environment::class), '.html.twig');
		},
		Environment::class => function (ContainerInterface $container) {
			$loader = new Twig\Loader\FilesystemLoader();
			$loader->addPath(__DIR__ . '/../templates/layout');
			
			$debug = $container->get('config')['debug'];
			
			$environment = new Environment($loader, [
				'debug' => $debug,
				'cache' => $debug ? false : __DIR__ . '/../var/cache/twig'
			]);
			
			if ($debug) {
				$environment->addExtension(new DebugExtension());
			}
			
			return $environment;
		},
		PDO::class => PDOFactory::class,
		EntityManagerInterface::class => EntityManagerFactory::class,
	]
]);

$config = require __DIR__ . '/config.php';
$container->setService('config', $config);

return $container;