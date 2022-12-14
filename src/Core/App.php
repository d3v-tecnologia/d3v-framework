<?php

namespace D3V\Core;

use D3V\Exceptions\NotFoundException;
use DI\ContainerBuilder;
use DI\Container;
use PDO;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemTagAwareAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;
use Twig\Extra\String\StringExtension;

class App
{
    private Config $config;
    public Container $container;
    private DBManager $dbManager;
    private array $routes = [];
    private TagAwareCacheInterface $cache;

    public function __construct()
    {
        $this->config = new Config();
    }

    public function bootstrap()
    {
        $this->setupDBManager();
        $this->setupCache();
        $this->registerRoutes();
        $this->registerContainer();
        $this->setupTranslations();
    }

    private function setupCache()
    {
        $cfg = $this->config->get("cache", ['adapter' => 'array']);

        switch ($cfg['adapter']) {
            case 'array':
                $this->cache = $this->setupArrayCacheAdapter($cfg);
                break;
            case 'file':
                $this->cache = $this->setupFilesystemCacheAdapter($cfg);
                break;
        }
    }

    private function setupArrayCacheAdapter(array $cfg): TagAwareCacheInterface
    {
        return new TagAwareAdapter(new ArrayAdapter(
            $cfg['default_lifetime'] ?? 0,
            $cfg['store_serialized'] ?? true,
            $cfg['max_lifetime'] ?? 0,
            $cfg['max_itens'] ?? 0
        ));
    }

    private function setupFilesystemCacheAdapter(array $cfg): TagAwareCacheInterface
    {
        return new FilesystemTagAwareAdapter(
            $cfg['namespace'] ?? '',
            $cfg['default_lifetime'] ?? 0,
            $cfg['directory'] ?? __DIR__ . '/../../cache'
        );
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
            CacheInterface::class => function () {
                return $this->cache;
            }
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

        $twigEnv = new Environment($loader, $this->config->need('twig'));
        $twigEnv->addExtension(new StringExtension());
        $twigEnv->addFunction(new TwigFunction('__', function ($term, $namespace = "common") {
            return T::t($term, $namespace);
        }));
        $twigEnv->addFunction(new TwigFunction('n__', function ($singular, $plural, $n, $namespace = "common") {
            return T::p($singular, $plural, $n, $namespace);
        }));
        $twigEnv->addFunction(new TwigFunction('js', function ($name) {
            return $this->cache->get("assets.js.$name", function (ItemInterface $item) use ($name) {
                $item->tag('asset');
                foreach (scandir(__DIR__ . '/../../public/assets/js') as $js) {
                    if (strpos($js, "$name.") === 0) {
                        return "/assets/js/$js";
                    }
                }
                return "";
            });
        }));
        $twigEnv->addFunction(new TwigFunction('config', function () {
            return $this->config;
        }));

        return $twigEnv;
    }

    private function registerRoutes()
    {
        foreach (scandir(__DIR__ . '/../../progs') as $program) {
            $path = __DIR__ . "/../../progs/$program/definitions.php";
            if (file_exists($path)) {
                $defs = require($path);
                $this->routes = array_merge($this->routes, $defs['routes'] ?? []);
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

    private function setupTranslations()
    {
        $class = $this->config->get('i18n', [])['translation_manager_class'] ?? null;
        if ($class) {
            T::setupTranslationManager($this->container->get($class), $this->cache);
        }
    }

    public function run()
    {
        $path = $_SERVER['PATH_INFO'] ?? $this->config->get("homepage");
        $routes = array_filter($this->routes, function ($route) use ($path) {
            return $route->getPath() == $path;
        });
        if (empty($routes)) {
            throw new NotFoundException();
        }
        $route = array_pop($routes);
        echo $route->dispatch($this);
    }
}
