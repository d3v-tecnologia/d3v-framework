<?php

namespace D3V\Core;

use D3V\Exceptions\NotFoundException;
use DI\ContainerBuilder;
use DI\Container;
use PDO;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class App
{
    private Config $config;
    public Container $container;
    private DBManager $dbManager;
    private array $routes = [];

    public function __construct()
    {
        $this->config = new Config();
    }

    public function bootstrap()
    {
        $this->setupDBManager();
        $this->registerRoutes();
        $this->registerContainer();
    }

    private function registerContainer()
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAnnotations(true);
        $containerBuilder->addDefinitions([
            App::class => function () {
                return $this;
            },
            Config::class => function () {
                return $this->config;
            },
            Environment::class => function () {
                return $this->setupTwigEnvironment();
            },
            DBManager::class => function () {
                return $this->dbManager;
            },
            PDO::class => function () {
                return $this->dbManager->get($this->config->need('default_db_connection'));
            },
        ]);
        $this->container = $containerBuilder->build();
    }

    private function setupTwigEnvironment()
    {
        $loader = new FilesystemLoader();
        $loader->addPath(__DIR__ .  '/../Views', 'd3v');

        foreach (scandir(__DIR__ . '/../../progs') as $program) {
            $path = __DIR__ . "/../../progs/$program/Views";
            if (is_dir($path)) {
                $loader->addPath($path, $program);
            }
        }

        return new Environment($loader, $this->config->need('twig'));
    }

    private function registerRoutes()
    {
        foreach (scandir(__DIR__ . '/../../progs') as $program) {
            $path = __DIR__ . "/../../progs/$program/routes.php";
            if (file_exists($path)) {
                $this->routes = array_merge($this->routes, require($path));
            }
        }
    }

    private function setupDBManager()
    {
        $this->dbManager = new DBManager($this->config->get('pdo', []));
        if ($this->config->check('default_db_connection')) {
            $this->dbManager->connect($this->config->get('default_db_connection'));
        }
    }

    public function dispatch()
    {
        $path = $_SERVER['PATH_INFO'] ?? "";
        $callable = $this->callableFromPath($path);

        if (empty($callable)) {
            throw new NotFoundException();
        }

        list($class, $method) = explode("::", $callable);

        if (!is_subclass_of($class, '\D3V\Core\CoreController') || !method_exists($class, $method)) {
            throw new NotFoundException();
        }
        $this->container->call($callable);
    }

    private function callableFromPath($path)
    {
        return !empty($path) ? $this->routes[$path] ?? "" : $this->config->get("homepage");
    }
}
