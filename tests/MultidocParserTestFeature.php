<?php

namespace MultidocParser\Tests;

use MultidocParser\DTO\CategoryDto;
use MultidocParser\DTO\ParameterDto;
use MultidocParser\DTO\ProjectDto;
use MultidocParser\DTO\RouteDto;
use MultidocParser\Exceptions\CategoriesNotFoundException;
use MultidocParser\Exceptions\ProjectNotDefinedException;
use MultidocParser\Exceptions\RoutesNotDefinedException;
use MultidocParser\Exceptions\UndefinedTemplateException;
use MultidocParser\Services\DIService;
use MultidocParser\Services\MultidocParserService;
use PHPUnit\Framework\TestCase;

class MultidocParserTestFeature extends TestCase
{

    protected string $dataPath = '';
    protected string $outPath = '';
    protected ProjectDto $project;
    protected MultidocParserService $parser;

    /**
     * @throws CategoriesNotFoundException
     * @throws ProjectNotDefinedException
     * @throws RoutesNotDefinedException
     * @throws UndefinedTemplateException
     */
    public function setUp(): void
    {
        if (empty($this->dataPath) || empty($this->outPath)) {
            throw new \Exception('Load the project first by setting $dataPath or $outPath');
        }
        $service = (new DIService())->load();
        $this->parser = $service->get('multidoc_parser_service');
        $this->project = $this->parser->generate($this->dataPath, $this->outPath);
    }

    /**
     * @param CategoryDto[] $categoryList
     * @param string $routeName
     * @return RouteDto
     */
    private function findRouteRecursive($categoryList, $routeName)
    {
        foreach ($categoryList as $category) {
            foreach ($category->routeList as $route) {
                if ($route->name === $routeName) {
                    return $route;
                }
            }
            if (count($category->categories)) {
                return $this->findRouteRecursive($category->categories, $routeName);
            }
        }

        $this->assertTrue(false, "No route found in project by the name:" . $routeName);
    }

    /**
     * @param string $routeName
     * @param ProjectDto $project
     */
    protected function assertRouteNameExists(string $routeName, ProjectDto $project)
    {
        $route = $this->findRouteRecursive($project->categories, $routeName);
        $this->assertEquals($routeName, $route->name);
        $this->assertTrue(true);
    }

    /**
     * @param int $count
     * @param string $routeName
     * @param ProjectDto $project
     */
    protected function assertRouteHasParamsCount(int $count, string $routeName, ProjectDto $project)
    {
        $route = $this->findRouteRecursive($project->categories, $routeName);
        $this->assertCount($count, $route->request->params);
    }

    /**
     * @param string $method
     * @param string $routeName
     * @param ProjectDto $project
     */
    protected function assertRouteHasMethod(string $method, string $routeName, ProjectDto $project)
    {
        $route = $this->findRouteRecursive($project->categories, $routeName);
        $this->assertEquals($method, $route->request->method);
    }

    /**
     * @param string $parameterName
     * @param string $routeName
     * @param ProjectDto $project
     */
    protected function assertRouteHasParameterName(string $parameterName, string $routeName, ProjectDto $project)
    {
        $route = $this->findRouteRecursive($project->categories, $routeName);
        $parameter = $this->findParameter($route, $parameterName);
        $this->assertInstanceOf(ParameterDto::class, $parameter);
    }

    /**
     * @param string $dataType
     * @param string $parameterName
     * @param string $routeName
     * @param ProjectDto $project
     */
    protected function assertRouteHasParameterType(string $dataType,string $parameterName, string $routeName, ProjectDto $project)
    {
        $route = $this->findRouteRecursive($project->categories, $routeName);
        $parameter = $this->findParameter($route, $parameterName);
        $this->assertEquals($dataType, $parameter->data_type);
    }

    /**
     * @param RouteDto $route
     * @param string $parameterName
     * @return ParameterDto|void
     */
    private function findParameter(RouteDto $route, string $parameterName)
    {
        foreach ($route->request->params as $param) {
            if ($param->name === $parameterName) {
                return $param;
            }
        }
        $this->assertTrue(false, "No parameter found by name:" . $parameterName);
    }

    /**
     * @param string $categoryName
     * @param ProjectDto $projectDto
     */
    protected function assertProjectHasCategory(string $categoryName, ProjectDto $projectDto)
    {
        $category = $this->getCategoryFromProject($categoryName, $projectDto->categories);
        $this->assertInstanceOf(CategoryDto::class,$category);
    }

    /**
     * @param string $categoryName
     * @param CategoryDto[] $categoryList
     * @return CategoryDto|void
     */
    protected function getCategoryFromProject(string $categoryName, $categoryList)
    {
        foreach ($categoryList as $category) {
            if ($category->name === $categoryName) {
                return $category;
            }
            if ($category->categories) {
                return $this->getCategoryFromProject($categoryName, $category->categories);
            }
        }
        $this->assertTrue(false, "No category:" . $categoryName);
    }

    /**
     * @param string $routeName
     * @param ProjectDto $project
     */
    protected function assertRouteHasNoTags(string $routeName, ProjectDto $project)
    {
        $route = $this->findRouteRecursive($project->categories, $routeName);
        $this->assertEmpty($route->tagList);
    }

    /**
     * @param array $tagsIn
     * @param string $routeName
     * @param ProjectDto $project
     */
    protected function assertRouteHasTags(array $tagsIn, string $routeName, ProjectDto $project)
    {
        $route = $this->findRouteRecursive($project->categories, $routeName);
        $tags = [];
        foreach ($route->tagList as $tagDto) {
            $tags[] = $tagDto->name;
        }
        $this->assertEquals($tagsIn, $tags);
    }

    /**
     * @param $count
     * @param string $routeName
     * @param ProjectDto $project
     */
    protected function assertRouteHasTagsCount($count, string $routeName, ProjectDto $project)
    {
        $route = $this->findRouteRecursive($project->categories, $routeName);
        $this->assertCount($count, $route->tagList);
    }

    /**
     * @param array $headersMap
     * @param string $routeName
     * @param ProjectDto $project
     */
    protected function assertRouteHasHeaders(array $headersMap, string $routeName, ProjectDto $project)
    {
        $route = $this->findRouteRecursive($project->categories, $routeName);
        foreach($headersMap as $headerKey=>$headerValue)
        {
            $found = false;
            foreach($route->request->headers as $header) {
                if ($header->name === $headerKey && $header->value === $headerValue) {
                    $found = true;
                    break;
                }
            }
            $this->assertTrue($found, "Missing header: " . $headerKey.':'.$headerValue);
        }
    }

    /**
     * @param string $routeName
     * @param ProjectDto $project
     */
    protected function assertRouteIsSecured(string $routeName, ProjectDto $project)
    {
        $route = $this->findRouteRecursive($project->categories, $routeName);
        $this->assertTrue($route->request->isSecured,'Route does not seem to be secured');
    }

    /**
     * @param string $routeName
     * @param ProjectDto $project
     */
    protected function assertRouteIsInsecure(string $routeName, ProjectDto $project)
    {
        $route = $this->findRouteRecursive($project->categories, $routeName);
        $this->assertFalse($route->request->isSecured,'Route seems to be secured');
    }
}