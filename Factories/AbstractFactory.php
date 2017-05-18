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
     * @var array
     */
    private $generatedEntities;

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
        $this->generatedEntities = array(
            'project'=>null,
            'routes'=>array(),
            'categories'=>array()
        );
    }

    public function buildEntityListFromConfig($bigAssArray)
    {
        if(isset($bigAssArray[ProjectFactory::PROJECT_KEY])){
            $this->generatedEntities['project'] = $this->projectFactory->buildProjectFromArray($bigAssArray[ProjectFactory::PROJECT_KEY]);
        } else {
            throw new ProjectNotDefinedException();
        }
        if(isset($bigAssArray[RouteFactory::ROUTE_PLURAL_KEY])){
            $this->generatedEntities['routes'] = array_merge(
                $this->generatedEntities['routes'],
                $this->routeFactory->buildRouteListFromArray($bigAssArray[RouteFactory::ROUTE_PLURAL_KEY])
            );
        } else {
            throw new RoutesNotDefinedException();
        }
        if(isset($bigAssArray[CategoryFactory::CATEGORY_PLURAL_KEY])){
            $this->generatedEntities['categories'] = $this->categoryFactory->buildCategoryListFromArray(
                $bigAssArray[CategoryFactory::CATEGORY_PLURAL_KEY]
            );
        } else {
            throw new CategoriesNotFoundException();
        }

    }

    public function linkObjects()
    {
        if($this->generatedEntities['project'] instanceof Project){
            /**
             * @var $project Project
             */
            $project = $this->generatedEntities['project'];
            /**
             * @var $categoryList Category[]
             */
            $categoryList = $this->generatedEntities['categories'];
            /**
             * @var $routeList Route[]
             */
            $routeList = $this->generatedEntities['routes'];
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

    public function getGeneratedEntities()
    {
        return $this->generatedEntities;
    }

}