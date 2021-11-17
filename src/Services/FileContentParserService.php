<?php

namespace Multidoc\Services;

use Multidoc\DTO\ProjectDto;
use Multidoc\Exceptions\ObjectsNotLoadedException;
use Multidoc\Factories\AbstractFactory;
use Multidoc\Factories\ProjectFactory;
use Multidoc\Factories\RouteFactory;
use SplFileObject;
use Symfony\Component\Yaml\Yaml;

class FileContentParserService
{
    /**
     * @var AbstractFactory
     */
    private AbstractFactory $abstractFactory;

    private DataNormalizerService $dataNormalizer;

    public function __construct(AbstractFactory $abstractFactory, DataNormalizerService $dataNormalizer)
    {
        $this->abstractFactory = $abstractFactory;
        $this->dataNormalizer = $dataNormalizer;
    }

    /**
     * Array with paths pointing to the input configuration file list
     * @param SplFileObject[] $fileList
     * @return ProjectDto
     * @throws ObjectsNotLoadedException
     */
    public function getProjectFromFileList(array $fileList): ProjectDto
    {
        $data = $this->readFiles($fileList);
        $data[RouteFactory::ROUTE_PLURAL_KEY] = $this->dataNormalizer->formatHeaders($data[RouteFactory::ROUTE_PLURAL_KEY]);
        $data[RouteFactory::ROUTE_PLURAL_KEY] = $this->dataNormalizer->fillInTemplates($data['templates'], $data[RouteFactory::ROUTE_PLURAL_KEY]);
        $data[AbstractFactory::PROJECT_KEY] = $this->dataNormalizer->normalizeProjectData($data[AbstractFactory::PROJECT_KEY]);
        $data[AbstractFactory::CATEGORY_PLURAL_KEY] = $this->dataNormalizer->normalizeCategoryList($data[AbstractFactory::CATEGORY_PLURAL_KEY]);

        $generatedEntities = $this->abstractFactory->buildEntityListFromConfig($data);

        if (!$generatedEntities['project'] instanceof ProjectDto) {
            throw new ObjectsNotLoadedException('buildEntityListFromConfig');
        }

        return $this->abstractFactory->linkObjects(
            $generatedEntities['project'],
            $generatedEntities['routes']
        );
    }

    private function readFiles($fileList)
    {
        $data = array(
            'templates' => []
        );

        foreach ($fileList as $file) {
            $definitionArray = Yaml::parse(file_get_contents($file));
            //If the current file contains the project definition
            if (array_key_exists(AbstractFactory::PROJECT_KEY, $definitionArray)) {
                $definitionArray[AbstractFactory::PROJECT_KEY][AbstractFactory::FILE_PATH_KEY] = $file->getPath();
            }
            //If the current file contains a route definition
            if (array_key_exists(RouteFactory::ROUTE_SINGULAR_KEY, $definitionArray)) {
                $definitionArray[RouteFactory::ROUTE_PLURAL_KEY] = array($definitionArray['route']);
                $definitionArray[RouteFactory::ROUTE_SINGULAR_KEY][RouteFactory::FILE_PATH_KEY] = $file->getPath();
                unset($definitionArray[RouteFactory::ROUTE_SINGULAR_KEY]);
            }
            //We inject the file path
            if (array_key_exists(RouteFactory::ROUTE_PLURAL_KEY, $definitionArray)) {
                $definitionArray = $this->dataNormalizer->hydrateFilesToRouteDefinitionList($definitionArray, $file);
            }
            //If the current file contains a list of routes we unify
            $data = array_merge_recursive($data, $definitionArray);
        }

        return $data;
    }

}