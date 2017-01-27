<?php

require __DIR__.'/vendor/autoload.php';
const APP_NAME = 'Multidoc';


spl_autoload_register(
    function ($class_name) {
        $class_name = str_replace(APP_NAME."\\","",$class_name);
        include $class_name . '.php';
    }
);


use Multidoc\Factories\EnvironmentFactory;
use Multidoc\Factories\ProjectFactory;

use Multidoc\Services\ParserService;
use Multidoc\Services\FileService;
use Symfony\Component\Console\Application;
use Symfony\Component\Finder\Finder;

$application = new Application();
$application->add(new Multidoc\Console\ParserCommand(
    new FileService(new Finder()),
    new ParserService(
        new \Multidoc\Factories\AbstractFactory(
            new ProjectFactory(new EnvironmentFactory()),
            new \Multidoc\Factories\RouteFactory(
                new \Multidoc\Factories\ParameterFactory(),
                new \Multidoc\Factories\TagFactory()
            ),
            new \Multidoc\Factories\CategoryFactory()
        )
    ), new \Multidoc\Services\OutputService(
        new \Symfony\Component\Filesystem\Filesystem(),
        new \Multidoc\Renderers\ProjectRenderer(new \Multidoc\Renderers\EnvironmentRenderer()),
        new \Multidoc\Renderers\CategoryRenderer(
            new \Multidoc\Renderers\RouteRenderer(
                new \Multidoc\Renderers\ParameterRenderer(),
                new \Multidoc\Renderers\TagRenderer()
            )
        )
    )
));
$application->run();