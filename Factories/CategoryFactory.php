<?php

namespace Multidoc\Factories;
use Multidoc\DTO\CategoryDto;
use Multidoc\DTO\RouteDto;

class CategoryFactory
{
    const CATEGORY_PLURAL_KEY = 'categories';

    /**
     * @param string $id
     * @param $categoryArray
     * @return CategoryDto
     */
    private function buildCategoryFromArray($id, $categoryArray)
    {
        $categoryData = [
            'id'=>$id,
            'name'=>$categoryArray['name']
        ];
        if(isset($categoryArray[self::CATEGORY_PLURAL_KEY])){
            $categoryData['categoryList'] = $this->buildCategoryListFromArray($categoryArray[self::CATEGORY_PLURAL_KEY]);
        }
        return new CategoryDto($categoryData);
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
     * @param CategoryDto[] $categoryList
     * @param RouteDto[] $routeList
     */
    public function assignRoutesToCategoryList($categoryList, $routeList)
    {
        foreach ($routeList as $route) {
            $route->category = $this->assignRouteCategory($categoryList, $route);
        }
    }

    /**
     * @param CategoryDto[] $categoryList
     * @param RouteDto $route
     * @return CategoryDto|null
     */
    public function assignRouteCategory($categoryList, $route)
    {
        foreach($categoryList as $category) {
            if ($category->id == $route->categoryId){
                $category->addRoute($route);
                return $category;
            }
            if($category->categories) {
                $this->assignRouteCategory($category->categories, $route);
            }
        }
        return null;
    }

}