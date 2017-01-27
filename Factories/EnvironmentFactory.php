<?php

namespace Multidoc\Factories;

use Multidoc\Models\Environment;

class EnvironmentFactory
{
    const ENVIRONMENT_KEY = 'environments';

    public function buildEnvironmentFromArray($name, $url)
    {
        $environment = new Environment();
        $environment->setName($name);
        $environment->setUrl($url);
        return $environment;
    }


    public function buildEnvironmentListFromArray($projectArray)
    {
        $environmentList = array();
        foreach ($projectArray as $name=>$url){
            $environmentList[]=$this->buildEnvironmentFromArray($name, $url);
        }
        return $environmentList;
    }

    public static function hasEnvironmentList($projectArray)
    {
        return array_key_exists(self::ENVIRONMENT_KEY, $projectArray);
    }
}