<?php

namespace Multidoc\Normalizers;
use Multidoc\DTO\CategoryDto;
use Multidoc\DTO\ProjectDto;
use Multidoc\DTO\RouteDto;

class CategoryNormalizer
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

    public function linkObjects(ProjectDto $project, $routeList): ProjectDto
    {
        $this->assignRoutesToCategoryList(
            $project->categories,
            $routeList
        );

        return $project;
    }
}