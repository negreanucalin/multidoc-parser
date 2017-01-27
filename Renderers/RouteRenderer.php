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
     * @var ParameterRenderer
     */
    private $paramRenderer;

    /**
     * @var TagRenderer
     */
    private $tagRenderer;

    public function __construct(ParameterRenderer $paramRenderer, TagRenderer $tagRenderer)
    {
        $this->paramRenderer = $paramRenderer;
        $this->tagRenderer = $tagRenderer;
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
            'description'=>$route->getDescription(),
            'url'=>$route->getUrl(),
            'method'=>$route->getMethod(),
            'tags'=>$this->tagRenderer->renderList($route->getTagList())
        );
        if($route->getParameterList()){
            $data['params'] = $this->paramRenderer->renderList($route->getParameterList());
        }
        return $data;
    }
}