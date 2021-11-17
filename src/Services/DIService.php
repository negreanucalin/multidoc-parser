<?php
namespace Multidoc\Services;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class DIService
{
    /**
     * @return ContainerBuilder
     * @throws Exception
     */
    public function load()
    {
        $service = new ContainerBuilder();
        $loader = new YamlFileLoader($service, new FileLocator(__DIR__ . "/../config/"));
        $loader->load('dependencies.yml');
        return $service;
    }
}