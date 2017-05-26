<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 1/27/2017
 * Time: 10:42 AM
 */

namespace Multidoc\Renderers;


use Multidoc\Models\Route;

class RouteRenderer
{
    /**
     * @var TagRenderer
     */
    private $tagRenderer;

    /**
     * @var StatusRenderer
     */
    private $statusRenderer;

    /**
     * @var ResponseRenderer
     */
    private $responseRenderer;

    /**
     * @var RequestRenderer
     */
    private $requestRenderer;

    public function __construct(
        RequestRenderer $requestRenderer,
        ResponseRenderer $responseRenderer,
        StatusRenderer $statusRenderer,
        TagRenderer $tagRenderer
    ) {
        $this->requestRenderer = $requestRenderer;
        $this->tagRenderer = $tagRenderer;
        $this->statusRenderer = $statusRenderer;
        $this->responseRenderer = $responseRenderer;
    }

    /**
     * @param Route[] $routeList
     * @return array
     */
    public function renderList($routeList)
    {
        $list = array();
        foreach($routeList as $route){
            $list[]=$this->renderEntity($route);
        }
        return $list;
    }

    /**
     * @param Route $route
     * @return array
     */
    public function renderEntity(Route $route)
    {
        $data = array(
            'id'=>$route->getId(),
            'name'=>$route->getName(),
            'description'=>$route->getDescription()
        );
        if($route->getStatusList()){
            $data['statusCodes'] = $this->statusRenderer->renderList($route->getStatusList());
        }
        if($route->getResponse()){
            $data['response'] = $this->responseRenderer->renderEntity($route->getResponse());
        }
        if($route->getRequest()){
            $data['request'] = $this->requestRenderer->renderEntity($route->getRequest());
        }
        if($route->getTagList()){
            $data['tags'] = $this->tagRenderer->renderList($route->getTagList());
        }
        return $data;
    }
}