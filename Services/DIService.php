<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 22-May-17
 * Time: 9:18 AM
 */

namespace Multidoc\Services;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;


class DIService
{

    /**
     * @var ContainerBuilder
     */
    static $service;

    private function __construct()
    {

    }

    public static function load()
    {
        if(is_null(DIService::$service)){
            DIService::$service = new ContainerBuilder();
            $loader = new YamlFileLoader(DIService::$service, new FileLocator(__DIR__."/../config/"));
            $loader->load('dependencies.yml');
        }
        return DIService::$service;
    }

    public function get($serviceName){
        return DIService::$service->get($serviceName);
    }
}