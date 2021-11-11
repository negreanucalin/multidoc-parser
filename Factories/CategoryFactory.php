<?php

namespace Multidoc\Factories;
use Multidoc\Models\Category;
use Multidoc\Models\Route;

class CategoryFactory
{
    const CATEGORY_PLURAL_KEY = 'categories';

    public function __construct()
    {

    }

    /**
     * @param string $id
     * @param $categoryArray
     * @return Category
     */
    public function buildCategoryFromArray($id, $categoryArray)
    {
        $category = new Category($id);
        $category->setName($categoryArray['name']);
        if(isset($categoryArray[self::CATEGORY_PLURAL_KEY])){
            $category->setCategoryList($this->buildCategoryListFromArray($categoryArray[self::CATEGORY_PLURAL_KEY]));
        }
        return $category;
    }

    public function buildCategoryListFromArray($categoryMap)
    {
        $categoryList = array();
        foreach ($categoryMap as $categoryId => $categoryArray){
            $categoryList[]=$this->buildCategoryFromArray($categoryId, $categoryArray);
        }
        return $categoryList;
    }

    /**
     * @param Category[] $categoryList
     * @param Route[] $routeList
     */
    public function assignRoutesToCategoryList($categoryList, $routeList)
    {
        foreach($routeList as $route) {
            $route->setCategory($this->assignRouteCategory($categoryList, $route));
        }
    }

    /**
     * @param Category[] $categoryList
     * @param Route $route
     * @return Category|null
     */
    public function assignRouteCategory($categoryList, $route)
    {
        foreach($categoryList as $category) {
            if($category->getId() == $route->getCategoryId()){
                $category->addRoute($route);
                return $category;
            }
            if($category->getCategoryList()) {
                $this->assignRouteCategory($category->getCategoryList(), $route);
            }
        }
        return null;
    }

}