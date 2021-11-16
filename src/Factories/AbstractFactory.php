<?php
/**
 * Created by PhpStorm.
 * User: KA
 * Date: 1/25/2017
 * Time: 9:53 PM
 */

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
    public const AUTHORIZATION_KEY = 'secured';
    public const PARAMETER_PLURAL_KEY = 'params';
    public const PARAMETER_TYPE_FILE = 'file';
    /**
     * @var ProjectFactory
     */
    private $projectFactory;

    /**
     * @var RouteFactory
     */
    private $routeFactory;

    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

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
     * @param \SplFileObject $projectFile
     *
     * @return array
     * @throws CategoriesNotFoundException
     * @throws ProjectNotDefinedException
     * @throws RoutesNotDefinedException
     */
    public function buildEntityListFromConfig($bigAssArray)
    {
        if (!isset($bigAssArray[CategoryFactory::CATEGORY_PLURAL_KEY])) {
            throw new CategoriesNotFoundException();
        }

        $generatedEntities = array(
            'project' => null,
            'routes' => array(),
            'categories' => array()
        );
        if (isset($bigAssArray[ProjectFactory::PROJECT_KEY])) {
            $generatedEntities['project'] = $this->projectFactory->buildProjectFromArray(
                $bigAssArray[ProjectFactory::PROJECT_KEY],
                $bigAssArray[CategoryFactory::CATEGORY_PLURAL_KEY]
            );
            $generatedEntities['categories'] = $generatedEntities['project']->categoryList;
        } else {
            throw new ProjectNotDefinedException();
        }
        if (isset($bigAssArray[RouteFactory::ROUTE_PLURAL_KEY])) {
            $generatedEntities['routes'] = array_merge(
                $generatedEntities['routes'],
                $this->routeFactory->buildRouteListFromArray($bigAssArray[RouteFactory::ROUTE_PLURAL_KEY])
            );
        } else {
            throw new RoutesNotDefinedException();
        }
        return $generatedEntities;
    }

    /**
     * @throws ObjectsNotLoadedException
     */
    public function linkObjects($generatedEntities)
    {
        if (!$generatedEntities['project'] instanceof ProjectDto) {
            throw new ObjectsNotLoadedException('buildEntityListFromConfig');
        }

        $this->categoryFactory->assignRoutesToCategoryList(
            $generatedEntities['project']->categoryList,
            $generatedEntities['routes']
        );

        return $generatedEntities['project'];
    }

}