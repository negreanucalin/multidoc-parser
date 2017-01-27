<?php

namespace Multidoc\Factories;
use Multidoc\Models\Project;

class ProjectFactory
{

    const PROJECT_KEY = 'project';

    /**
     * @var EnvironmentFactory
     */
    private $environmentFactory;

    public function __construct(EnvironmentFactory $environmentFactory)
    {
        $this->environmentFactory = $environmentFactory;
    }

    /**
     * @param $projectArray
     * @return Project
     */
    public function buildProjectFromArray($projectArray)
    {
        $project = new Project();
        $project->setBuildTime(new \DateTime());
        $project->setName($projectArray['name']);
        $project->setVersion($projectArray['version']);
        $project->setDescription($projectArray['description']);
        if(EnvironmentFactory::hasEnvironmentList($projectArray)){
            $project->setEnvironmentList(
                $this->environmentFactory->buildEnvironmentListFromArray($projectArray[EnvironmentFactory::ENVIRONMENT_KEY])
            );
        }
        return $project;
    }

    public static function isProjectDefinition($projectArray)
    {
        return array_key_exists(ProjectFactory::PROJECT_KEY, $projectArray);
    }
}