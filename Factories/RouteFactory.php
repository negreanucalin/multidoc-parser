<?php

namespace Multidoc\Factories;
use Multidoc\Models\Route;

class RouteFactory
{

    const ROUTE_METHOD_POST = 'POST';

    const ROUTE_SINGULAR_KEY = 'route';

    const ROUTE_PLURAL_KEY = 'route_list';

    private static $lastId = 1;

    /**
     * @var StatusFactory
     */
    private $statusFactory;

    /**
     * @var TagFactory
     */
    private $tagFactory;

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var RequestFactory
     */
    private $requestFactory;

    public function __construct(
        RequestFactory $requestFactory,
        ResponseFactory $responseFactory,
        StatusFactory $statusFactory,
        TagFactory $tagFactory
    ) {
        $this->requestFactory = $requestFactory;

        $this->tagFactory = $tagFactory;
        $this->statusFactory = $statusFactory;
        $this->responseFactory = $responseFactory;
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
        $route->setCategoryId($routeArray['category']);
        if(array_key_exists(TagFactory::TAGS_KEY, $routeArray)) {
            $route->setTagList($this->tagFactory->buildTagListFromArray($routeArray[TagFactory::TAGS_KEY]));
        }
        if(array_key_exists(StatusFactory::STATUS_PLURAL_LIST, $routeArray)){
            $route->setStatusList(
                $this->statusFactory->buildStatusList(
                    $routeArray[StatusFactory::STATUS_PLURAL_LIST]
                )
            );
        }
        if(array_key_exists('response', $routeArray)){
            $route->setResponse($this->responseFactory->buildEntity($routeArray['response']));
        }
        if(array_key_exists('request', $routeArray)){
            $route->setRequest($this->requestFactory->buildEntity($routeArray['request']));
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