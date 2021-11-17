<?php
namespace Multidoc\Factories;

use Multidoc\DTO\ProjectDto;
use Multidoc\Exceptions\CategoriesNotFoundException;
use Multidoc\Exceptions\ObjectsNotLoadedException;
use Multidoc\Exceptions\ProjectNotDefinedException;
use Multidoc\Exceptions\RoutesNotDefinedException;

class AbstractFactory
{
    public const TAGS_KEY = 'tags';
    public const STATUS_PLURAL_LIST = 'status_codes';
    public const PARAMETER_TYPE_FILE = 'file';
    public const CATEGORY_PLURAL_KEY = 'categories';
    public const TEMPLATES_KEY = 'templates';

    private ProjectFactory $projectFactory;
    private RouteFactory $routeFactory;
    private CategoryFactory $categoryFactory;

    /**
     * AbstractFactory constructor.
     * @param ProjectFactory $projectFactory
     * @param RouteFactory $routeFactory
     * @param CategoryFactory $categoryFactory
     */
    public function __construct(ProjectFactory $projectFactory, RouteFactory $routeFactory, CategoryFactory $categoryFactory)
    {
        $this->projectFactory = $projectFactory;
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

        if (isset($bigAssArray[ProjectFactory::PROJECT_KEY])) {
            $generatedEntities['project'] = $this->projectFactory->buildProjectFromArray(
                $bigAssArray[ProjectFactory::PROJECT_KEY],
                $bigAssArray[self::CATEGORY_PLURAL_KEY]
            );
        } else {
            throw new ProjectNotDefinedException();
        }
        if (isset($bigAssArray[RouteFactory::ROUTE_PLURAL_KEY])) {
            $generatedEntities['routes'] = array_merge(
                $generatedEntities['routes'],
                $this->routeFactory->buildRouteListFromArray(
                    $bigAssArray[self::TEMPLATES_KEY],
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