<?php

namespace Multidoc\Factories;
use Multidoc\Models\Route;

class RouteFactory
{

    const ROUTE_PLURAL_KEY = 'route_list';

    private static $lastId = 1;

    /**
     * @var ParameterFactory
     */
    private $parameterFactory;

    public function __construct(ParameterFactory $paramFactory, TagFactory $tagFactory)
    {
        $this->parameterFactory = $paramFactory;
        $this->tagFactory = $tagFactory;
    }

    /**
     * @param $routeArray
     * @return Route
     */
    public function buildRouteFromArray($routeArray)
    {
        $route = new Route(self::$lastId);
        $route->setName($routeArray['name']);
        $route->setDescription($routeArray['description']);
        $route->setMethod(strtoupper($routeArray['method']));
        $route->setUrl($routeArray['url']);
        $route->setCategoryId($routeArray['category']);
        $route->setTagList($this->tagFactory->buildTagListFromArray($routeArray['tags']));
        if(array_key_exists(ParameterFactory::PARAMETER_PLURAL_KEY, $routeArray)){
            $route->setParameterList(
                $this->parameterFactory->buildParameterListFromArray(
                    $routeArray[ParameterFactory::PARAMETER_PLURAL_KEY]
                )
            );
        }
        self::$lastId = self::$lastId+1;
        return $route;
    }

    public function buildRouteListFromArray($routeListArray)
    {
        $environmentList = array();
        foreach ($routeListArray as $routeArray){
            $environmentList[]=$this->buildRouteFromArray($routeArray);
        }
        return $environmentList;
    }

}