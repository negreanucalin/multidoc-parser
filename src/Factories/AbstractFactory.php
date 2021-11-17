<?php
namespace Multidoc\Factories;

use Multidoc\DTO\ProjectDto;
use Multidoc\Exceptions\CategoriesNotFoundException;
use Multidoc\Exceptions\ProjectNotDefinedException;
use Multidoc\Exceptions\RoutesNotDefinedException;

class AbstractFactory
{
    public const TAGS_KEY = 'tags';
    public const STATUS_PLURAL_LIST = 'status_codes';
    public const PARAMETER_TYPE_FILE = 'file';
    public const CATEGORY_PLURAL_KEY = 'categories';
    public const TEMPLATES_KEY = 'templates';
    public const PROJECT_KEY = 'project';
    public const FILE_PATH_KEY = 'definitionFile';

    private RouteFactory $routeFactory;
    private CategoryFactory $categoryFactory;

    /**
     * AbstractFactory constructor.
     * @param RouteFactory $routeFactory
     * @param CategoryFactory $categoryFactory
     */
    public function __construct(RouteFactory $routeFactory, CategoryFactory $categoryFactory)
    {
        $this->routeFactory = $routeFactory;
        $this->categoryFactory = $categoryFactory;
    }

    /**
     * @param array $bigAssArray
     *
     * @return array
     * @throws CategoriesNotFoundException
     * @throws ProjectNotDefinedException
     * @throws RoutesNotDefinedException
     */
    public function buildEntityListFromConfig(array $bigAssArray): array
    {
        if (!isset($bigAssArray[self::CATEGORY_PLURAL_KEY])) {
            throw new CategoriesNotFoundException();
        }

        $generatedEntities = array(
            'project' => null,
            'routes' => array()
        );

        if (isset($bigAssArray[self::PROJECT_KEY])) {
            $bigAssArray[self::PROJECT_KEY][self::CATEGORY_PLURAL_KEY] = $bigAssArray[self::CATEGORY_PLURAL_KEY];
            $generatedEntities['project'] = new ProjectDto($bigAssArray[self::PROJECT_KEY]);
        } else {
            throw new ProjectNotDefinedException();
        }
        if (isset($bigAssArray[RouteFactory::ROUTE_PLURAL_KEY])) {
            $generatedEntities['routes'] = array_merge(
                $generatedEntities['routes'],
                $this->routeFactory->buildRouteListFromArray(
                    $bigAssArray[RouteFactory::ROUTE_PLURAL_KEY]
                )
            );
        } else {
            throw new RoutesNotDefinedException();
        }
        return $generatedEntities;
    }

    public function linkObjects(ProjectDto $project, $routeList): ProjectDto
    {
        $this->categoryFactory->assignRoutesToCategoryList(
            $project->categories,
            $routeList
        );

        return $project;
    }

}