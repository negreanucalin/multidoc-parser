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
        foreach ($categoryList as $category) {
            $list['children'][] = $this->renderEntity($category);
        }
        return $list;
    }

    /**
     * @param Category $category
     * @return array
     */
    public function renderEntity(Category $category)
    {
        $children = [];
        $data = array(
            'id' => $category->getId(),
            'name' => $category->getName()
        );
        if ($category->getCategoryList()) {
            $renderedList = $this->renderList($category->getCategoryList());
            $children = array_pop($renderedList);
        }
        if ($category->getRouteList()) {
            $children = array_merge($children,$this->routeRenderer->renderList($category->getRouteList()));
        }

        $data['children'] = $children;
        return $data;
    }
}