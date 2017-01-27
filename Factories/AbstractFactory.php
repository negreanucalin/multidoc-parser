<?php
/**
 * Created by PhpStorm.
 * User: KA
 * Date: 1/25/2017
 * Time: 9:53 PM
 */

namespace Multidoc\Factories;


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
        foreach($bigAssArray as $entityListKey=>$entityDataArray){
            switch($entityListKey){
                case ProjectFactory::PROJECT_KEY:
                    $this->generatedEntities['project'] = $this->projectFactory->buildProjectFromArray($entityDataArray);
                    break;
                case RouteFactory::ROUTE_PLURAL_KEY:
                    $this->generatedEntities['routes'] = array_merge(
                        $this->generatedEntities['routes'],
                        $this->routeFactory->buildRouteListFromArray($entityDataArray)
                    );
                    break;
                case CategoryFactory::CATEGORY_PLURAL_KEY:
                    $this->generatedEntities['categories'] = $this->categoryFactory->buildCategoryListFromArray(
                        $entityDataArray
                    );
                    break;
            }
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
        }
        return null;
    }

    public function getGeneratedEntities()
    {
        return $this->generatedEntities;
    }

}