<?php

namespace Multidoc\Renderers;

use Multidoc\Models\Project;

class ProjectRenderer
{
    /**
     * ProjectRenderer constructor.
     * @param EnvironmentRenderer $envRenderer
     */
    public function __construct(EnvironmentRenderer $envRenderer)
    {
        $this->environmentRenderer = $envRenderer;
    }

    /**
     * @param Project $project
     * @return array
     */
    public function renderProject(Project $project)
    {
        $projectArr = array(
            'name'=>$project->getName(),
            'description'=>$project->getDescription(),
            'version'=>$project->getVersion(),
            'buildDate'=>(int)$project->getBuildTime()->format('U')
        );
        if($project->getEnvironmentList()){
            $projectArr['environments'] = $this->environmentRenderer->renderEnvironmentList($project->getEnvironmentList());
        }
        if($project->getLogo()){
            $projectArr['logo'] = $project->getLogo();
        }
        return $projectArr;
    }
}