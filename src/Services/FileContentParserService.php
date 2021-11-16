<?php

namespace Multidoc\Services;

use Multidoc\DTO\ProjectDto;
use Multidoc\Exceptions\ObjectsNotLoadedException;
use Multidoc\Factories\AbstractFactory;
use Multidoc\Factories\ProjectFactory;
use Multidoc\Factories\RouteFactory;
use SplFileObject;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class FileContentParserService
{
    /**
     * @var AbstractFactory
     */
    private $abstractFactory;

    public function __construct(AbstractFactory $abstractFactory)
    {
        $this->abstractFactory = $abstractFactory;
    }

    /**
     * Array with paths pointing to the input configuration file list
     * @param SplFileObject[] $fileList
     * @return ProjectDto
     * @throws ObjectsNotLoadedException
     */
    public function getProjectFromFileList(array $fileList):ProjectDto
    {
        $data = array(
            'route_list' => array()
        );
        foreach ($fileList as $file) {
            try {
                $definitionArray = Yaml::parse(file_get_contents($file));
                //If the current file contains the project definition
                if (array_key_exists(ProjectFactory::PROJECT_KEY, $definitionArray)) {
                    $definitionArray[ProjectFactory::PROJECT_KEY][ProjectFactory::FILE_PATH_KEY] = $file->getPath();
                }
                //If the current file contains a route definition
                if (array_key_exists(RouteFactory::ROUTE_SINGULAR_KEY, $definitionArray)) {
                    $definitionArray[RouteFactory::ROUTE_PLURAL_KEY] = array($definitionArray['route']);
                    $definitionArray[RouteFactory::ROUTE_SINGULAR_KEY][RouteFactory::FILE_PATH_KEY] = $file->getPath();
                    unset($definitionArray[RouteFactory::ROUTE_SINGULAR_KEY]);
                }
                //We inject the file path
                if (array_key_exists(RouteFactory::ROUTE_PLURAL_KEY, $definitionArray)) {
                    $definitionArray = $this->hydrateFilesToRouteDefinitionList($definitionArray, $file);
                }
                //If the current file contains a list of routes we unify
                $data = array_merge_recursive($data, $definitionArray);
            } catch (ParseException $e) {
                printf("Unable to parse the YAML string: %s", $e->getMessage());
            }
        }
        $generatedEntities = $this->abstractFactory->buildEntityListFromConfig($data);

        if (!$generatedEntities['project'] instanceof ProjectDto) {
            throw new ObjectsNotLoadedException('buildEntityListFromConfig');
        }

        return $this->abstractFactory->linkObjects(
            $generatedEntities['project'],
            $generatedEntities['routes']
        );
    }

    /**
     * This method adds a file path to the given route list in order to keep track of files
     * which it might use for POST requests
     *
     * @param $routeDefinitionList
     * @param SplFileObject $file
     * @return mixed
     */
    private function hydrateFilesToRouteDefinitionList($routeDefinitionList, $file)
    {
        foreach ($routeDefinitionList[RouteFactory::ROUTE_PLURAL_KEY] as $key => $routeDefinition) {
            $routeDefinitionList[RouteFactory::ROUTE_PLURAL_KEY][$key][RouteFactory::FILE_PATH_KEY] = $file->getPath();
        }
        return $routeDefinitionList;
    }

}