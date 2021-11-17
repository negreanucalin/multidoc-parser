<?php
namespace Multidoc\Factories;

use Multidoc\DTO\ProjectDto;
use Multidoc\Exceptions\CategoriesNotFoundException;
use Multidoc\Exceptions\ProjectNotDefinedException;
use Multidoc\Exceptions\RoutesNotDefinedException;
use Multidoc\Normalizers\CategoryNormalizer;

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
    private CategoryNormalizer $categoryNormalizer;

    /**
     * AbstractFactory constructor.
     * @param RouteFactory $routeFactory
     * @param CategoryNormalizer $categoryNormalizer
     */
    public function __construct(RouteFactory $routeFactory, CategoryNormalizer $categoryNormalizer)
    {
        $this->routeFactory = $routeFactory;
        $this->categoryNormalizer = $categoryNormalizer;
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
            self::PROJECT_KEY => null,
            'routes' => array()
        );

        if (isset($bigAssArray[self::PROJECT_KEY])) {
            $bigAssArray[self::PROJECT_KEY][self::CATEGORY_PLURAL_KEY] = $bigAssArray[self::CATEGORY_PLURAL_KEY];
            $generatedEntities[self::PROJECT_KEY] = new ProjectDto($bigAssArray[self::PROJECT_KEY]);
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
        $this->categoryNormalizer->assignRoutesToCategoryList(
            $project->categories,
            $routeList
        );

        return $project;
    }

}