<?php

namespace Multidoc\Factories;
use Multidoc\DTO\CategoryDto;
use Multidoc\DTO\RouteDto;

class CategoryFactory
{
    /**
     * @param CategoryDto[] $categoryList
     * @param RouteDto[] $routeList
     */
    public function assignRoutesToCategoryList(array $categoryList, array $routeList)
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
    public function assignRouteCategory(array $categoryList, RouteDto $route): ?CategoryDto
    {
        foreach($categoryList as $category) {
            if ($category->id == $route->categoryId) {
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