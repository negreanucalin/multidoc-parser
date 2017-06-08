<?php
/**
 * Created by PhpStorm.
 * User: KA
 * Date: 1/25/2017
 * Time: 9:53 PM
 */

namespace Multidoc\Factories;

use Multidoc\Exceptions\CategoriesNotFoundException;
use Multidoc\Exceptions\ObjectsNotLoadedException;
use Multidoc\Exceptions\ProjectNotDefinedException;
use Multidoc\Exceptions\RoutesNotDefinedException;
use Multidoc\Models\Category;
use Multidoc\Models\Project;
use Multidoc\Models\Route;

class AbstractFactory
{
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
        $generatedEntities = array(
            'project'=>null,
            'routes'=>array(),
            'categories'=>array()
        );
        if(isset($bigAssArray[ProjectFactory::PROJECT_KEY])){
            $generatedEntities['project'] = $this->projectFactory->buildProjectFromArray(
                $bigAssArray[ProjectFactory::PROJECT_KEY]
            );
        } else {
            throw new ProjectNotDefinedException();
        }
        if(isset($bigAssArray[RouteFactory::ROUTE_PLURAL_KEY])){
            $generatedEntities['routes'] = array_merge(
                $generatedEntities['routes'],
                $this->routeFactory->buildRouteListFromArray($bigAssArray[RouteFactory::ROUTE_PLURAL_KEY])
            );
        } else {
            throw new RoutesNotDefinedException();
        }
        if(isset($bigAssArray[CategoryFactory::CATEGORY_PLURAL_KEY])){
            $generatedEntities['categories'] = $this->categoryFactory->buildCategoryListFromArray(
                $bigAssArray[CategoryFactory::CATEGORY_PLURAL_KEY]
            );
        } else {
            throw new CategoriesNotFoundException();
        }
        return $generatedEntities;
    }

    public function linkObjects($generatedEntities)
    {
        if($generatedEntities['project'] instanceof Project){
            /**
             * @var $project Project
             */
            $project = $generatedEntities['project'];
            /**
             * @var $categoryList Category[]
             */
            $categoryList = $generatedEntities['categories'];
            /**
             * @var $routeList Route[]
             */
            $routeList = $generatedEntities['routes'];
            $project->setCategoryList($categoryList);
            $this->categoryFactory->assignRoutesToCategoryList(
                $categoryList,
                $routeList
            );
            return $project;
        } else {
            throw new ObjectsNotLoadedException('buildEntityListFromConfig');
        }
    }

}