<?php

namespace Multidoc\Factories;
use Multidoc\Models\Category;
use Multidoc\Models\Route;

class CategoryFactory
{
    private static $lastId = 1;

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
        $category->setExternalId(self::$lastId);
        self::$lastId = self::$lastId+1;
        if(isset($categoryArray[self::CATEGORY_PLURAL_KEY])){
            $category->setCategoryList($this->buildCategoryListFromArray($categoryArray[self::CATEGORY_PLURAL_KEY]));
        }
        return $category;
    }

    public function buildCategoryListFromArray($categoryListArray)
    {
        $categoryList = array();
        foreach ($categoryListArray as $id => $categoryArray){
            $categoryList[]=$this->buildCategoryFromArray($id, $categoryArray);
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
            $route->setCategory($this->assignRouteCategory($categoryList,$route));
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
                return $this->assignRouteCategory($category->getCategoryList(), $route);
            }
        }
        return null;
    }

}