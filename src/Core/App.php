<?php

namespace D3V\Core;

use DI\ContainerBuilder;
use DI\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class App
{
    public Config $config;
    public Container $container;

    public function __construct()
    {
        $this->config = new Config();
    }

    public function bootstrap()
    {
        $this->registerContainer();
    }

    private function registerContainer()
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAnnotations(true);
        $containerBuilder->addDefinitions([
            Config::class => function () {
                return $this->config;
            },
            Environment::class => function () {
                return $this->setupTwigEnvironment();
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

        return new Environment($loader, $this->config->need('twig'));
    }
}
