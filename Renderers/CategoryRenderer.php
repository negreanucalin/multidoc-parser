<?php
/**
 * Created by PhpStorm.
 * User: canegreanu
 * Date: 1/27/2017
 * Time: 9:40 AM
 */

namespace Multidoc\Renderers;


use Multidoc\Models\Category;

class CategoryRenderer
{

    /**
     * @var RouteRenderer
     */
    private $routeRenderer;

    public function __construct(RouteRenderer $routeRenderer)
    {
        $this->routeRenderer = $routeRenderer;
    }

    /**
     * @param Category[] $categoryList
     * @return array
     */
    public function renderList($categoryList)
    {
        $list = array();
        foreach($categoryList as $category){
            $list['categoryList'][]=$this->renderEntity($category);
        }
        return $list;
    }

    /**
     * @param Category $category
     * @return array
     */
    public function renderEntity(Category $category)
    {
        $data = array(
            'id'=>$category->getExternalId(),
            'name'=>$category->getName()
        );
        if($category->getRouteList()){
            $data['routes'] = $this->routeRenderer->renderList($category->getRouteList());
        }
        if($category->getCategoryList()){
            $data['categoryList'] = array_pop($this->renderList($category->getCategoryList()));
        }
        return $data;
    }
}