<?php

namespace Multidoc\Factories;
use Multidoc\Models\Project;

class ProjectFactory
{
    const LOGO_KEY = 'logo';
    const PROJECT_KEY = 'project';

    const FILE_PATH_KEY = 'definitionFile';

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
        if(array_key_exists(self::LOGO_KEY, $projectArray)) {
            $project->setInputPath($projectArray['definitionFile']);
            $project->setLogo($projectArray[self::LOGO_KEY]);
        }
        return $project;
    }
}