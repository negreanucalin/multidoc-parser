<?php

namespace Multidoc\Services;

use Multidoc\Factories\AbstractFactory;

use Multidoc\Factories\ProjectFactory;
use Multidoc\Models\Project;
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
     * @param array $fileList
     * @return Project
     */
    public function getProjectFromFileList($fileList)
    {
        $projectFile = null;
        $data = array('route_list'=>array());
        foreach ($fileList as $file) {
            try {
                $definitionArray = Yaml::parse(file_get_contents($file));
                //If the current file contains the project definition
                if(array_key_exists(ProjectFactory::PROJECT_KEY, $definitionArray)){
                    $projectFile = $file;
                }
                //If the current file contains a route definition
                if(array_key_exists('route',$definitionArray)){
                    $definitionArray['route_list'] = array($definitionArray['route']);
                    unset($definitionArray['route']);
                }
                //If the current file contains a list of routes we unify
                $data = array_merge_recursive($data, $definitionArray);
            } catch (ParseException $e) {
                printf("Unable to parse the YAML string: %s", $e->getMessage());
            }
        }
        $generatedEntities = $this->abstractFactory->buildEntityListFromConfig($data, $projectFile);
        return $this->abstractFactory->linkObjects($generatedEntities);
    }


}