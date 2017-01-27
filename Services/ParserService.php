<?php

namespace Multidoc\Services;

use Multidoc\Factories\AbstractFactory;
use Multidoc\Factories\ProjectFactory;
use Multidoc\Models\Project;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class ParserService
{
    /**
     * @var AbstractFactory
     */
    private $abstractFactory;

    /**
     * @var array
     */
    private $data;

    public function __construct(AbstractFactory $abstractFactory)
    {
        $this->abstractFactory = $abstractFactory;
        $this->data = array('route_list'=>array());
    }

    /**
     * Array with paths pointing to the input configuration file list
     * @param array $fileList
     * @return Project|null
     */
    public function loadApiInput($fileList)
    {
        foreach ($fileList as $file) {
            try {
                $definitionArray = Yaml::parse(file_get_contents($file));
                if(array_key_exists('route',$definitionArray)){
                    $definitionArray['route_list'] = array($definitionArray['route']);
                    unset($definitionArray['route']);
                }
                $this->data = array_merge_recursive($this->data, $definitionArray);
            } catch (ParseException $e) {
                printf("Unable to parse the YAML string: %s", $e->getMessage());
            }
        }

        $this->abstractFactory->buildEntityListFromConfig($this->data);
        $project = $this->abstractFactory->linkObjects();
        return $project;
    }


}