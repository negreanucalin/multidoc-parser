<?php

namespace MultidocParser\Normalizers;
use MultidocParser\DTO\CategoryDto;
use MultidocParser\DTO\ProjectDto;
use MultidocParser\DTO\RouteDto;

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