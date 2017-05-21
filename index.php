<?php

require __DIR__.'/vendor/autoload.php';
const APP_NAME = 'Multidoc';

use Multidoc\Factories\EnvironmentFactory;
use Multidoc\Factories\ProjectFactory;

use Multidoc\Services\FileContentParserService;
use Multidoc\Services\InputFileService;
use Multidoc\Services\MultidocService;
use Symfony\Component\Console\Application;
use Symfony\Component\Finder\Finder;

$application = new Application();
$application->add(new Multidoc\Console\ParserCommand(
    new MultidocService(
        new InputFileService(new Finder()),
        new FileContentParserService(
            new \Multidoc\Factories\AbstractFactory(
                new ProjectFactory(new EnvironmentFactory()),
                new \Multidoc\Factories\RouteFactory(
                    new \Multidoc\Factories\ParameterFactory(),
                    new \Multidoc\Factories\TagFactory()
                ),
                new \Multidoc\Factories\CategoryFactory()
            )
        ), new \Multidoc\Services\OutputFileService(
            new \Symfony\Component\Filesystem\Filesystem(),
            new \Multidoc\Renderers\ProjectRenderer(new \Multidoc\Renderers\EnvironmentRenderer()),
            new \Multidoc\Renderers\CategoryRenderer(
                new \Multidoc\Renderers\RouteRenderer(
                    new \Multidoc\Renderers\ParameterRenderer(),
                    new \Multidoc\Renderers\TagRenderer()
                )
            )
        )
    )
));
$application->run();